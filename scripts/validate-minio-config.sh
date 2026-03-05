#!/bin/bash

# Script de Validação da Configuração MinIO
# Verifica se tudo está configurado corretamente para persistência de imagens

echo "═══════════════════════════════════════════════════════════════════"
echo "   Validação da Configuração MinIO - Persistência de Imagens"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

passed=0
failed=0
warnings=0

# Função para verificação
check() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ PASSOU${NC}: $1"
        ((passed++))
    else
        echo -e "${RED}❌ FALHOU${NC}: $1"
        ((failed++))
    fi
}

warning() {
    echo -e "${YELLOW}⚠️  AVISO${NC}: $1"
    ((warnings++))
}

info() {
    echo -e "${BLUE}ℹ️  INFO${NC}: $1"
}

echo "📋 Verificando Estrutura de Arquivos..."
echo ""

# Verificar arquivos essenciais
[ -f ".env" ]
check ".env existe"

[ -f "docker-compose.yml" ]
check "docker-compose.yml existe"

[ -f "docker-stack.yml" ]
check "docker-stack.yml existe"

[ -f "app/Helpers/ImageHelper.php" ]
check "ImageHelper.php existe"

[ -f "config/filesystems.php" ]
check "config/filesystems.php existe"

echo ""
echo "🔧 Verificando Configuração do .env..."
echo ""

# Variar arquivo .env
if [ -f ".env" ]; then
    grep -q "^FILESYSTEM_DISK=minio" .env
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ PASSOU${NC}: FILESYSTEM_DISK=minio está ativo"
        ((passed++))
    else
        current=$(grep "^FILESYSTEM_DISK=" .env | cut -d= -f2)
        warning "FILESYSTEM_DISK=$current (recomendado: minio)"
    fi
    
    grep -q "^MINIO_ENDPOINT=" .env
    check "MINIO_ENDPOINT está configurado"
    
    grep -q "^MINIO_ACCESS_KEY_ID=" .env
    check "MINIO_ACCESS_KEY_ID está configurado"
    
    grep -q "^MINIO_SECRET_ACCESS_KEY=" .env
    check "MINIO_SECRET_ACCESS_KEY está configurado"
    
    grep -q "^MINIO_BUCKET=" .env
    check "MINIO_BUCKET está configurado"
    
    grep -q "^MINIO_URL=" .env
    check "MINIO_URL está configurado"
else
    warning ".env não encontrado. Copie de .env.example"
fi

echo ""
echo "🐳 Verificando Docker Compose..."
echo ""

if [ -f "docker-compose.yml" ]; then
    grep -q "apostolado_minio" docker-compose.yml
    check "MinIO serviço configurado no docker-compose.yml"
    
    grep -q "minio_data:" docker-compose.yml
    check "Volume minio_data configurado"
    
    grep -q "image: minio/minio" docker-compose.yml
    check "Imagem MinIO especificada"
else
    warning "docker-compose.yml não encontrado"
fi

echo ""
echo "🔐 Verificando Docker Stack (Produção)..."
echo ""

if [ -f "docker-stack.yml" ]; then
    grep -q "FILESYSTEM_DISK: minio" docker-stack.yml
    check "MinIO ativado em docker-stack.yml"
    
    grep -q "MINIO_ENDPOINT:" docker-stack.yml
    check "Configuração MINIO_ENDPOINT no stack"
    
    grep -q "MINIO_URL:" docker-stack.yml
    check "Configuração MINIO_URL no stack"
else
    warning "docker-stack.yml não encontrado"
fi

echo ""
echo "📦 Verificando Código da Aplicação..."
echo ""

grep -q "class ImageHelper" app/Helpers/ImageHelper.php 2>/dev/null
check "Classe ImageHelper implementada"

grep -q "storageUrl" app/Helpers/ImageHelper.php 2>/dev/null
check "Método storageUrl implementado"

grep -q "@imageUrl" app/Providers/AppServiceProvider.php 2>/dev/null
check "Macro Blade @imageUrl registrada"

echo ""
echo "🐚 Verificando Containers em Execução..."
echo ""

if command -v docker &> /dev/null; then
    docker ps 2>/dev/null | grep -q "apostolado_minio"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ PASSOU${NC}: MinIO container está rodando"
        ((passed++))
    else
        warning "MinIO container não está rodando (execute: docker-compose up -d minio)"
    fi
    
    docker ps 2>/dev/null | grep -q "apostolado_app"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ PASSOU${NC}: App container está rodando"
        ((passed++))
    else
        warning "App container não está rodando (execute: docker-compose up -d app)"
    fi
else
    warning "Docker não instalado ou não acessível"
fi

echo ""
echo "🌐 Verificando Conectividade..."
echo ""

if command -v curl &> /dev/null; then
    # Tentar acessar MinIO health check
    curl -s "http://localhost:9000/minio/health/live" &> /dev/null
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ PASSOU${NC}: MinIO está respondendo em http://localhost:9000"
        ((passed++))
    else
        warning "MinIO não está respondendo em http://localhost:9000 (verifique se está rodando)"
    fi
else
    info "curl não instalado, pulando testes de conectividade"
fi

echo ""
echo "═══════════════════════════════════════════════════════════════════"
echo "📊 RESUMO DA VALIDAÇÃO"
echo "═══════════════════════════════════════════════════════════════════"
echo ""
echo -e "  ${GREEN}✅ Passou${NC}:      $passed"
echo -e "  ${RED}❌ Falhou${NC}:     $failed"
echo -e "  ${YELLOW}⚠️  Avisos${NC}:     $warnings"
echo ""

if [ $failed -eq 0 ] && [ $warnings -eq 0 ]; then
    echo -e "${GREEN}🎉 TUDO OK! Sistema pronto para usar MinIO${NC}"
    echo ""
    echo "Próximos passos:"
    echo "  1. docker-compose up -d"
    echo "  2. Acesse MinIO: http://localhost:9001"
    echo "  3. Faça upload de imagens no admin"
    echo "  4. Verifique em MinIO Console"
    exit 0
elif [ $failed -eq 0 ]; then
    echo -e "${YELLOW}⚠️  ATENÇÃO${NC}: Há avisos, mas o sistema pode funcionar"
    echo ""
    echo "Leia os avisos acima e considere:"
    echo "  1. Executar: bash scripts/setup-minio.sh"
    echo "  2. Ativar MinIO: FILESYSTEM_DISK=minio em .env"
    echo "  3. docker-compose up -d"
    exit 0
else
    echo -e "${RED}❌ ERROS ENCONTRADOS${NC}"
    echo ""
    echo "Por favor, corrija os erros acima:"
    echo "  1. Verifique se todos os arquivos existem"
    echo "  2. Execute: bash scripts/setup-minio.sh"
    echo "  3. Leia: MINIO-QUICK-START.md"
    exit 1
fi
