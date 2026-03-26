# 10 — Security Hardening

## WordPress Security Checklist

### Authentication

- [ ] Use strong admin password (16+ chars, mixed)
- [ ] Don't use "admin" as username
- [ ] Limit login attempts (Cloudflare rate limiting or plugin)
- [ ] Use HTTPS for admin: `define('FORCE_SSL_ADMIN', true);`

### File System

- [ ] Disable file editor: `define('DISALLOW_FILE_EDIT', true);`
- [ ] Correct file permissions:

```bash
docker compose exec wordpress bash -c '
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;
chmod 600 /var/www/html/wp-config.php
'
```

### Block Common Attacks

Add to Nginx (`location` blocks) or `.htaccess`:

```apache
# Block xmlrpc.php (used for brute force attacks)
<Files xmlrpc.php>
    Require all denied
</Files>

# Block wp-config.php access
<Files wp-config.php>
    Require all denied
</Files>

# Hide WordPress version
<IfModule mod_headers.c>
    Header unset X-Powered-By
</IfModule>
```

### WordPress Updates

- Keep WordPress core, themes, and plugins updated
- Enable auto-updates for minor releases (WordPress does this by default)
- Test plugin updates on a staging site first

## Server Security

### Firewall

```bash
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable
```

### SSH

- Use SSH key authentication, disable password login
- Change default SSH port (optional): edit `/etc/ssh/sshd_config`

### Docker

- Don't expose MySQL port (our config uses `expose`, not `ports`)
- Use Docker secrets for passwords in production
- Keep Docker images updated: `docker compose pull && docker compose up -d`

## Cloudflare Security

- Enable **Bot Fight Mode**
- Enable **Browser Integrity Check**
- Set **Security Level** to Medium
- Enable **Hotlink Protection**
- Add firewall rules to block specific countries (if needed)

## Backup Strategy

```bash
# Daily database backup
0 2 * * * docker compose -f /root/wordpress-site/docker-compose.yml exec -T db mysqldump -u root -pYOUR_PASSWORD wordpress | gzip > /root/backups/db-$(date +\%Y\%m\%d).sql.gz

# Weekly files backup
0 3 * * 0 docker cp $(docker compose -f /root/wordpress-site/docker-compose.yml ps -q wordpress):/var/www/html /root/backups/wp-files-$(date +\%Y\%m\%d)

# Keep last 30 days
find /root/backups -mtime +30 -delete
```

## Security Monitoring

- Check Cloudflare analytics for unusual traffic patterns
- Monitor `wp-login.php` access logs
- Set up uptime monitoring (e.g., UptimeRobot, free tier)

## Next Step

→ [11 — Maintenance](11-maintenance.md)
