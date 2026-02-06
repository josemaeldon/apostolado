# Apostolado da Oração

Sistema de gerenciamento de conteúdo completo para o Apostolado da Oração, desenvolvido com Laravel 11 e PostgreSQL.

## 📋 Sobre o Projeto

Este é um site completamente gerenciável em **Português do Brasil (pt-BR)** inspirado no site da [Rede Mundial de Oração do Papa](https://redemundialdeoracaodopapa.pt), permitindo a administração de conteúdo para o Apostolado da Oração de forma simples e intuitiva.

## ✨ Funcionalidades

- 🔐 **Sistema de Autenticação** - Controle de acesso administrativo
- 📄 **Páginas Dinâmicas** - Criação e edição de páginas do site
- 🙏 **Intenções de Oração** - Gerenciamento das intenções mensais do Papa
- 📰 **Notícias e Artigos** - Sistema completo de publicação de conteúdo
- 📅 **Calendário de Eventos** - Gestão de eventos e atividades
- 🖼️ **Galeria de Mídia** - Gerenciamento de imagens e vídeos
- 🌐 **100% em Português do Brasil** - Interface totalmente em pt-BR
- 📱 **Design Responsivo** - Funciona perfeitamente em dispositivos móveis

## 🛠️ Tecnologias Utilizadas

- **Laravel 11** - Framework PHP moderno e robusto
- **PostgreSQL** - Banco de dados relacional
- **Blade** - Sistema de templates do Laravel
- **Vite** - Build tool para assets frontend
- **Tailwind CSS** - Framework CSS utilitário (a ser configurado)

## 📦 Requisitos

- PHP 8.2 ou superior
- Composer
- PostgreSQL 13 ou superior
- Node.js 18 ou superior
- NPM ou Yarn

## 🚀 Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/josemaeldon/apostolado.git
cd apostolado
```

### 2. Instale as Dependências PHP

```bash
composer install
```

### 3. Configure o Ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o Banco de Dados

Edite o arquivo `.env` com suas credenciais do PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=apostolado
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Crie o Banco de Dados

```bash
createdb apostolado
# ou usando psql:
# psql -U postgres -c "CREATE DATABASE apostolado;"
```

### 6. Execute as Migrações

```bash
php artisan migrate
```

### 7. Popule o Banco (Opcional)

```bash
php artisan db:seed
```

### 8. Instale as Dependências Frontend

```bash
npm install
```

### 9. Compile os Assets

```bash
npm run dev
# Para produção: npm run build
```

### 10. Inicie o Servidor

```bash
php artisan serve
```

Acesse o site em: `http://localhost:8000`

## 🐳 Instalação com Docker (Recomendado para Self-Hosted)

### 1. Configure as Variáveis de Ambiente

```bash
cp .env.example .env
# Edite o .env conforme necessário
```

### 2. Inicie os Containers

```bash
docker-compose up -d
```

### 3. Execute as Migrações

```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

O site estará disponível em: `http://localhost:8000`

## 📖 Documentação de Uso

### Painel Administrativo

Acesse `/admin` para gerenciar o conteúdo do site. Você precisará fazer login com as credenciais de administrador.

### Gerenciamento de Conteúdo

- **Páginas**: Crie e edite páginas estáticas do site
- **Intenções**: Adicione as intenções mensais do Papa
- **Notícias**: Publique artigos e notícias
- **Eventos**: Gerencie o calendário de atividades
- **Galeria**: Faça upload e organize fotos e vídeos

## 🔧 Manutenção

### Backup do Banco de Dados

```bash
pg_dump -U postgres apostolado > backup_$(date +%Y%m%d).sql
```

### Restaurar Backup

```bash
psql -U postgres apostolado < backup_20240101.sql
```

### Atualizar o Sistema

```bash
git pull origin main
composer install
php artisan migrate
npm install && npm run build
php artisan cache:clear
php artisan config:clear
```

## 🤝 Contribuindo

Contribuições são bem-vindas! Por favor, siga estas etapas:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Suporte

Para suporte ou dúvidas, entre em contato através de:
- Email: [seu-email@exemplo.com]
- Issues: [GitHub Issues](https://github.com/josemaeldon/apostolado/issues)

## 🙏 Agradecimentos

Inspirado no trabalho da [Rede Mundial de Oração do Papa](https://redemundialdeoracaodopapa.pt).

---

**Desenvolvido com ❤️ para o Apostolado da Oração**
