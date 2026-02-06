# Guia de Deployment - Apostolado da Oração

Este guia fornece instruções passo a passo para fazer o deployment do sistema Apostolado da Oração em um servidor self-hosted.

## 📋 Requisitos do Servidor

### Mínimos
- Ubuntu 20.04 LTS ou superior (ou outra distro Linux)
- 2GB RAM
- 20GB de espaço em disco
- PHP 8.2+
- PostgreSQL 13+
- Nginx ou Apache
- Node.js 18+
- Composer

### Recomendados
- 4GB RAM ou mais
- 40GB+ de espaço em disco
- SSL/TLS (Let's Encrypt)
- Backup automático configurado

## 🐳 Opção 1: Deploy com Docker (Recomendado)

### 1. Instale o Docker e Docker Compose

```bash
# Instalar Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Instalar Docker Compose
sudo apt-get update
sudo apt-get install docker-compose-plugin

# Adicionar usuário ao grupo docker
sudo usermod -aG docker $USER
newgrp docker
```

### 2. Clone o Repositório

```bash
git clone https://github.com/josemaeldon/apostolado.git
cd apostolado
```

### 3. Configure as Variáveis de Ambiente

```bash
cp .env.example .env
nano .env
```

Edite as seguintes variáveis:

```env
APP_NAME="Apostolado da Oração"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=apostolado
DB_USERNAME=postgres
DB_PASSWORD=SenhaSeguraAqui123!
```

### 4. Inicie os Containers

```bash
# Build e start dos containers
docker-compose up -d

# Verificar se os containers estão rodando
docker-compose ps
```

### 5. Execute as Migrações e Seeds

```bash
# Executar migrações
docker-compose exec app php artisan migrate --force

# Popular com dados de demonstração
docker-compose exec app php artisan db:seed --force

# Gerar chave da aplicação (se ainda não foi feito)
docker-compose exec app php artisan key:generate
```

### 6. Configure Permissões

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### 7. Acesse o Sistema

Acesse `http://seu-servidor:8000` para ver o site.

**Credenciais do Administrador:**
- Email: `admin@apostolado.com`
- Senha: `password`

⚠️ **IMPORTANTE**: Altere a senha do administrador imediatamente após o primeiro login!

## 🖥️ Opção 2: Deploy Manual (Sem Docker)

### 1. Instale as Dependências do Sistema

```bash
sudo apt update
sudo apt install -y nginx postgresql postgresql-contrib php8.3 php8.3-fpm \
    php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-bcmath \
    php8.3-curl php8.3-zip php8.3-gd php8.3-intl \
    git curl unzip nodejs npm
```

### 2. Instale o Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

### 3. Configure o PostgreSQL

```bash
# Acessar PostgreSQL
sudo -u postgres psql

# Criar database e usuário
CREATE DATABASE apostolado;
CREATE USER apostolado_user WITH ENCRYPTED PASSWORD 'SenhaSeguraAqui123!';
GRANT ALL PRIVILEGES ON DATABASE apostolado TO apostolado_user;
\q
```

### 4. Clone e Configure o Projeto

```bash
# Clone o repositório
cd /var/www
sudo git clone https://github.com/josemaeldon/apostolado.git
cd apostolado

# Configure permissões
sudo chown -R www-data:www-data /var/www/apostolado
sudo chmod -R 755 /var/www/apostolado

# Instale dependências PHP
sudo -u www-data composer install --no-dev --optimize-autoloader

# Configure o .env
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

Configure as variáveis no `.env`:

```env
APP_NAME="Apostolado da Oração"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=apostolado
DB_USERNAME=apostolado_user
DB_PASSWORD=SenhaSeguraAqui123!
```

### 5. Finalize a Configuração do Laravel

```bash
# Gerar chave da aplicação
sudo -u www-data php artisan key:generate

# Executar migrações
sudo -u www-data php artisan migrate --force

# Popular banco de dados
sudo -u www-data php artisan db:seed --force

# Otimizar para produção
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Instalar dependências Node e compilar assets
sudo -u www-data npm install
sudo -u www-data npm run build

# Configurar permissões de storage
sudo chmod -R 775 storage bootstrap/cache
```

### 6. Configure o Nginx

```bash
sudo nano /etc/nginx/sites-available/apostolado
```

Adicione esta configuração:

```nginx
server {
    listen 80;
    server_name seu-dominio.com.br;
    root /var/www/apostolado/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Ative o site:

```bash
sudo ln -s /etc/nginx/sites-available/apostolado /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 7. Configure SSL com Let's Encrypt (Recomendado)

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-nginx

# Obter certificado SSL
sudo certbot --nginx -d seu-dominio.com.br
```

## 🔐 Segurança Pós-Deployment

### 1. Altere Credenciais Padrão

Faça login com `admin@apostolado.com` / `password` e **altere a senha imediatamente**.

### 2. Configure Firewall

```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
```

### 3. Configure Backup Automático

Crie um script de backup:

```bash
sudo nano /usr/local/bin/backup-apostolado.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/backups/apostolado"
DATE=$(date +%Y%m%d_%H%M%S)

# Criar diretório de backup
mkdir -p $BACKUP_DIR

# Backup do banco de dados
pg_dump -U apostolado_user apostolado > $BACKUP_DIR/db_$DATE.sql

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/apostolado/storage

# Manter apenas os últimos 7 dias
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

Torne executável e agende no cron:

```bash
sudo chmod +x /usr/local/bin/backup-apostolado.sh
sudo crontab -e

# Adicione esta linha para backup diário às 3h
0 3 * * * /usr/local/bin/backup-apostolado.sh
```

## 🔄 Atualizações

Para atualizar o sistema:

```bash
cd /var/www/apostolado
sudo -u www-data git pull origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data npm install && npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo systemctl restart php8.3-fpm
```

## 📧 Configuração de Email

Para enviar emails (recuperação de senha, etc), configure no `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.seu-provedor.com.br
MAIL_PORT=587
MAIL_USERNAME=seu-email@dominio.com.br
MAIL_PASSWORD=senha-do-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seu-dominio.com.br
MAIL_FROM_NAME="${APP_NAME}"
```

## 🐛 Troubleshooting

### Erro 500 - Internal Server Error

```bash
# Verificar logs
tail -f /var/www/apostolado/storage/logs/laravel.log

# Verificar permissões
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Erro de Conexão com Banco de Dados

```bash
# Verificar se PostgreSQL está rodando
sudo systemctl status postgresql

# Testar conexão
psql -U apostolado_user -d apostolado -h localhost
```

### Assets não carregam (CSS/JS)

```bash
# Recompilar assets
sudo -u www-data npm run build

# Limpar cache
sudo -u www-data php artisan cache:clear
```

## 📞 Suporte

Para problemas ou dúvidas:
- GitHub Issues: https://github.com/josemaeldon/apostolado/issues
- Email: suporte@apostoladodaoracao.org.br

---

**Desenvolvido com ❤️ para o Apostolado da Oração**
