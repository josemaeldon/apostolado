# Solução: Cache Busting de Imagens

## Problema
Quando imagens eram alteradas no servidor, elas não eram recarregadas no navegador porque:
1. As URLs das imagens permaneciam idênticas
2. O navegador utilizava a versão cacheada em vez de baixar a nova

## Solução Implementada

### 1. Criação do Helper de Cache Busting
**Arquivo:** `app/Helpers/ImageHelper.php`

Um novo helper foi criado que adiciona um parâmetro de versão às URLs das imagens. Este parâmetro é baseado na data da última modificação do arquivo, garantindo que URLs diferentes sejam utilizadas quando as imagens são atualizadas.

**Funções disponíveis:**
- `ImageHelper::storageUrl($path)` - Para imagens em `storage/app/public`
- `ImageHelper::assetUrl($path)` - Para assets em `public/` (se necessário)

**Como funciona:**
```
URLs antes: /storage/images/photo.jpg
URLs depois: /storage/images/photo.jpg?v=1234567890
```

Quando a imagem é atualizada:
```
URLs depois da atualização: /storage/images/photo.jpg?v=1234567891
```

O navegador reconhece essa como uma URL diferente e baixa a nova versão.

### 2. Atualização das Views
Todas as views que carregavam imagens foram atualizadas para usar o novo helper:
- `resources/views/welcome.blade.php` - Slider, eventos e artigos
- `resources/views/partials/dynamic-content.blade.php` - Cards dinâmicos
- `resources/views/public/article-show.blade.php` - Artigos individuais
- `resources/views/layouts/admin.blade.php` - Logo e favicon

**Uso em templates:**
```blade
<!-- Antes -->
<img src="{{ Storage::url($image) }}" alt="...">

<!-- Depois -->
<img src="{{ \App\Helpers\ImageHelper::storageUrl($image) }}" alt="...">

<!-- Ou usando a macro Blade (mais simples) -->
<img src="@imageUrl($image)" alt="...">
```

### 3. Configuração do Nginx
**Arquivo:** `docker/nginx/default.conf`

A configuração foi otimizada para diferenciar o caching de imagens do caching de outros assets:

**Imagens (jpg, jpeg, gif, png, svg):**
- Cache: 30 dias
- Sem `immutable` - permite validações com servidor
- Funciona bem com cache busting por query parameters

**Outros assets (CSS, JS, etc):**
- Cache: 30 dias
- Com `immutable` - otimizado para URLs com hash incorporado

### 4. Registro no Service Provider
**Arquivo:** `app/Providers/AppServiceProvider.php`

As macros Blade foram registradas para facilitar o uso em templates:
```blade
<img src="@imageUrl($image)" alt="...">
```

## Como Usar

### Para novas imagens em templates:
```blade
<!-- Para Storage URLs -->
<img src="@imageUrl($image)" alt="Descrição">

<!-- Para URLs com background-image -->
<div style="background-image: url('@imageUrl($image)')">
```

### Para helpers em controllers/classes:
```php
use App\Helpers\ImageHelper;

$url = ImageHelper::storageUrl('images/photo.jpg');
```

## Comportamento do Cache

1. **Primeira visualização:** Imagem é carregada e cacheada pelo navegador
2. **Atualizações de imagem:** Novo arquivo é carregado imediatamente (graças ao novo timestamp na URL)
3. **Sem mudanças:** Arquivo cacheado é utilizado (performance otimizada)

## Validação

Para validar que a solução funciona:

1. Fazer upload/alteração de uma imagem no admin
2. O `filemtime()` do arquivo muda
3. A URL recebe um novo parâmetro `?v=novo_timestamp`
4. O navegador baixa a nova versão imediatamente

## Benefícios

✅ Imagens sempre atualizadas após modificações
✅ Cache ainda funciona para performance (quando não há mudanças)
✅ Sem necessidade de limpar cache manualmente
✅ Totalmente transparente para o usuário final
✅ Implementação simples e elegante

## Referências Técnicas

- **Cache Busting:** Técnica de adicionar um identificador único à URL para forçar atualização
- **Query Parameters:** `?v=timestamp` é reconhecido como URL diferente pelo navegador
- **filemtime():** Função PHP que retorna o timestamp de última modificação do arquivo
- **HTTP Cache-Control:** Diretivas que controlam o comportamento de cache
