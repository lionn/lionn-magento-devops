#!/bin/bash

LOGFILE="/var/log/setup-base-$(date +%F-%H%M).log"
exec > >(tee -a $LOGFILE) 2>&1

echo "Iniciando a Instalação Segura do Servidor..."

if [ "$EUID" -ne 0 ]; then
  echo "Execute como root!"
  exit
fi

echo "Atualizando o sistema..."
apt update && apt upgrade -y

echo "Configurando o timezone..."
timedatectl set-timezone America/Sao_Paulo

echo "Instalando os pacotes essenciais..."
apt install -y \
    curl \
    wget \
    git \
    ufw \
    fail2ban \
    ca-certificates \
    gnupg \
    lsb-release \
    htop \
    net-tools

# -----------------------------
# FIREWALL HARDENING
# -----------------------------

echo "Configurando o Firewall..."
ufw default deny incoming
ufw default allow outgoing

ufw allow 22
ufw allow 80
ufw allow 443

ufw deny 3306
ufw deny 6379
ufw deny 9200
ufw deny 9000

ufw --force enable

# -----------------------------
# DOCKER INSTALAÇÃO SEGURA
# -----------------------------

echo "Instalando o Docker..."

install -m 0755 -d /etc/apt/keyrings

curl -fsSL https://download.docker.com/linux/debian/gpg | \
gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null

apt update

apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

systemctl enable docker
systemctl start docker

# CORREÇÃO: Integrar UFW com Docker
echo "Integrando UFW com Docker (ufw-docker)..."
wget -O /usr/local/bin/ufw-docker https://github.com/chaifeng/ufw-docker/raw/master/ufw-docker
chmod +x /usr/local/bin/ufw-docker
/usr/local/bin/ufw-docker install
systemctl restart ufw

# -----------------------------
# FAIL2BAN
# -----------------------------

echo "Configurando o Fail2ban..."
cat > /etc/fail2ban/jail.local <<EOF
[DEFAULT]
bantime = 1h
findtime = 10m
maxretry = 5
backend = systemd

[sshd]
enabled = true
port = ssh
filter = sshd
EOF

systemctl enable fail2ban
systemctl restart fail2ban

# -----------------------------
# ESTRUTURA - CORREÇÃO DE USUÁRIO
# -----------------------------

echo "Criando a estrutura..."
mkdir -p /srv/docker/magento2
mkdir -p /srv/docker/magento2/data
mkdir -p /srv/docker/magento2/nginx
mkdir -p /srv/docker/magento2/html
mkdir -p /srv/backups
touch /srv/docker/magento2/Dockerfile
touch /srv/docker/magento2/docker-compose.yml

# CORREÇÃO: Cria o usuário magentouser/magentogroup no host (UID 1001)
# para alinhar com o Dockerfile. Se já existir, ignora.
groupadd -g 1001 magentogroup 2>/dev/null || true
useradd -u 1001 -g magentogroup -m -s /bin/bash magentouser 2>/dev/null || true

chown -R magentouser:magentogroup /srv/docker/magento2
chmod -R 775 /srv/docker/magento2

# -----------------------------
# HARDENING MAGENTO (PolyShell, SessionReaper, StyleSmuggler)
# -----------------------------

echo "Aplicando as mitigações de segurança (PolyShell, SessionReaper, StyleSmuggler)..."

# PolyShell (APSB25-94) - Bloqueia o diretório custom_options
if [ -d "/srv/docker/magento2/html/pub/media/custom_options" ]; then
    find /srv/docker/magento2/html/pub/media/custom_options -type f -name "*.php" -delete 2>/dev/null || true
    chmod 555 /srv/docker/magento2/html/pub/media/custom_options 2>/dev/null || true
fi

# SessionReaper (CVE-2025-54236) - Bloqueia o diretório customer_address
if [ -d "/srv/docker/magento2/html/pub/media/customer_address" ]; then
    find /srv/docker/magento2/html/pub/media/customer_address -type f -name "*.php" -delete 2>/dev/null || true
    chmod 555 /srv/docker/magento2/html/pub/media/customer_address 2>/dev/null || true
fi

# StyleSmuggler (CVE-2026-75650) - Remove o PHP de pub/media
find /srv/docker/magento2/html/pub/media -type f -name "*.php" -delete 2>/dev/null || true

echo "Setup seguro concluído!"
echo "Log salvo em $LOGFILE"
