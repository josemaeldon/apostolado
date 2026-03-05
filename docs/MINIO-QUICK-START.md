# Guia Rápido: MinIO para Persistência de Imagens

## 🎯 Para Ativar MinIO (Desenvolvimento)

### Opção 1: Script Automático (Recomendado)
```bash
bash scripts/setup-minio.sh
# Escolha opção 1 para desenvolvimento local
```

### Opção 2: Manual
```bash
# 1. Edite seu .env
nano .env

# 2. Mude esta linha:
FILESYSTEM_DISK=local

# Para:
FILESYSTEM_DISK=minio

# 3. Garantir que MinIO está configurado:
MINIO_ENDPOINT=http://minio:9000
MINIO_ACCESS_KEY_ID=minioadmin
MINIO_SECRET_ACCESS_KEY=minioadmin
MINIO_BUCKET=apostolado
MINIO_URL=http://localhost:9000/apostolado

# 4. Inicie os containers
docker-compose up -d

# 5. Acesse MinIO Console
# http://localhost:9001
# Login: minioadmin / minioadmin

# 6. Crie um bucket "apostolado" (se não existir)
```

## 🔄 Por que as Imagens Persistem?

```
┌─────────────────────────────────────────────────┐
│            Seu Git Repository                   │
│  (Código, configurações, migrations, etc)       │
└─────────────────────────────────────────────────┘
              ↓ (git pull/update)
    Código atualizado, IMAGENS não deletadas

┌─────────────────────────────────────────────────┐
│            MinIO Object Store                   │
│  (Imagens, uploads, mídia - PERSISTEM!)         │
│  Volume Docker: minio_data:/data                │
└─────────────────────────────────────────────────┘
```

## ✅ Verificar Configuração

```bash
# Ver configuração atual
grep "FILESYSTEM_DISK\|MINIO_" .env

# MinIO deve estar assim:
# FILESYSTEM_DISK=minio
# MINIO_ENDPOINT=http://minio:9000
# MINIO_BUCKET=apostolado
```

## 📸 Testar Upload de Imagem

1. **Via Admin Panel:**
   - Login no admin
   - Vá para: Configurações do Site
   - Upload um logo/favicon
   - Verifique se aparece em http://localhost:9001

2. **Via Artisan Tinker:**
   ```bash
   docker-compose exec app php artisan tinker
   
   # Teste de escrita
   Storage::disk('minio')->put('test.txt', 'Hello MinIO');
   
   # Teste de leitura
   Storage::disk('minio')->get('test.txt');
   ```

## 🚀 Fazer Update do Código (Imagens Permanecem)

```bash
# Baixar atualizações
git pull origin main

# Reiniciar containers (imagens não são afetadas)
docker-compose down
docker-compose up -d

# ✅ Todas as imagens antigas continuam funcionando!
```

## 🐛 Troubleshooting

### Problema: "Connection refused" ao MinIO
```bash
# Verificar se MinIO está rodando
docker ps | grep minio

# Se não está, inicie:
docker-compose up -d minio

# Espere 10-15 segundos para MinIO iniciar
docker logs apostolado_minio
```

### Problema: Imagens não carregam
```bash
# Verificar URL no .env
grep "MINIO_URL" .env

# Localdev deve ser: http://localhost:9000/apostolado
# Docker Swarm deve ser: http://minio:9000/apostolado
```

### Problema: Autenticação negada
```bash
# Verifique credentials no .env
grep "MINIO_ACCESS_KEY_ID\|MINIO_SECRET_ACCESS_KEY" .env

# Padrão development: minioadmin / minioadmin
# Mude em produção!
```

## 📚 Documentação Completa

Veja: [MINIO-PERSISTENCE-CONFIG.md](MINIO-PERSISTENCE-CONFIG.md)

## 🔐 Produção

Para produção:
1. Execute `bash scripts/setup-minio.sh` e escolha opção 2
2. Insira dados do seu MinIO em produção
3. Use credenciais fortes
4. Configure acesso HTTPS
5. Backup regular do bucket 'apostolado'
