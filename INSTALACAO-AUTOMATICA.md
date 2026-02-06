# 🚀 Guia de Instalação Automática

Este guia explica como usar o **Autoinstalador Web** e a **Imagem Docker** do Apostolado da Oração.

## 📦 Opção 1: Usando a Imagem Docker do GitHub

A maneira mais fácil e rápida de começar!

### Passo 1: Pull da Imagem

```bash
docker pull ghcr.io/josemaeldon/apostolado:latest
```

### Passo 2: Criar rede e banco de dados

```bash
# Criar rede Docker
docker network create apostolado-network

# Criar container PostgreSQL
docker run -d \
  --name apostolado-db \
  --network apostolado-network \
  -e POSTGRES_DB=apostolado \
  -e POSTGRES_USER=postgres \
  -e POSTGRES_PASSWORD=senhasegura \
  -v apostolado-db-data:/var/lib/postgresql/data \
  postgres:15-alpine
```

### Passo 3: Executar a aplicação

```bash
docker run -d \
  --name apostolado-app \
  --network apostolado-network \
  -p 80:80 \
  -e DB_HOST=apostolado-db \
  -e DB_PORT=5432 \
  -e DB_DATABASE=apostolado \
  -e DB_USERNAME=postgres \
  -e DB_PASSWORD=senhasegura \
  ghcr.io/josemaeldon/apostolado:latest
```

### Passo 4: Acessar o Instalador

Abra seu navegador e acesse:
```
http://localhost/install
```

Siga as 4 etapas do instalador web! 🎉

---

## 🌐 Opção 2: Instalador Web (Instalação Local)

### Pré-requisitos

- PHP 8.2+
- PostgreSQL 13+
- Composer
- Node.js 18+

### Passo 1: Preparar o Ambiente

```bash
# Clone o repositório
git clone https://github.com/josemaeldon/apostolado.git
cd apostolado

# Instale dependências
composer install
npm install && npm run build

# Copie o .env
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure permissões
chmod -R 775 storage bootstrap/cache
```

### Passo 2: Criar Banco de Dados

```bash
# Conecte ao PostgreSQL
psql -U postgres

# Crie o banco de dados
CREATE DATABASE apostolado;
\q
```

### Passo 3: Iniciar Servidor

```bash
php artisan serve
```

### Passo 4: Acessar o Instalador

Abra seu navegador e acesse:
```
http://localhost:8000/install
```

---

## 🎯 Usando o Autoinstalador Web

O instalador web guiará você através de 4 etapas simples:

### Etapa 1: Requisitos do Sistema ✅

O instalador verifica automaticamente:
- ✅ Versão do PHP (mínimo 8.2)
- ✅ Extensões PHP necessárias:
  - PDO
  - PDO PostgreSQL
  - Mbstring
  - Zip
  - cURL
  - GD

**Se algo estiver faltando**, instruções de instalação serão exibidas.

### Etapa 2: Permissões de Pastas 📁

Verifica se estas pastas e arquivos têm permissão de escrita:
- `storage/framework`
- `storage/logs`
- `storage/app`
- `bootstrap/cache`
- `.env` (arquivo de configuração)

**Se houver problemas**, comandos para corrigir são exibidos:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod 664 .env
chown www-data:www-data .env
```

**Nota:** Em ambientes Docker, o arquivo `.env` é criado automaticamente pelo entrypoint se não existir.

### Etapa 3: Configuração do Banco de Dados 🗄️

Insira as credenciais do seu PostgreSQL:
- **Host:** 127.0.0.1 (ou localhost)
- **Porta:** 5432 (padrão)
- **Nome do Banco:** apostolado
- **Usuário:** postgres
- **Senha:** (sua senha)

**Recursos:**
- ✅ Teste de conexão antes de salvar
- ✅ Salvamento automático no `.env`
- ✅ Feedback em tempo real

### Etapa 4: Criar Administrador 👤

Configure o sistema e crie o administrador:

**Nome do Site:**
- Personalize o nome (ex: "Apostolado da Oração - São Paulo")

**Dados do Administrador:**
- Nome completo
- Email (usado para login)
- Senha (mínimo 8 caracteres)
- Confirmação de senha

**O que acontece ao concluir:**
1. ✅ Configurações salvas no `.env`
2. ✅ **Migrations executadas automaticamente**
3. ✅ **Tabelas do banco criadas automaticamente**
4. ✅ **Usuário administrador criado**
5. ✅ Cache otimizado
6. ✅ Sistema marcado como instalado

**Você será redirecionado para a página de login automaticamente!**

---

## 🎉 Após a Instalação

### Fazer Login

1. Acesse: `http://seu-site.com/login`
2. Use o email e senha do administrador criados
3. Você será direcionado ao painel!

### O que você pode fazer:

- ✅ Gerenciar conteúdo do site
- ✅ Adicionar intenções de oração
- ✅ Publicar notícias e artigos
- ✅ Criar eventos
- ✅ Gerenciar usuários
- ✅ Personalizar páginas

---

## 🔒 Segurança

### Após a Instalação:

1. ⚠️ **IMPORTANTE:** O instalador só funciona na primeira execução
2. ✅ Um arquivo `storage/installed` é criado
3. ✅ Tentativas de acessar `/install` são redirecionadas automaticamente
4. ✅ O sistema está protegido contra reinstalação acidental

### Para Reinstalar (se necessário):

```bash
# ATENÇÃO: Isso apagará todos os dados!
php artisan migrate:fresh
rm storage/installed
```

---

## 🐳 Workflow GitHub Actions

### Build Automático

Toda vez que você fizer push para `main`, o GitHub Actions:

1. ✅ Compila a imagem Docker
2. ✅ Otimiza com multi-stage build
3. ✅ Publica no GitHub Container Registry
4. ✅ Cria tags automáticas:
   - `latest` - Última versão da branch main
   - `v1.0.0` - Tags de release
   - `main` - Branch principal

### Usar Versões Específicas

```bash
# Última versão
docker pull ghcr.io/josemaeldon/apostolado:latest

# Versão específica (quando disponível)
docker pull ghcr.io/josemaeldon/apostolado:v1.0.0

# Branch específica
docker pull ghcr.io/josemaeldon/apostolado:main
```

---

## 🔧 Troubleshooting

### Erro: "Não foi possível conectar ao banco de dados"

**Solução:**
- Verifique se o PostgreSQL está rodando
- Confirme host, porta, usuário e senha
- Teste a conexão manualmente:
  ```bash
  psql -h 127.0.0.1 -U postgres -d apostolado
  ```

### Erro: "Permissões negadas" ou "file_put_contents(.env): Failed to open stream"

**Causa:** O arquivo `.env` não existe ou não tem permissão de escrita.

**Solução 1 - Desenvolvimento Local:**
```bash
# Criar arquivo .env se não existir
cp .env.example .env

# Configurar permissões
chmod 664 .env
sudo chown www-data:www-data .env
```

**Solução 2 - Docker:**
```bash
# Parar o container
docker stop apostolado-app

# Remover container
docker rm apostolado-app

# Reconstruir a imagem (se necessário)
docker build -t apostolado .

# Iniciar novamente - o entrypoint criará o .env automaticamente
docker run -d --name apostolado-app ...
```

**Nota:** A partir da versão com entrypoint, o arquivo `.env` é criado automaticamente no início do container se não existir.

### Erro: "Extensão PHP não encontrada"

**Solução no Ubuntu/Debian:**
```bash
sudo apt install php8.3-pgsql php8.3-mbstring php8.3-zip php8.3-gd
sudo systemctl restart php8.3-fpm
```

### Preciso reinstalar

**Solução:**
```bash
# Backup primeiro!
php artisan db:seed --class=BackupSeeder

# Limpar instalação
php artisan migrate:fresh
rm storage/installed

# Acesse /install novamente
```

---

## 📞 Suporte

Problemas com o instalador?

- **GitHub Issues:** https://github.com/josemaeldon/apostolado/issues
- **Email:** suporte@apostoladodaoracao.org.br

---

## ✨ Recursos do Instalador

- ✅ **Interface 100% em Português**
- ✅ **Zero configuração manual**
- ✅ **Validação em tempo real**
- ✅ **Feedback visual claro**
- ✅ **Proteção contra reinstalação**
- ✅ **Migrations automáticas**
- ✅ **Admin criado automaticamente**
- ✅ **Pronto para uso imediato**

---

**Desenvolvido com ❤️ para o Apostolado da Oração**  
**100% em Português do Brasil 🇧🇷**
