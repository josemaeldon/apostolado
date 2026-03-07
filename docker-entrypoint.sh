#!/bin/bash
set -e

# Cores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Apostolado da Oração - Inicialização ===${NC}"
echo -e "Diretório atual: $(pwd)"
echo -e "Usuário atual: $(whoami)"

PERSISTENT_ENV_FILE="storage/app/config/.env.persistent"
mkdir -p storage/app/config 2>/dev/null || true

# Restore .env from persistent storage when available (survives container updates)
if [ -f "$PERSISTENT_ENV_FILE" ] && [ -s "$PERSISTENT_ENV_FILE" ]; then
    echo -e "${GREEN}Arquivo .env persistente encontrado. Restaurando configurações...${NC}"
    cp "$PERSISTENT_ENV_FILE" .env 2>/dev/null || true
fi

# Verificar se o arquivo .env existe
if [ ! -f .env ]; then
    echo -e "${YELLOW}Arquivo .env não encontrado. Criando a partir de .env.example...${NC}"
    
    # Debug: listar arquivos .env* disponíveis
    ENV_FILE_COUNT=$(ls -A .env* 2>/dev/null | wc -l)
    if [ "$ENV_FILE_COUNT" -gt 0 ]; then
        echo -e "Arquivos .env* disponíveis: $ENV_FILE_COUNT arquivo(s)"
    else
        echo -e "Arquivos .env* disponíveis: Nenhum arquivo encontrado"
    fi
    
    if [ -f .env.example ]; then
        if cp .env.example .env 2>/dev/null; then
            echo -e "${GREEN}✓ Arquivo .env criado com sucesso${NC}"
        else
            echo -e "${YELLOW}⚠ Não foi possível criar o arquivo .env (sem permissão de escrita)${NC}"
            echo -e "${YELLOW}  Docker: O arquivo .env deve ser criado durante o build ou montado como volume${NC}"
            echo -e "${YELLOW}  Local: Execute 'cp .env.example .env' manualmente ou ajuste as permissões do diretório${NC}"
        fi
    else
        echo -e "${YELLOW}⚠ Arquivo .env.example não encontrado.${NC}"
        if touch .env 2>/dev/null; then
            echo -e "${GREEN}✓ Arquivo .env vazio criado${NC}"
        else
            echo -e "${YELLOW}⚠ Não foi possível criar o arquivo .env (sem permissão de escrita)${NC}"
            echo -e "${YELLOW}  Docker: O arquivo .env deve ser criado durante o build ou montado como volume${NC}"
            echo -e "${YELLOW}  Local: Execute 'touch .env' manualmente ou ajuste as permissões do diretório${NC}"
        fi
    fi
fi

# Garantir que o arquivo .env tenha permissões corretas
if [ -f .env ]; then
    # Verificar se temos permissão de escrita
    if [ ! -w .env ]; then
        echo -e "${YELLOW}Ajustando permissões do arquivo .env...${NC}"
        chmod 664 .env 2>/dev/null || echo -e "${YELLOW}⚠ Não foi possível alterar permissões (verifique as permissões no host se estiver usando bind mount)${NC}"
    fi
    echo -e "${GREEN}✓ Arquivo .env está acessível${NC}"

    # Keep persistent mirror synchronized with current .env
    cp .env "$PERSISTENT_ENV_FILE" 2>/dev/null || true
else
    echo -e "${YELLOW}⚠ Aviso: Não foi possível verificar o arquivo .env${NC}"
fi

# Garantir que os diretórios de cache existam
if mkdir -p storage/framework/{sessions,views,cache} 2>/dev/null && \
   mkdir -p storage/logs 2>/dev/null && \
   mkdir -p bootstrap/cache 2>/dev/null; then
    echo -e "${GREEN}✓ Diretórios de cache verificados${NC}"
else
    echo -e "${YELLOW}⚠ Não foi possível criar alguns diretórios de cache (sem permissão de escrita)${NC}"
    echo -e "${YELLOW}  Docker: Os diretórios devem ser criados durante o build${NC}"
    echo -e "${YELLOW}  Local: Execute 'mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache' manualmente${NC}"
fi

# Criar link simbólico do storage (se ainda não existir)
if [ ! -L public/storage ]; then
    echo -e "${YELLOW}Criando link simbólico do storage...${NC}"
    if php artisan storage:link 2>/dev/null; then
        echo -e "${GREEN}✓ Link simbólico do storage criado${NC}"
    else
        echo -e "${YELLOW}⚠ Não foi possível criar o link simbólico (será criado durante a instalação)${NC}"
    fi
else
    echo -e "${GREEN}✓ Link simbólico do storage já existe${NC}"
fi

# Executar migrations automaticamente (com retry) para manter banco alinhado com novas versões.
AUTO_RUN_MIGRATIONS="${AUTO_RUN_MIGRATIONS:-true}"
MIGRATION_MAX_ATTEMPTS="${MIGRATION_MAX_ATTEMPTS:-30}"
MIGRATION_RETRY_SECONDS="${MIGRATION_RETRY_SECONDS:-2}"

if [ "$AUTO_RUN_MIGRATIONS" = "true" ]; then
    if [ -f artisan ]; then
        echo -e "${YELLOW}Executando migrations automáticas...${NC}"

        migration_attempt=1
        while [ "$migration_attempt" -le "$MIGRATION_MAX_ATTEMPTS" ]; do
            if php artisan migrate --force; then
                echo -e "${GREEN}✓ Migrations executadas com sucesso${NC}"
                break
            fi

            if [ "$migration_attempt" -eq "$MIGRATION_MAX_ATTEMPTS" ]; then
                echo -e "${YELLOW}⚠ Falha ao executar migrations após ${MIGRATION_MAX_ATTEMPTS} tentativas${NC}"
                exit 1
            fi

            echo -e "${YELLOW}Tentativa ${migration_attempt}/${MIGRATION_MAX_ATTEMPTS} falhou. Tentando novamente em ${MIGRATION_RETRY_SECONDS}s...${NC}"
            migration_attempt=$((migration_attempt + 1))
            sleep "$MIGRATION_RETRY_SECONDS"
        done
    else
        echo -e "${YELLOW}⚠ Arquivo artisan não encontrado. Pulando migrations automáticas.${NC}"
    fi
else
    echo -e "${YELLOW}AUTO_RUN_MIGRATIONS=false. Pulando migrations automáticas.${NC}"
fi

# Executar o comando fornecido (normalmente supervisord)
echo -e "${GREEN}=== Iniciando aplicação ===${NC}"
exec "$@"
