# 🚀 MinIO + Cache Busting - Seu Projeto Agora Tem Persistência de Imagens!

## ⚡ Ativar em 3 Minutos

```bash
# 1. Execute o script de setup
bash scripts/setup-minio.sh

# Escolha:
# [1] Desenvolvimento Local (recomendado)
# [2] Produção

# 2. Inicie tudo
docker-compose up -d

# 3. Acesse MinIO
# http://localhost:9001
# Login: minioadmin / minioadmin
```

## ✅ Resultado

✅ **Imagens sempre atualizadas** quando você as alterar (cache busting)
✅ **Imagens nunca deletadas** quando você faz git pull (MinIO persistente)
✅ **Pronto para escalar** com suporte S3-compatible

## 📚 Documentação (Escolha Uma)

| Documento | Quando Ler | Tempo |
|-----------|-----------|-------|
| [IMAGENS-PERSISTEM-GUIA.md](IMAGENS-PERSISTEM-GUIA.md) | Quer entender tudo visualmente | 10 min |
| [MINIO-QUICK-START.md](MINIO-QUICK-START.md) | Quer setup rápido | 5 min |
| [RESUMO-MINIO-2026.md](RESUMO-MINIO-2026.md) | Quer ver o que mudou | 3 min |

## 🔄 Como Funciona

```
You Upload Image
      ↓
ImageHelper adds timestamp: imagem.jpg?v=1709654321
      ↓
MinIO stores in persistent volume
      ↓
Git Pull → Code updates
      ↓
MinIO data NEVER deleted!
      ↓
App works with all old images
```

## 🧪 Validar Configuração

```bash
# Verificar se tudo está ok
bash scripts/validate-minio-config.sh

# Esperado: ✅ TUDO OK!
```

## 📞 Problemas?

| Erro | Solução |
|------|---------|
| MinIO não inicia | `docker logs apostolado_minio` |
| Imagens não carregam | Verifique `MINIO_URL` em `.env` |
| "Connection refused" | Aguarde MinIO (10-15s) |

## 📦 O Que Mudou

**Criado:**
- 5 documentos explicativos
- 2 scripts automáticos
- Serviço MinIO + volume persistente

**Modificado:**
- docker-compose.yml (+ MinIO)
- docker-stack.yml (+ MinIO habilitado)
- .env.example (+ docs MinIO)

**Já Existente (Funciona com MinIO):**
- app/Helpers/ImageHelper.php
- Cache busting automático

## 🎯 Garantias

Suas imagens vão permanecer após:
- ✅ git pull
- ✅ docker-compose down/up
- ✅ Atualizações de código
- ✅ Deployments
- ✅ Restarts de servidor

---

## 🚀 Comece Agora!

```bash
bash scripts/setup-minio.sh
```

**Documentação completa:** Veja [IMAGENS-PERSISTEM-GUIA.md](IMAGENS-PERSISTEM-GUIA.md)
