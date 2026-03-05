# Gerenciamento de Seções da Página Inicial - Documentação

## Visão Geral

Este documento descreve a funcionalidade de gerenciamento de seções da página inicial e seus cards de destaque associados.

## Funcionalidades Implementadas

### 1. Edição de Seções da Página Inicial

A página `/admin/homepage-sections` agora permite:

- **Visualizar** todas as seções configuradas
- **Criar** novas seções
- **Editar** seções existentes (título, subtítulo, posição, ordem, status)
- **Excluir** seções

### 2. Gerenciamento Inline de Cards de Destaque

Na página de edição de uma seção (`/admin/homepage-sections/{id}/edit`), você pode:

- **Visualizar** todos os cards associados à seção
- **Adicionar** novos cards diretamente através de um modal
- **Editar** cards existentes através de um modal
- **Excluir** cards associados à seção

### 3. Estrutura dos Cards de Destaque

Cada card de destaque possui:

- **Título**: Nome do card (ex: "Oração", "Missão")
- **Descrição**: Texto explicativo sobre o card
- **Ícone**: Emoji representativo (ex: 🙏, 🌍, ❤️)
- **Paleta de Cores**: Esquema de cores predefinido ou personalizado
  - Cor inicial do gradiente
  - Cor final do gradiente
  - Cor da borda
  - Cor do texto do título
- **Ordem**: Ordem de exibição (menor número aparece primeiro)
- **Status**: Ativo/Inativo

## Como Usar

### Editando a Seção "O que é o Apostolado da Oração?"

1. Acesse `/admin/homepage-sections`
2. Clique em "Editar" na seção "O que é o Apostolado da Oração?"
3. Na página de edição:
   - Edite o **Título** (ex: "O que é o Apostolado da Oração?")
   - Edite o **Subtítulo** (ex: "Uma rede mundial de oração unida ao Coração de Jesus")
   - Configure a **Posição de Exibição** (onde na página inicial a seção será exibida)
   - Configure a **Ordem de Exibição** (prioridade de exibição)
   - Marque/desmarque **Seção ativa**
4. Clique em "Salvar Alterações"

### Gerenciando os Cards de Destaque

Na mesma página de edição da seção, abaixo do formulário principal:

#### Adicionar Novo Card

1. Clique no botão "+ Adicionar Card"
2. Preencha os campos no modal:
   - Título (ex: "Oração")
   - Descrição (ex: "Rezamos mensalmente pelas intenções do Papa Francisco...")
   - Ícone (ex: 🙏)
   - Selecione uma paleta de cores predefinida ou configure manualmente
   - Defina a ordem de exibição
   - Marque/desmarque "Ativo"
3. Clique em "Salvar Card"

#### Editar Card Existente

1. Clique em "Editar" no card desejado
2. Modifique os campos necessários no modal
3. Clique em "Salvar Card"

#### Excluir Card

1. Clique em "Excluir" no card desejado
2. Confirme a exclusão

## Paletas de Cores Disponíveis

- **Primary (Azul)**: Gradiente azul claro com texto azul escuro
- **Dourado**: Gradiente dourado com texto dourado escuro
- **Neutro (Cinza)**: Gradiente cinza claro com texto escuro
- **Azul Claro**: Variação de azul mais clara
- **Verde**: Gradiente verde claro

## Exemplo de Configuração

### Seção "O que é o Apostolado da Oração?"

- **Título**: O que é o Apostolado da Oração?
- **Subtítulo**: Uma rede mundial de oração unida ao Coração de Jesus
- **Posição**: Não exibir (ou escolher uma posição específica)
- **Status**: Ativa

### Cards Associados

1. **Oração** (🙏)
   - Descrição: "Rezamos mensalmente pelas intenções do Papa Francisco, unindo nossos corações em oração."
   - Paleta: Primary (Azul)
   - Ordem: 0

2. **Missão** (🌍)
   - Descrição: "Colaboramos na missão evangelizadora da Igreja, levando o amor de Cristo ao mundo."
   - Paleta: Dourado
   - Ordem: 1

3. **Coração de Jesus** (❤️)
   - Descrição: "Vivemos nossa espiritualidade centrada no Sagrado Coração de Jesus."
   - Paleta: Primary (Azul)
   - Ordem: 2

## Fluxo de Redirecionamento

Quando você cria, edita ou exclui um card através da página de edição da seção:

- ✅ Após salvar/excluir, você é **redirecionado de volta para a página de edição da seção**
- ✅ Uma mensagem de sucesso é exibida
- ✅ Você pode continuar gerenciando outros cards sem sair da página

## Detalhes Técnicos da Implementação

### Arquivos Modificados

- **`app/Http/Controllers/Admin/HomepageSectionController.php`**
  - Adicionado carregamento eager de feature cards no método `edit()`
  - Incluídas rotas de atualização para cada card para uso no JavaScript
  
- **`app/Http/Controllers/Admin/FeatureCardController.php`**
  - Modificado `store()` para redirecionar para a página de edição da seção quando o card é associado
  - Modificado `update()` para redirecionar para a página de edição da seção quando o card é associado
  - Modificado `destroy()` para redirecionar para a página de edição da seção quando o card era associado
  - Utiliza `!empty()` de forma consistente para verificar a existência de homepage_section_id

- **`resources/views/admin/homepage-sections/edit.blade.php`**
  - Adicionada seção de gerenciamento de feature cards
  - Adicionado modal responsivo para adicionar/editar cards
  - JavaScript encapsulado em IIFE para prevenir conflitos e múltiplos event listeners
  - Adicionado tratamento de erros com feedback ao usuário
  - Rotas de atualização geradas server-side para garantir URLs corretas

### Melhorias de Qualidade de Código

1. **Consistência**: Uso de `!empty()` em todas as verificações de homepage_section_id
2. **Encapsulamento**: JavaScript em IIFE para evitar poluição do escopo global
3. **Tratamento de Erros**: Mensagens de erro amigáveis quando um card não é encontrado
4. **URLs Seguros**: Rotas geradas server-side ao invés de construção manual de URLs
5. **UX Melhorada**: Redirecionamento inteligente mantém o usuário no contexto correto

## Testes

Os testes já existentes em `tests/Feature/HomepageSectionFeatureCardTest.php` cobrem:

- Criação de seções com feature cards
- Associação de cards a seções
- Criação de cards independentes (sem seção)
- Upload de imagens em destaque
- Exclusão em cascata (quando uma seção é excluída, seus cards também são)

## Compatibilidade e Requisitos

- Laravel 11
- PHP 8.2+
- PostgreSQL/SQLite (via migrações existentes)
- Blade Templates
- Tailwind CSS
- JavaScript Vanilla (sem dependências externas)

## Segurança

- Validação server-side de todos os inputs
- Proteção CSRF em todos os formulários
- Middleware de autenticação e autorização (admin)
- Relações de banco de dados com cascade delete configurado
- Verificado pelo CodeQL sem vulnerabilidades identificadas
