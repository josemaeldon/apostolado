#!/bin/bash
set -e

# Cores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Apostolado da Oração - Inicialização ===${NC}"

# Verificar se o arquivo .env existe
if [ ! -f .env ]; then
    echo -e "${YELLOW}Arquivo .env não encontrado. Criando a partir de .env.example...${NC}"
    
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${GREEN}✓ Arquivo .env criado com sucesso${NC}"
    else
        echo -e "${YELLOW}⚠ Arquivo .env.example não encontrado. Criando .env vazio...${NC}"
        touch .env
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
else
    echo -e "${YELLOW}⚠ Aviso: Não foi possível verificar o arquivo .env${NC}"
fi

# Garantir que os diretórios de cache existam
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo -e "${GREEN}✓ Diretórios de cache verificados${NC}"

# Executar o comando fornecido (normalmente supervisord)
echo -e "${GREEN}=== Iniciando aplicação ===${NC}"
exec "$@"
