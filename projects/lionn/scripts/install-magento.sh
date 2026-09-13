#!/bin/bash
set -e

# Carrega as variáveis do .env
if [ ! -f .env ]; then
    echo "Arquivo .env não encontrado!"
    exit 1
fi

set -a
source .env
set +a

echo "Instalando o Magento 2..."

php -d memory_limit=2G bin/magento setup:install \
  --base-url="${MAGENTO_BASE_URL}" \
  --db-host="${MAGENTO_DB_HOST}" \
  --db-name="${MAGENTO_DB_NAME}" \
  --db-user="${MAGENTO_DB_USER}" \
  --db-password="${MAGENTO_DB_PASSWORD}" \
  --backend-frontname="${MAGENTO_ADMIN_FRONTNAME}" \
  --admin-firstname="${MAGENTO_ADMIN_FIRSTNAME}" \
  --admin-lastname="${MAGENTO_ADMIN_LASTNAME}" \
  --admin-email="${MAGENTO_ADMIN_EMAIL}" \
  --admin-user="${MAGENTO_ADMIN_USER}" \
  --admin-password="${MAGENTO_ADMIN_PASSWORD}" \
  --language="pt_BR" \
  --currency="BRL" \
  --timezone="America/Sao_Paulo" \
  --use-rewrites=1 \
  --search-engine=opensearch \
  --opensearch-host="${OPENSEARCH_HOST}" \
  --opensearch-port="${OPENSEARCH_PORT}" \
  --opensearch-index-prefix="${OPENSEARCH_INDEX_PREFIX}" \
  --opensearch-timeout=15 \
  --session-save=redis \
  --session-save-redis-host="${REDIS_HOST}" \
  --session-save-redis-port="${REDIS_PORT}" \
  --session-save-redis-password="${REDIS_PASSWORD}" \
  --cache-backend=redis \
  --cache-backend-redis-server="${REDIS_HOST}" \
  --cache-backend-redis-port="${REDIS_PORT}" \
  --cache-backend-redis-password="${REDIS_PASSWORD}" \
  --page-cache=redis \
  --page-cache-redis-server="${REDIS_HOST}" \
  --page-cache-redis-port="${REDIS_PORT}" \
  --page-cache-redis-password="${REDIS_PASSWORD}"

echo "Magento 2 instalado com sucesso!"
