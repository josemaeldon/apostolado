# Apostolado da Oração

Sistema de gerenciamento de conteúdo completo para o Apostolado da Oração, desenvolvido com Laravel 11 e PostgreSQL.

## 📋 Sobre o Projeto

Este é um site completamente gerenciável em **Português do Brasil (pt-BR)** inspirado no site da [Rede Mundial de Oração do Papa](https://redemundialdeoracaodopapa.pt).

## 🚀 Instalação Rápida

```bash
# Clone o repositório
git clone https://github.com/josemaeldon/apostolado.git
cd apostolado

# Instale dependências
composer install
npm install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Configure o banco PostgreSQL no .env e execute:
php artisan migrate
php artisan db:seed

# Inicie o servidor
php artisan serve
```

📖 **[Documentação completa em README.pt-BR.md](README.pt-BR.md)**

## ✨ Funcionalidades

- 🔐 Sistema de Autenticação
- 📄 Páginas Dinâmicas
- 🙏 Intenções de Oração
- 📰 Notícias e Artigos
- 📅 Calendário de Eventos
- 🖼️ Galeria de Mídia
- 🌐 100% em Português do Brasil

## 🛠️ Tecnologias

- Laravel 11
- PostgreSQL
- Vite + Tailwind CSS
- Blade Templates

---

**Desenvolvido com ❤️ para o Apostolado da Oração**
