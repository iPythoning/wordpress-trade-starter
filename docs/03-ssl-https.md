# 03 — SSL & HTTPS

## Option A: Let's Encrypt (Recommended)

Free, auto-renewable SSL certificate.

### Step 1: Stop Nginx temporarily

```bash
docker compose stop nginx
```

### Step 2: Install Certbot and get certificate

```bash
apt install -y certbot
certbot certonly --standalone -d yourdomain.com -d www.yourdomain.com \
    --email you@email.com --agree-tos --non-interactive
```

### Step 3: Copy certificates

```bash
mkdir -p ssl
cp /etc/letsencrypt/live/yourdomain.com/fullchain.pem ssl/fullchain.pem
cp /etc/letsencrypt/live/yourdomain.com/privkey.pem ssl/privkey.pem
```

### Step 4: Start Nginx

```bash
docker compose start nginx
```

### Step 5: Auto-renewal

```bash
# Add to crontab
crontab -e
```

Add this line:

```
0 3 * * * certbot renew --quiet && cp /etc/letsencrypt/live/yourdomain.com/fullchain.pem /root/wordpress-site/ssl/fullchain.pem && cp /etc/letsencrypt/live/yourdomain.com/privkey.pem /root/wordpress-site/ssl/privkey.pem && docker compose -f /root/wordpress-site/docker-compose.yml restart nginx
```

## Option B: Cloudflare SSL (Simplest)

If you use Cloudflare as DNS proxy:

1. Set Cloudflare SSL mode to **Full (Strict)**
2. Go to SSL/TLS → Origin Server → Create Certificate
3. Download the certificate and key
4. Save as `ssl/fullchain.pem` and `ssl/privkey.pem`

This certificate is valid for 15 years and auto-trusted by Cloudflare.

## Verify

```bash
curl -I https://yourdomain.com
# Should show HTTP/2 200
```

Check with [SSL Labs](https://www.ssllabs.com/ssltest/) — aim for A or A+ rating.

## Next Step

→ [04 — WordPress Setup](04-wordpress-setup.md)
