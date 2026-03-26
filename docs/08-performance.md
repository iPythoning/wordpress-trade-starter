# 08 — Performance Optimization

## Three-Layer Cache Architecture

```
Browser Request
    → Cloudflare CDN cache (2h TTL for HTML, 1y for static)
        → Nginx proxy cache (10min HTML, 30d static)
            → WP Super Cache (static HTML files)
                → WordPress PHP (only on cache miss)
```

## Layer 1: WP Super Cache

Already configured in our `.htaccess` template.

### Verify

```bash
# Check cache files exist
docker compose exec wordpress ls /var/www/html/wp-content/cache/supercache/
```

Visit your site in incognito — check HTML source for `<!-- Dynamic page generated in X seconds. -->` followed by `<!-- Cached page -->`.

### Settings

- Caching: **ON**
- Cache delivery: **mod_rewrite** (fastest)
- Cache timeout: 1800 seconds (30 minutes)
- Preload: OFF (Cloudflare handles warming)

## Layer 2: Nginx Proxy Cache

Our `nginx.conf` includes:
- 10-minute cache for HTML pages
- 30-day cache for static assets (images, CSS, JS)
- Cache bypass for logged-in users, POST requests, query strings

### Verify

```bash
curl -I https://yourdomain.com
# Look for: X-Cache-Status: HIT
```

### Purge Cache

```bash
# Clear Nginx cache
docker compose exec nginx rm -rf /tmp/nginx-cache/*
```

## Layer 3: Cloudflare CDN

See [09-cloudflare.md](09-cloudflare.md) for full setup.

## Image Optimization

### Imagify

- Auto-converts to WebP on upload
- Lossless compression preserves quality
- Backs up originals

### Nginx/Apache WebP Serving

Our config automatically serves `.webp` files when:
1. The browser sends `Accept: image/webp` header
2. A `.webp` version exists on disk

### Image Best Practices

- Upload at max 2560px width (Imagify auto-resizes)
- Use descriptive filenames: `3-axle-dump-trailer-front-view.jpg`
- Always set alt text
- Use `loading="lazy"` for below-the-fold images (Jetpack Boost adds this)

## Critical CSS (Jetpack Boost)

Jetpack Boost generates critical CSS for each page template, inlining above-the-fold styles and deferring the rest.

Enable in Jetpack → Boost → Critical CSS.

## Browser Caching

Our `.htaccess` / `nginx.conf` set:
- Images/fonts: 1 year
- CSS/JS: 1 month
- HTML: 60 seconds (Cloudflare handles longer caching)

## Gzip Compression

Enabled in both Nginx and Apache configs. Compresses text-based assets by ~70%.

## Monitoring

Test regularly with:
- [PageSpeed Insights](https://pagespeed.web.dev/)
- [GTmetrix](https://gtmetrix.com/)
- [WebPageTest](https://www.webpagetest.org/)

## Next Step

→ [09 — Cloudflare](09-cloudflare.md)
