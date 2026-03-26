# 09 — Cloudflare CDN Configuration

## Why Cloudflare?

- **Free plan** includes CDN, DDoS protection, basic WAF
- Global edge network (300+ cities)
- SSL termination at edge
- Bot protection

## Setup

### Step 1: Add your domain

1. Create a [Cloudflare account](https://dash.cloudflare.com/sign-up)
2. Add your domain
3. Cloudflare scans your existing DNS records

### Step 2: Change nameservers

Update your domain registrar's nameservers to Cloudflare's (e.g., `kareem.ns.cloudflare.com`, `tina.ns.cloudflare.com`).

Wait for activation (usually 5-30 minutes).

### Step 3: DNS records

Add these records:

| Type | Name | Content | Proxy |
|------|------|---------|-------|
| A | @ | YOUR_SERVER_IP | Proxied (orange cloud) |
| A | www | YOUR_SERVER_IP | Proxied |

## SSL/TLS Settings

Go to SSL/TLS:

- **Encryption mode**: Full (Strict)
- **Always Use HTTPS**: ON
- **Minimum TLS Version**: 1.2
- **Automatic HTTPS Rewrites**: ON

## Caching Settings

### Cache Rules (free plan: 3 rules)

**Rule 1: Cache HTML pages**
- Match: Hostname = `yourdomain.com` AND NOT URI Path contains `/wp-admin`
- Cache eligibility: Eligible for cache
- Edge TTL: 2 hours
- Browser TTL: 60 seconds

**Rule 2: Long cache for static assets**
- Match: URI Path matches `*.(jpg|jpeg|png|gif|webp|css|js|woff2|svg|ico)`
- Edge TTL: 1 month
- Browser TTL: 1 year

### Purge Cache

After updating content:
1. Cloudflare Dashboard → Caching → Configuration → Purge Everything
2. Or purge specific URLs via API:

```bash
curl -X POST "https://api.cloudflare.com/client/v4/zones/ZONE_ID/purge_cache" \
    -H "Authorization: Bearer YOUR_TOKEN" \
    -H "Content-Type: application/json" \
    --data '{"files":["https://yourdomain.com/updated-page/"]}'
```

## Speed Settings

- **Auto Minify**: JS, CSS, HTML → ON
- **Brotli**: ON
- **Early Hints**: ON
- **HTTP/2**: ON (automatic)
- **HTTP/3 (QUIC)**: ON

## Security

- **Security Level**: Medium
- **Bot Fight Mode**: ON
- **Browser Integrity Check**: ON
- **Hotlink Protection**: ON (prevents others from embedding your images)

## Performance Tips

- **Polish** (Pro plan): Auto-optimize images at edge
- **APO** ($5/month): Full-page caching for WordPress — huge speed boost if budget allows

## Verify

```bash
# Check Cloudflare is active
curl -I https://yourdomain.com
# Look for: cf-cache-status: HIT, server: cloudflare
```

## Next Step

→ [10 — Security](10-security.md)
