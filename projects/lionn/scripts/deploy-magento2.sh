#!/bin/bash
set -e

MAGE_ROOT="/var/www/html"
MAGE_USER="magentouser"
MAGE_GROUP="magentogroup"

echo "======================================"
echo "Magento 2 Deploy (Docker + Hardened)"
echo "======================================"

# -------------------------------
# Corrigir as permissões ANTES
# -------------------------------

echo "Ajustando as permissões..."

chown -R $MAGE_USER:$MAGE_GROUP $MAGE_ROOT

# Diretórios: 770 (dono + grupo, sem "outros")
find $MAGE_ROOT/var -type d -exec chmod 770 {} \;
find $MAGE_ROOT/generated -type d -exec chmod 770 {} \;
find $MAGE_ROOT/pub/static -type d -exec chmod 770 {} \;
find $MAGE_ROOT/pub/media -type d -exec chmod 770 {} \;

# Arquivos: 660 (dono + grupo, sem "outros")
find $MAGE_ROOT/var -type f -exec chmod 660 {} \;
find $MAGE_ROOT/generated -type f -exec chmod 660 {} \;
find $MAGE_ROOT/pub/static -type f -exec chmod 660 {} \;
find $MAGE_ROOT/pub/media -type f -exec chmod 660 {} \;

# -------------------------------
# Espera o OpenSearch
# -------------------------------

echo "Aguardando o OpenSearch..."
until curl -s http://magento_opensearch:9200/_cluster/health | grep -q '"status":"'; do
    sleep 3
done

# -------------------------------
# Limpeza forte
# -------------------------------

echo "Limpando os caches e arquivos gerados..."

rm -rf $MAGE_ROOT/generated/*
rm -rf $MAGE_ROOT/pub/static/*
rm -rf $MAGE_ROOT/var/cache/*
rm -rf $MAGE_ROOT/var/page_cache/*

# -------------------------------
# Comandos do Magento
# -------------------------------

echo "Executando os comandos do Magento... (atualizar/compilar/deploy)"

su -s /bin/bash $MAGE_USER -c "php $MAGE_ROOT/bin/magento setup:upgrade"
su -s /bin/bash $MAGE_USER -c "php $MAGE_ROOT/bin/magento setup:di:compile"
su -s /bin/bash $MAGE_USER -c "php $MAGE_ROOT/bin/magento setup:static-content:deploy pt_BR en_US es_ES -f"
su -s /bin/bash $MAGE_USER -c "php $MAGE_ROOT/bin/magento cache:flush"
su -s /bin/bash $MAGE_USER -c "php $MAGE_ROOT/bin/magento cache:clean"

# -------------------------------
# HARDENING (Segurança)
# -------------------------------

echo "Aplicando hardening..."

# --- Mitigação PolyShell (APSB25-94) ---
# Bloqueia acesso e escrita no diretório de custom_options
# Isso impede que arquivos enviados sejam servidos ou executados
echo "Aplicando mitigações PolyShell..."
if [ -d "$MAGE_ROOT/pub/media/custom_options" ]; then
    find $MAGE_ROOT/pub/media/custom_options -type f -name "*.php" -delete 2>/dev/null || true
    chown root:root $MAGE_ROOT/pub/media/custom_options
    chmod 555 $MAGE_ROOT/pub/media/custom_options
    # Garante que o .htaccess de bloqueio exista (se não existir, o sistema cria um)
    if [ ! -f "$MAGE_ROOT/pub/media/custom_options/.htaccess" ]; then
        echo "Deny from all" > $MAGE_ROOT/pub/media/custom_options/.htaccess
        chmod 444 $MAGE_ROOT/pub/media/custom_options/.htaccess
    fi
fi

# --- Mitigação SessionReaper (CVE-2025-54236) ---
# Bloqueia uploads no diretório de endereços de clientes
echo "Aplicando mitigações SessionReaper..."
if [ -d "$MAGE_ROOT/pub/media/customer_address" ]; then
    rm -rf $MAGE_ROOT/pub/media/customer_address/*
    chown root:root $MAGE_ROOT/pub/media/customer_address
    chmod 555 $MAGE_ROOT/pub/media/customer_address
fi

# --- Mitigação Genérica para StyleSmuggler (CVE-2026-75650) ---
# Aplica as proteções de .htaccess recomendadas pelo Adobe para pub/media
# Isso ajuda a prevenir execução de PHP em diretórios de mídia
echo "Aplicando mitigações StyleSmuggler (genérico)..."
if [ -f "$MAGE_ROOT/pub/media/.htaccess" ]; then
    # Garante que a linha de desabilitar engine PHP esteja presente
    if ! grep -q "php_flag engine 0" $MAGE_ROOT/pub/media/.htaccess; then
        echo "php_flag engine 0" >> $MAGE_ROOT/pub/media/.htaccess
    fi
else
    echo "php_flag engine 0" > $MAGE_ROOT/pub/media/.htaccess
    chmod 444 $MAGE_ROOT/pub/media/.htaccess
fi

# Remove qualquer PHP malicioso que pode ter sido enviado para o diretório pub/media
find $MAGE_ROOT/pub/media -type f -name "*.php" -delete

# Garante que o bin/magento é executável
chmod +x $MAGE_ROOT/bin/magento

echo "Deploy do Magento finalizado com sucesso!"
