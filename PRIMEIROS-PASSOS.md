# 🚀 Primeiros Passos - Apostolado da Oração

Guia rápido para começar a usar o sistema!

## ✅ Instalação Completa

Você acaba de instalar o sistema Apostolado da Oração. Aqui estão os próximos passos.

## 🔐 1. Primeiro Acesso

### Credenciais Padrão:
- **Email:** admin@apostolado.com
- **Senha:** password

⚠️ **IMPORTANTE:** Altere estas credenciais imediatamente!

### Como Alterar a Senha:

1. Faça login com as credenciais acima
2. Clique no seu nome no canto superior direito
3. Selecione "Perfil"
4. Na seção "Atualizar Senha", insira:
   - Senha atual: `password`
   - Nova senha: (escolha uma senha forte)
   - Confirme a nova senha
5. Clique em "Salvar"

## 📝 2. Explorando o Conteúdo de Demonstração

O sistema vem com conteúdo de exemplo para você entender como funciona:

### Páginas Criadas:
- ✅ Sobre o Apostolado da Oração
- ✅ Nossa Missão

### Intenções de Oração:
- ✅ Janeiro 2026: Pelos Evangelizadores
- ✅ Fevereiro 2026: Pelo Fim do Tráfico Humano

### Artigos/Notícias:
- ✅ Papa Francisco convida jovens para a oração
- ✅ O Sagrado Coração de Jesus: Fonte de Amor

### Eventos:
- ✅ Encontro Mensal de Oração
- ✅ Retiro Espiritual

## 🎨 3. Personalizando o Site

### Alterar o Nome do Site:

Edite o arquivo `.env`:
```env
APP_NAME="Seu Nome Personalizado"
```

Depois execute:
```bash
php artisan config:clear
```

### Alterar Cores e Estilo:

As cores estão definidas em `resources/views/welcome.blade.php` usando Tailwind CSS.

Por exemplo, para mudar a cor principal de `indigo` para `blue`:
- Busque por `indigo-600` e substitua por `blue-600`
- Busque por `indigo-50` e substitua por `blue-50`

## 📊 4. Estrutura do Banco de Dados

O sistema tem as seguintes tabelas:

| Tabela | Descrição |
|--------|-----------|
| users | Usuários do sistema |
| pages | Páginas estáticas do site |
| prayer_intentions | Intenções mensais de oração |
| articles | Notícias e artigos |
| events | Eventos e calendário |
| media_galleries | Galeria de mídia |

## 🛠️ 5. Tarefas Administrativas

### Adicionar Novos Usuários

Atualmente, novos usuários podem se registrar através da página de registro. Para tornar um usuário administrador:

```bash
php artisan tinker
```

Depois execute:
```php
$user = User::where('email', 'email@usuario.com')->first();
$user->is_admin = true;
$user->save();
```

### Limpar Cache

Sempre que fizer mudanças em configurações:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Ver Logs de Erro

```bash
tail -f storage/logs/laravel.log
```

## 🎯 6. Próximos Passos Recomendados

### Curto Prazo:
1. ✅ Alterar senha do administrador
2. ✅ Personalizar informações do site (nome, cores)
3. ✅ Revisar e editar o conteúdo de demonstração
4. ✅ Configurar email (para recuperação de senha)
5. ✅ Configurar SSL (HTTPS)

### Médio Prazo:
1. 📝 Implementar painel administrativo (CRUD)
2. 🖼️ Adicionar sistema de upload de imagens
3. 📰 Criar páginas públicas para exibir conteúdo
4. 🔍 Implementar sistema de busca
5. 📧 Adicionar formulário de contato

### Longo Prazo:
1. 🌍 Adicionar mais idiomas (multi-language)
2. 📱 Criar aplicativo mobile
3. 🔔 Sistema de notificações
4. 📊 Painel de estatísticas
5. 🎥 Integração com vídeos (YouTube)

## 📚 7. Recursos e Documentação

- **README.md** - Visão geral rápida
- **README.pt-BR.md** - Documentação completa em português
- **DEPLOYMENT.md** - Guia de deployment detalhado
- **SECURITY.md** - Análise de segurança

## ❓ 8. Perguntas Frequentes

### Como adicionar uma nova página?

Atualmente o sistema tem a estrutura de banco de dados pronta. Para adicionar através do código:

```php
use App\Models\Page;

Page::create([
    'title' => 'Título da Página',
    'slug' => 'titulo-da-pagina',
    'content' => '<p>Conteúdo em HTML</p>',
    'is_published' => true,
    'order' => 1,
    'user_id' => auth()->id(),
]);
```

### Como adicionar uma nova intenção de oração?

```php
use App\Models\PrayerIntention;

PrayerIntention::create([
    'title' => 'Título da Intenção',
    'description' => 'Descrição completa...',
    'month' => 'março',
    'year' => 2026,
    'is_published' => true,
    'user_id' => auth()->id(),
]);
```

### Como fazer backup do banco de dados?

```bash
# PostgreSQL
pg_dump -U postgres apostolado > backup.sql

# Restaurar
psql -U postgres apostolado < backup.sql
```

### O sistema está lento, o que fazer?

```bash
# Otimizar para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 💬 9. Suporte

Precisa de ajuda? Entre em contato:

- **GitHub Issues:** https://github.com/josemaeldon/apostolado/issues
- **Email:** suporte@apostoladodaoracao.org.br

## 🎉 10. Parabéns!

Você agora tem um site completamente funcional para o Apostolado da Oração!

**Próximo passo recomendado:** Implementar o painel administrativo (CRUD) para gerenciar todo o conteúdo de forma visual e intuitiva.

---

**Desenvolvido com ❤️ para o Apostolado da Oração**
