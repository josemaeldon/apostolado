# Configuração do MinIO para Apostolado da Oração

Este guia explica como configurar o MinIO para armazenamento de mídias no sistema Apostolado da Oração.

## O que é MinIO?

MinIO é um servidor de armazenamento de objetos compatível com S3, ideal para armazenar imagens, vídeos e outros arquivos. É uma alternativa open-source ao Amazon S3.

## Por que usar MinIO?

- **Escalabilidade**: Armazenamento distribuído e escalável
- **Compatibilidade S3**: API compatível com Amazon S3
- **Self-hosted**: Controle total sobre seus dados
- **Alta Performance**: Otimizado para grandes volumes de dados
- **Separação de Responsabilidades**: Servidor de aplicação separado do armazenamento

## Configuração com Docker Compose

### 1. Adicionar MinIO ao docker-compose.yml

Adicione o serviço MinIO ao seu arquivo `docker-compose.yml`:

```yaml
services:
  minio:
    image: minio/minio:latest
    container_name: apostolado-minio
    ports:
      - "9000:9000"      # API
      - "9001:9001"      # Console
    environment:
      MINIO_ROOT_USER: minioadmin
      MINIO_ROOT_PASSWORD: minioadmin123
    volumes:
      - minio_data:/data
    command: server /data --console-address ":9001"
    networks:
      - apostolado-network
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost:9000/minio/health/live"]
      interval: 30s
      timeout: 20s
      retries: 3

  # Adicionar ao final do arquivo
volumes:
  minio_data:
    driver: local

networks:
  apostolado-network:
    driver: bridge
```

### 2. Configurar Variáveis de Ambiente

Edite o arquivo `.env` e configure as seguintes variáveis:

```env
# Storage Configuration
FILESYSTEM_DISK=minio

# MinIO Configuration
MINIO_ENDPOINT=http://minio:9000
MINIO_ACCESS_KEY_ID=minioadmin
MINIO_SECRET_ACCESS_KEY=minioadmin123
MINIO_BUCKET=apostolado
MINIO_REGION=us-east-1
MINIO_USE_PATH_STYLE_ENDPOINT=true
MINIO_URL=http://localhost:9000/apostolado
```

**Importante**: Em produção, altere as credenciais padrão por questões de segurança!

### 3. Criar o Bucket

Após iniciar o MinIO, você precisa criar o bucket:

#### Opção A: Via Console Web

1. Acesse http://localhost:9001
2. Faça login com:
   - Username: `minioadmin`
   - Password: `minioadmin123`
3. Clique em "Buckets" > "Create Bucket"
4. Nome do bucket: `apostolado`
5. Clique em "Create Bucket"
6. Selecione o bucket criado
7. Vá em "Access" > "Access Policy"
8. Defina como "Public" (ou configure uma política customizada)

#### Opção B: Via CLI

```bash
# Instalar o cliente MinIO
docker run --rm -it --entrypoint=/bin/sh minio/mc

# Configurar alias para o servidor MinIO
mc alias set myminio http://localhost:9000 minioadmin minioadmin123

# Criar bucket
mc mb myminio/apostolado

# Definir política pública de leitura
mc anonymous set download myminio/apostolado
```

### 4. Reiniciar a Aplicação

```bash
docker-compose down
docker-compose up -d
```

## Configuração em Produção

### Segurança

1. **Altere as credenciais padrão**:

```env
MINIO_ROOT_USER=seu_usuario_seguro
MINIO_ROOT_PASSWORD=sua_senha_muito_segura_123!
```

2. **Configure HTTPS**: Use um proxy reverso (Nginx/Traefik) com certificado SSL

3. **Políticas de Acesso**: Configure políticas de bucket específicas ao invés de acesso público total

### URL Pública

Para que as imagens sejam acessíveis publicamente, configure a URL do MinIO:

```env
# URL acessível publicamente (domínio ou IP público)
MINIO_URL=https://minio.seudominio.com.br/apostolado
```

## Migração de Armazenamento Local para MinIO

Se você já possui imagens armazenadas localmente, pode migrá-las para o MinIO:

```bash
# Copiar arquivos do storage local para o MinIO
docker run --rm -v $(pwd)/storage/app/public:/source \
  --network apostolado-network \
  minio/mc \
  cp -r /source/ myminio/apostolado/
```

## Troubleshooting

### Erro: "Access Denied"

**Problema**: As imagens não carregam, retornando 403 Forbidden.

**Solução**: Verifique se o bucket tem política de leitura pública:

```bash
mc anonymous set download myminio/apostolado
```

### Erro: "Connection Refused"

**Problema**: A aplicação não consegue conectar ao MinIO.

**Solução**: 
1. Verifique se o MinIO está rodando: `docker-compose ps`
2. Confirme que a rede Docker está correta
3. Use `http://minio:9000` (nome do serviço) ao invés de `localhost` dentro do Docker

### Imagens não aparecem após alteração

**Problema**: Mudei para MinIO mas as imagens antigas não aparecem.

**Solução**: 
1. Migre as imagens antigas (veja seção "Migração")
2. Ou mantenha `FILESYSTEM_DISK=public` para imagens antigas e mude apenas para novos uploads

## Alternativas de Armazenamento

Além do MinIO, o sistema também suporta:

- **Local Storage** (padrão): `FILESYSTEM_DISK=public`
- **Amazon S3**: Configure as variáveis `AWS_*` no `.env`
- **Outros compatíveis com S3**: DigitalOcean Spaces, Wasabi, etc.

## Monitoramento

### Verificar Status do MinIO

```bash
# Via Docker
docker-compose exec minio mc admin info local

# Via API
curl http://localhost:9000/minio/health/live
```

### Logs do MinIO

```bash
docker-compose logs minio -f
```

## Suporte

Para questões específicas do MinIO, consulte:
- [Documentação Oficial do MinIO](https://min.io/docs/)
- [MinIO GitHub](https://github.com/minio/minio)

Para questões do Apostolado da Oração:
- [Issues do GitHub](https://github.com/josemaeldon/apostolado/issues)
