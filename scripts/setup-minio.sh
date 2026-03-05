#!/bin/bash

# Script para ativar MinIO como armazenamento de imagens
# Este script configura seu projeto para usar MinIO em vez de armazenamento local
# As imagens vão persistir durante atualizações do código

echo "═══════════════════════════════════════════════════════════════════"
echo "   Configurador de MinIO - Persistência de Imagens"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Verificar se estamos no diretório correto
if [ ! -f ".env.example" ]; then
    echo "❌ Erro: Execute este script na raiz do projeto"
    exit 1
fi

# Verificar se arquivo .env existe
if [ ! -f ".env" ]; then
    echo "⚠️  Arquivo .env não encontrado. Criando a partir de .env.example..."
    cp .env.example .env
fi

echo "📋 Opções de Configuração:"
echo ""
echo "1) Configurar para Desenvolvimento Local (Docker Compose)"
echo "2) Configurar para Produção (Docker Swarm)"
echo "3) Apenas listar configurações atuais"
echo "4) Sair"
echo ""

read -p "Escolha uma opção (1-4): " choice

case $choice in
    1)
        echo ""
        echo "🔧 Configurando MinIO para Desenvolvimento Local..."
        echo ""
        
        # Backup do .env original
        cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
        echo "✓ Backup do .env criado"
        echo ""
        
        # Atualizar variáveis de filesystem
        sed -i '' 's/^FILESYSTEM_DISK=.*/FILESYSTEM_DISK=minio/' .env 2>/dev/null || \
        sed -i 's/^FILESYSTEM_DISK=.*/FILESYSTEM_DISK=minio/' .env
        
        # Garantir que MinIO está configurado
        if ! grep -q "^MINIO_ENDPOINT=" .env; then
            echo "" >> .env
            echo "# MinIO Configuration" >> .env
            echo "MINIO_ENDPOINT=http://minio:9000" >> .env
            echo "MINIO_ACCESS_KEY_ID=minioadmin" >> .env
            echo "MINIO_SECRET_ACCESS_KEY=minioadmin" >> .env
            echo "MINIO_BUCKET=apostolado" >> .env
            echo "MINIO_REGION=us-east-1" >> .env
            echo "MINIO_USE_PATH_STYLE_ENDPOINT=true" >> .env
            echo "MINIO_URL=http://localhost:9000/apostolado" >> .env
            echo "MINIO_PORT=9000" >> .env
            echo "MINIO_CONSOLE_PORT=9001" >> .env
        else
            echo "✓ MinIO já está configurado no .env"
        fi
        
        echo ""
        echo "✅ Configuração Local Concluída!"
        echo ""
        echo "📝 Próximos passos:"
        echo "   1. Execute: docker-compose up -d"
        echo "   2. Acesse MinIO Console: http://localhost:9001"
        echo "   3. Login com: minioadmin / minioadmin"
        echo "   4. Crie um bucket chamado 'apostolado'"
        echo "   5. A aplicação criará imagens lá automaticamente!"
        echo ""
        ;;
        
    2)
        echo ""
        echo "🚀 Configurando MinIO para Produção..."
        echo ""
        
        # Perguntar dados do MinIO
        read -p "MinIO Endpoint (ex: https://minio.seu-dominio.com): " minio_endpoint
        read -p "MinIO Access Key ID: " minio_key
        read -p "MinIO Secret Access Key: " minio_secret
        read -p "MinIO Bucket (padrão: apostolado): " minio_bucket
        minio_bucket=${minio_bucket:-apostolado}
        read -p "MinIO URL Pública (ex: https://minio.seu-dominio.com/apostolado): " minio_url
        
        # Backup
        cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
        echo "✓ Backup do .env criado"
        echo ""
        
        # Atualizar .env
        sed -i '' "s|^FILESYSTEM_DISK=.*|FILESYSTEM_DISK=minio|" .env 2>/dev/null || \
        sed -i "s|^FILESYSTEM_DISK=.*|FILESYSTEM_DISK=minio|" .env
        
        sed -i '' "s|^MINIO_ENDPOINT=.*|MINIO_ENDPOINT=$minio_endpoint|" .env 2>/dev/null || \
        sed -i "s|^MINIO_ENDPOINT=.*|MINIO_ENDPOINT=$minio_endpoint|" .env
        
        sed -i '' "s|^MINIO_ACCESS_KEY_ID=.*|MINIO_ACCESS_KEY_ID=$minio_key|" .env 2>/dev/null || \
        sed -i "s|^MINIO_ACCESS_KEY_ID=.*|MINIO_ACCESS_KEY_ID=$minio_key|" .env
        
        sed -i '' "s|^MINIO_SECRET_ACCESS_KEY=.*|MINIO_SECRET_ACCESS_KEY=$minio_secret|" .env 2>/dev/null || \
        sed -i "s|^MINIO_SECRET_ACCESS_KEY=.*|MINIO_SECRET_ACCESS_KEY=$minio_secret|" .env
        
        sed -i '' "s|^MINIO_BUCKET=.*|MINIO_BUCKET=$minio_bucket|" .env 2>/dev/null || \
        sed -i "s|^MINIO_BUCKET=.*|MINIO_BUCKET=$minio_bucket|" .env
        
        sed -i '' "s|^MINIO_URL=.*|MINIO_URL=$minio_url|" .env 2>/dev/null || \
        sed -i "s|^MINIO_URL=.*|MINIO_URL=$minio_url|" .env
        
        echo ""
        echo "✅ Configuração de Produção Concluída!"
        echo ""
        echo "📝 Configuração Salva:"
        echo "   Endpoint: $minio_endpoint"
        echo "   Bucket: $minio_bucket"
        echo "   URL Pública: $minio_url"
        echo ""
        echo "🔒 Segurança:"
        echo "   - Altere MINIO_ACCESS_KEY_ID e MINIO_SECRET_ACCESS_KEY em produção"
        echo "   - Use valores fortes e aleatórios"
        echo "   - Não commit .env em git (use .env.example)"
        echo ""
        ;;
        
    3)
        echo ""
        echo "📋 Configurações Atuais de Storage:"
        echo ""
        
        grep "^FILESYSTEM_DISK\|^MINIO_" .env | sort
        
        echo ""
        echo "Interpretação:"
        
        if grep -q "^FILESYSTEM_DISK=minio" .env; then
            echo "✅ MinIO está ATIVADO"
        else
            echo "❌ MinIO está DESATIVADO (usando: $(grep '^FILESYSTEM_DISK=' .env | cut -d= -f2))"
        fi
        
        echo ""
        ;;
        
    4)
        echo "Saindo..."
        exit 0
        ;;
        
    *)
        echo "❌ Opção inválida"
        exit 1
        ;;
esac

echo ""
echo "═══════════════════════════════════════════════════════════════════"
echo "   Documentação: Leia MINIO-PERSISTENCE-CONFIG.md"
echo "═══════════════════════════════════════════════════════════════════"
