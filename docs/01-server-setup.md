# 01 — Server Setup

## Recommended Specs

| Tier | CPU | RAM | Disk | Monthly Cost | Good For |
|------|-----|-----|------|-------------|----------|
| Starter | 1 core | 1 GB | 20 GB SSD | $5-10 | Small catalog sites |
| Standard | 2 cores | 2 GB | 40 GB SSD | $10-20 | Most trade sites |
| Production | 4 cores | 4 GB | 80 GB SSD | $20-40 | High traffic + large media |

## VPS Providers

- **Recommended**: Contabo, Hetzner, DigitalOcean, Vultr
- **For China-based businesses**: Alibaba Cloud (international), Tencent Cloud
- Choose a datacenter close to your target market (US/EU for Western clients, Singapore for SEA)

## Initial Server Setup

```bash
# Update system
apt update && apt upgrade -y

# Set timezone
timedoc set-timezone UTC

# Create swap (for 1GB RAM servers)
fallocate -l 2G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap sw 0 0' >> /etc/fstab

# Basic firewall
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable

# Install essentials
apt install -y curl git unzip htop
```

## Security Basics

```bash
# Disable root password login (use SSH key instead)
sed -i 's/^PermitRootLogin yes/PermitRootLogin prohibit-password/' /etc/ssh/sshd_config
systemctl restart sshd
```

## Next Step

→ [02 — Docker Deploy](02-docker-deploy.md)
