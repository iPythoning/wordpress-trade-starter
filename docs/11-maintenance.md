# 11 — Maintenance & Monitoring

## Daily Operations

### Check Site Health

```bash
# Quick health check
curl -sf -o /dev/null -w "%{http_code} %{time_total}s" https://yourdomain.com

# Check all containers running
docker compose ps

# Check disk usage
df -h
docker system df
```

### Monitor Logs

```bash
# WordPress/Apache errors
docker compose logs --tail 50 wordpress

# Nginx access log
docker compose logs --tail 50 nginx

# MySQL errors
docker compose logs --tail 50 db
```

## Weekly Tasks

- [ ] Check WordPress Dashboard → Updates
- [ ] Review Cloudflare analytics for unusual traffic
- [ ] Test contact form submission
- [ ] Verify SSL certificate expiry: `echo | openssl s_client -servername yourdomain.com -connect yourdomain.com:443 2>/dev/null | openssl x509 -noout -dates`

## Monthly Tasks

- [ ] Run [PageSpeed Insights](https://pagespeed.web.dev/) test
- [ ] Check Search Console for crawl errors
- [ ] Update plugins (test on staging if critical)
- [ ] Review and clean up unused media files
- [ ] Check backup integrity (restore test)

## Update Workflow

```bash
# 1. Backup first
docker compose exec -T db mysqldump -u root -pPASSWORD wordpress > backup-before-update.sql

# 2. Update WordPress core + plugins via admin panel

# 3. Pull latest Docker images
docker compose pull
docker compose up -d

# 4. Verify site works
curl -sf https://yourdomain.com
```

## Disk Cleanup

```bash
# Remove old Docker images
docker image prune -a

# Clear WP Super Cache
docker compose exec wordpress rm -rf /var/www/html/wp-content/cache/supercache/*

# Clear Nginx cache
docker compose exec nginx rm -rf /tmp/nginx-cache/*

# Purge Cloudflare cache
# Dashboard → Caching → Purge Everything
```

## Uptime Monitoring

Set up free monitoring with [UptimeRobot](https://uptimerobot.com/):
1. Add HTTPS monitor for `https://yourdomain.com`
2. Check interval: 5 minutes
3. Alert via email/Telegram on downtime

## Disaster Recovery

If site goes down:

```bash
# 1. Check what's wrong
docker compose ps
docker compose logs --tail 100

# 2. Restart everything
docker compose restart

# 3. If database corrupted, restore from backup
docker compose down
docker volume rm wordpress-site_dbdata
docker compose up -d
docker compose exec -T db mysql -u root -pPASSWORD wordpress < backup.sql

# 4. Clear all caches after recovery
docker compose exec nginx rm -rf /tmp/nginx-cache/*
# Purge Cloudflare cache
```

## Scaling

When you outgrow a single VPS:
1. **Object storage** — Move media to S3/R2 + CDN
2. **Redis cache** — Add Redis for database query caching
3. **Dedicated DB** — Separate MySQL to its own server
4. **Multiple sites** — Use this template for each new brand/domain

---

**Congratulations!** You now have a fully optimized, production-ready WordPress trade site. 🎉
