# Resumo das Correções - Armazenamento e MinIO

## Problemas Identificados

### 1. Erro 404 ao Carregar Imagens

**Problema**: As imagens não carregavam, resultando em erros 404 como:
```
Failed to load resource: the server responded with a status of 404 () 
(ddtY1ZGuYdZlPsv9loInS40kJbYdEp8H5rbCgD28.jpg, line 0)
```

**Causa Raiz**:
- Os controllers estavam com o disco 'public' codificado diretamente ao invés de respeitar a configuração `FILESYSTEM_DISK` do `.env`
- O link simbólico de `public/storage` para `storage/app/public` não estava sendo criado automaticamente no deployment

### 2. Configuração do MinIO

**Problema**: Embora o MinIO já estivesse configurado no `config/filesystems.php`, os controllers não o utilizavam.

**Causa Raiz**: Os controllers usavam disco 'public' codificado diretamente ao invés de respeitar a configuração do ambiente.

## Correções Implementadas

### 1. Controllers Atualizados

Todos os controllers que lidam com upload de arquivos foram atualizados para usar o disco padrão configurado em `FILESYSTEM_DISK`:

**Arquivos Modificados**:
- `app/Http/Controllers/Admin/ArticleController.php`
- `app/Http/Controllers/Admin/EventController.php`
- `app/Http/Controllers/Admin/MediaGalleryController.php`
- `app/Http/Controllers/Admin/PageController.php`
- `app/Http/Controllers/Admin/PrayerIntentionController.php`
- `app/Http/Controllers/Admin/SliderController.php`

**Mudança Aplicada**:
```php
// ANTES (codificado diretamente)
$path = $request->file('image')->store('images', 'public');
Storage::disk('public')->delete($path);

// DEPOIS (configurável)
$path = $request->file('image')->store('images');
Storage::delete($path);
```

Agora o Laravel usa automaticamente o disco configurado em `FILESYSTEM_DISK`.

### 2. Configuração do Filesystem

**Arquivo**: `config/filesystems.php`

Adicionada a propriedade `visibility` ao disco MinIO para garantir que os arquivos sejam públicos:

```php
'minio' => [
    'driver' => 's3',
    // ... outras configurações
    'visibility' => 'public',  // ← ADICIONADO
],
```

### 3. Docker Entrypoint

**Arquivo**: `docker-entrypoint.sh`

Adicionada verificação e criação automática do link simbólico do storage:

```bash
# Criar link simbólico do storage (se ainda não existir)
if [ ! -L public/storage ]; then
    php artisan storage:link 2>/dev/null
fi
```

### 4. Documentação

**Arquivos Criados**:
- `MINIO-SETUP.md` - Guia completo de configuração do MinIO

**Arquivos Atualizados**:
- `.env.example` - Melhorada a documentação das variáveis do MinIO

## Como Usar

### Para Armazenamento Local (Padrão)

No arquivo `.env`:
```env
FILESYSTEM_DISK=public
```

Certifique-se de que o link simbólico existe:
```bash
php artisan storage:link
```

### Para MinIO

1. Configure o MinIO (veja `MINIO-SETUP.md`)
2. No arquivo `.env`:
```env
FILESYSTEM_DISK=minio
MINIO_ENDPOINT=http://minio:9000
MINIO_ACCESS_KEY_ID=minioadmin
MINIO_SECRET_ACCESS_KEY=minioadmin123
MINIO_BUCKET=apostolado
MINIO_REGION=us-east-1
MINIO_USE_PATH_STYLE_ENDPOINT=true
MINIO_URL=http://localhost:9000/apostolado
```

3. Crie o bucket no MinIO
4. Reinicie a aplicação

### Para Amazon S3

No arquivo `.env`:
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
```

## Benefícios das Mudanças

1. **Flexibilidade**: Agora é possível trocar o sistema de armazenamento apenas alterando variáveis de ambiente
2. **Escalabilidade**: Suporte nativo ao MinIO permite escalar o armazenamento independentemente
3. **Compatibilidade**: Mantém compatibilidade com armazenamento local, MinIO, S3 e qualquer serviço compatível com S3
4. **Manutenibilidade**: Código mais limpo e alinhado com as melhores práticas do Laravel
5. **Deployment**: Link do storage criado automaticamente no startup

## Migração de Dados Existentes

Se você já possui imagens armazenadas localmente e quer migrar para MinIO:

```bash
# Copiar arquivos locais para o MinIO
docker run --rm -v $(pwd)/storage/app/public:/source \
  --network apostolado-network \
  minio/mc \
  cp -r /source/ myminio/apostolado/
```

## Testes

### Verificar Configuração Atual

```bash
php artisan tinker
>>> config('filesystems.default')
=> "public"  # ou "minio", dependendo da configuração
```

### Testar Upload

1. Faça login no painel admin
2. Vá em Artigos > Novo Artigo
3. Faça upload de uma imagem destacada
4. Salve o artigo
5. Verifique se a imagem aparece corretamente

### Verificar Armazenamento

**Local**:
```bash
ls -la storage/app/public/articles/
```

**MinIO**:
Acesse http://localhost:9001 e verifique o bucket `apostolado`

## Resolução de Problemas

### Imagens não aparecem (404)

**Solução 1**: Criar o link simbólico
```bash
php artisan storage:link
```

**Solução 2**: Verificar permissões
```bash
chmod -R 755 storage/app/public
chown -R www-data:www-data storage/app/public
```

### MinIO: Access Denied (403)

Configure o bucket como público:
```bash
mc anonymous set download myminio/apostolado
```

### Connection Refused

Verifique se o MinIO está rodando:
```bash
docker-compose ps minio
docker-compose logs minio
```

## Próximos Passos (Opcional)

Para melhorias futuras, considere:

1. **CDN**: Adicionar CloudFlare ou outro CDN na frente do MinIO
2. **Backup**: Configurar backup automático dos buckets MinIO
3. **Otimização**: Adicionar processamento de imagens (resize, compress) antes do upload
4. **Validação**: Implementar validação mais rigorosa de tipos de arquivo

## Referências

- [Documentação Laravel Storage](https://laravel.com/docs/filesystem)
- [MinIO Documentation](https://min.io/docs/)
- [MINIO-SETUP.md](./MINIO-SETUP.md) - Guia detalhado de configuração do MinIO
