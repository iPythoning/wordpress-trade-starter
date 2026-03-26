#!/bin/bash
set -euo pipefail

# ============================================================
# WordPress Trade Site — One-Click Setup
# Tested on: Ubuntu 22.04+ / Debian 12+
# ============================================================

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

info()  { echo -e "${GREEN}[INFO]${NC} $1"; }
warn()  { echo -e "${YELLOW}[WARN]${NC} $1"; }
error() { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }

# --- Check root ---
[[ $EUID -ne 0 ]] && error "Please run as root: sudo bash setup.sh"

# --- Read config ---
if [[ -f .env ]]; then
    source .env
else
    read -rp "Enter your domain (e.g. example.com): " DOMAIN
    read -rp "Enter your email (for SSL cert): " EMAIL
    read -rp "Enter MySQL root password: " MYSQL_ROOT_PASSWORD
    read -rp "Enter MySQL database name [wordpress]: " MYSQL_DATABASE
    MYSQL_DATABASE=${MYSQL_DATABASE:-wordpress}
    read -rp "Enter MySQL user [wordpress]: " MYSQL_USER
    MYSQL_USER=${MYSQL_USER:-wordpress}
    read -rp "Enter MySQL user password: " MYSQL_PASSWORD

    cat > .env <<EOF
MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD
MYSQL_DATABASE=$MYSQL_DATABASE
MYSQL_USER=$MYSQL_USER
MYSQL_PASSWORD=$MYSQL_PASSWORD
DOMAIN=$DOMAIN
EMAIL=$EMAIL
EOF
    info "Saved config to .env"
fi

# --- Install Docker ---
if ! command -v docker &>/dev/null; then
    info "Installing Docker..."
    curl -fsSL https://get.docker.com | sh
    systemctl enable docker && systemctl start docker
    info "Docker installed."
else
    info "Docker already installed."
fi

# --- Install Docker Compose plugin ---
if ! docker compose version &>/dev/null; then
    info "Installing Docker Compose plugin..."
    apt-get update && apt-get install -y docker-compose-plugin
fi

# --- Replace domain in nginx.conf ---
info "Configuring Nginx for $DOMAIN..."
sed -i "s/YOUR_DOMAIN/$DOMAIN/g" nginx.conf

# --- Get SSL certificate ---
mkdir -p ssl
if [[ ! -f ssl/fullchain.pem ]]; then
    info "Obtaining SSL certificate via Let's Encrypt..."
    apt-get install -y certbot
    certbot certonly --standalone -d "$DOMAIN" -d "www.$DOMAIN" --email "$EMAIL" --agree-tos --non-interactive
    cp /etc/letsencrypt/live/"$DOMAIN"/fullchain.pem ssl/fullchain.pem
    cp /etc/letsencrypt/live/"$DOMAIN"/privkey.pem ssl/privkey.pem
    info "SSL certificate obtained."

    # Auto-renew cron
    (crontab -l 2>/dev/null; echo "0 3 * * * certbot renew --quiet && cp /etc/letsencrypt/live/$DOMAIN/fullchain.pem $(pwd)/ssl/fullchain.pem && cp /etc/letsencrypt/live/$DOMAIN/privkey.pem $(pwd)/ssl/privkey.pem && docker compose restart nginx") | crontab -
    info "SSL auto-renewal configured."
else
    info "SSL certificate already exists."
fi

# --- Start services ---
info "Starting WordPress stack..."
docker compose up -d

# --- Wait for WordPress ---
info "Waiting for WordPress to be ready..."
for i in $(seq 1 30); do
    if curl -sf http://localhost > /dev/null 2>&1; then
        break
    fi
    sleep 2
done

# --- Print summary ---
echo ""
echo "=========================================="
info "WordPress Trade Site is ready!"
echo "=========================================="
echo ""
echo "  Site URL:   https://$DOMAIN"
echo "  Admin URL:  https://$DOMAIN/wp-admin"
echo ""
echo "  Next steps:"
echo "  1. Open https://$DOMAIN/wp-admin and complete the setup wizard"
echo "  2. Install recommended plugins (see docs/05-theme-plugins.md)"
echo "  3. Configure Cloudflare DNS (see docs/09-cloudflare.md)"
echo ""
echo "=========================================="
