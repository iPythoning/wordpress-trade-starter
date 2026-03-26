# 02 — Docker Deploy

## Install Docker

```bash
curl -fsSL https://get.docker.com | sh
systemctl enable docker && systemctl start docker
```

Verify: `docker compose version` should show v2.x.

## Project Structure

```bash
mkdir -p /root/wordpress-site && cd /root/wordpress-site
# Copy docker-compose.yml, nginx.conf, .env from this repo
```

## Configure Environment

```bash
cp .env.example .env
nano .env
```

Set strong passwords and your domain:

```
MYSQL_ROOT_PASSWORD=your_strong_root_password
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=your_strong_db_password
DOMAIN=yourdomain.com
EMAIL=you@email.com
```

## Launch

```bash
docker compose up -d
```

## Verify

```bash
# Check all 3 containers are running
docker compose ps

# Check logs
docker compose logs -f wordpress
```

You should see:
- `db` — healthy
- `wordpress` — running on :80
- `nginx` — running on :80/:443

## Useful Commands

```bash
# Stop all services
docker compose down

# Restart a single service
docker compose restart nginx

# View WordPress files
docker compose exec wordpress ls /var/www/html

# Access MySQL
docker compose exec db mysql -u wordpress -p
```

## Backup

```bash
# Database backup
docker compose exec db mysqldump -u root -p wordpress > backup.sql

# Files backup
docker cp $(docker compose ps -q wordpress):/var/www/html ./wp-backup
```

## Next Step

→ [03 — SSL & HTTPS](03-ssl-https.md)
