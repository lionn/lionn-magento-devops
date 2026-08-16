#!/bin/bash
set -e

MAGE_ROOT="/var/www/html"

# Cria a pasta para os relatórios
REPORT_DIR="$MAGE_ROOT/security_reports"
mkdir -p "$REPORT_DIR"

# Nome do arquivo gerado com timestamp
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
REPORT_FILE="$REPORT_DIR/magento_scan_$TIMESTAMP.txt"

echo "Magento Security Scan Report - $TIMESTAMP" > "$REPORT_FILE"
echo "===================================================" >> "$REPORT_FILE"

# 1. Procurar eval(base64_decode)
echo -e "\n[1] Arquivos com eval(base64_decode):" >> "$REPORT_FILE"
grep -R --line-number --binary-files=without-match "eval(base64_decode" "$MAGE_ROOT" >> "$REPORT_FILE" || true

# 2. Procurar eval simples
echo -e "\n[2] Arquivos com eval(" >> "$REPORT_FILE"
grep -R --line-number --binary-files=without-match "eval(" "$MAGE_ROOT" >> "$REPORT_FILE" || true

# 3. Arquivos PHP dentro de pub/media
echo -e "\n[3] Arquivos PHP dentro de pub/media:" >> "$REPORT_FILE"
find "$MAGE_ROOT/pub/media" -type f -name "*.php" >> "$REPORT_FILE" 2>/dev/null || true

# 4. Verificar as permissões de arquivos e diretórios incorretas
echo -e "\n[4] Diretórios com permissão diferente de 755:" >> "$REPORT_FILE"
find "$MAGE_ROOT" -type d ! -perm 755 >> "$REPORT_FILE"

echo -e "\n[5] Arquivos com permissão diferente de 644 (exceto app/etc/env.php):" >> "$REPORT_FILE"
find "$MAGE_ROOT" -type f ! -name "env.php" ! -perm 644 >> "$REPORT_FILE"

# 5. Verificar permissões do env.php
echo -e "\n[6] Verificar permissões do env.php:" >> "$REPORT_FILE"
ls -l "$MAGE_ROOT/app/etc/env.php" >> "$REPORT_FILE"

echo -e "\nScan completo salvo em: $REPORT_FILE"
