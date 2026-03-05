# ✅ Configuração Completa: Cache Busting + Persistência de Imagens

## 🎯 O que foi Implementado

### 1️⃣ Cache Busting (Imagens sempre atualizadas)
Quando você altera uma imagem, ela é recarregada sempre:

```
Upload Novo          URL Antes      URL Depois
foto.jpg    ----→   foto.jpg       foto.jpg?v=1234567891
                    (versão antiga) (versão nova)
```

**Arquivos:**
- ✅ `app/Helpers/ImageHelper.php` - Adiciona timestamp automático
- ✅ `app/Providers/AppServiceProvider.php` - Registra macro `@imageUrl()`
- ✅ `docker/nginx/default.conf` - Cache HTTP otimizado
- ✅ Views atualizadas (welcome.blade.php, dinamic-content.blade.php, etc)

### 2️⃣ Persistência com MinIO (Imagens não são deletadas)
Quando você faz `git pull` ou redeploy:

```
Antes do Update          Depois do Update
✅ Código antigo    →    ✅ Código novo
✅ Imagens MinIO    →    ✅ Imagens MinIO (INTACTAS)
```

**Arquivos:**
- ✅ `docker-compose.yml` - Serviço MinIO adicionado com volume persistente
- ✅ `docker-stack.yml` - MinIO ativado para produção
- ✅ `.env.example` - Configuração documentada
- ✅ `config/filesystems.php` - Disco 'minio' disponível

## 🚀 Como Ativar

### Desenvolvimento Local (Recomendado)
```bash
# Passo 1: Execute o script de setup
bash scripts/setup-minio.sh

# Escolha opção 1 para desenvolvimento local ✅
# Script vai:
# - Ativar FILESYSTEM_DISK=minio
# - Configurar credenciais padrão
# - Backup seu .env

# Passo 2: Inicie os containers
docker-compose up -d minio app

# Passo 3: Acesse MinIO Console
# http://localhost:9001
# Login: minioadmin / minioadmin

# Passo 4: Crie bucket "apostolado" (se não existir)
```

### Produção (Docker Swarm)
```bash
# Passo 1: Execute o script de setup
bash scripts/setup-minio.sh

# Escolha opção 2 para produção
# Script pedirá:
# - Endpoint MinIO (ex: https://minio.seu-dominio.com)
# - Access Key e Secret Key
# - Bucket nome
# - URL pública

# Passo 2: Deploy com docker stack deploy
docker stack deploy -c docker-stack.yml apostolado
```

## 🔄 Fluxo Completo de Uso

### Cenário 1: Atualizar Logo
```
Admin Panel
  ↓
Upload novo logo.png
  ↓
ImageHelper::storageUrl('logo.png') 
  ↓
Adiciona timestamp: logo.png?v=1709654321
  ↓
MinIO armazena o arquivo
  ↓
Navegador carrega a versão nova (timestamp diferente)
```

### Cenário 2: Fazer Git Pull (Update)
```
git pull origin main
  ↓
Código atualizado
  ↓
Images no MinIO PERMANECEM INTACTAS
  ↓
App funciona com imagens antigas
  ↓
Novos uploads vão para MinIO automaticamente
```

## 📋 Checklist de Verificação

- [ ] `bash scripts/setup-minio.sh` executado
- [ ] `FILESYSTEM_DISK=minio` no seu `.env`
- [ ] `docker-compose up -d` containers rodando
- [ ] MinIO Console acessível (http://localhost:9001)
- [ ] Bucket "apostolado" criado/verificado
- [ ] Teste de upload funcionando
- [ ] Imagem carregada na página

## 🧪 Testar Tudo

### Via Admin Panel
1. Vá para: Admin → Configurações do Site
2. Upload um logo novo
3. Verifique em MinIO Console se arquivo aparece
4. Recarregue página → Logo carrega de novo

### Via Artisan Tinker
```bash
docker-compose exec app php artisan tinker

# Testar escrita
Storage::disk('minio')->put('test.txt', 'Hello MinIO');

# Testar leitura
Storage::disk('minio')->get('test.txt');

# Listar arquivos
Storage::disk('minio')->files('');
```

## 📂 Estrutura de Volumes

```
Docker Volume: minio_data
  ├── apostolado/
  │   ├── sliders/
  │   │   └── slider-uuid.jpg
  │   ├── articles/
  │   │   └── article-uuid.png
  │   ├── feature-cards/
  │   ├── logos/
  │   └── ... (outros uploads)
  └── .minio.sys/
```

Este volume é **PERSISTENTE** entre:
- ✅ Docker compose restarts
- ✅ Git pulls
- ✅ Code deployments
- ✅ Container updates

## 🔐 Segurança

### Desenvolvimento (Padrão)
- Access Key: `minioadmin`
- Secret Key: `minioadmin`
- ⚠️ Mude em produção!

### Produção
- Gere credenciais fortes (32+ caracteres)
- Use HTTPS para MinIO
- Backup regular do bucket
- Configure access policies
- Monitore logs de acesso

## 📚 Documentação

**Leia mais:**
- [MINIO-QUICK-START.md](MINIO-QUICK-START.md) - Setup rápido
- [MINIO-PERSISTENCE-CONFIG.md](MINIO-PERSISTENCE-CONFIG.md) - Configuração detalhada
- [IMAGE-CACHE-BUSTING-FIX.md](IMAGE-CACHE-BUSTING-FIX.md) - Cache busting específico

## 🆘 Troubleshooting Rápido

| Problema | Solução |
|----------|---------|
| MinIO não inicia | `docker logs apostolado_minio` |
| Imagens não carregam | Verificar `MINIO_URL` em .env |
| "Connection refused" | Aguardar MinIO iniciar (10-15s) |
| Autenticação negada | Verificar credentials em .env |
| Upload funciona mas não carrega | Verificar MINIO_URL vs endpoint |

## 🎉 Benefícios Finais

✅ **Imagens sempre atualizadas** - Via cache busting automático
✅ **Imagens nunca são perdidas** - Armazenadas em MinIO persistente
✅ **Zero downtime** - Atualizações não afetam imagens
✅ **Escalável** - MinIO aguenta múltiplos servidores
✅ **S3-compatible** - Portável para qualquer provedor S3

---

**Status:** ✅ Implementação Completa
**Próximo Passo:** Execute `bash scripts/setup-minio.sh`
