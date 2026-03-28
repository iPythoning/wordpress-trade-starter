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
- **Bot Fight Mode**: ON (for regular bots)
- **Browser Integrity Check**: ON
- **Hotlink Protection**: ON (prevents others from embedding your images)

### AI Bots: Allow, Don't Block

**Critical for GEO (Generative Engine Optimization)**: Cloudflare's "AI Scrapers and Crawlers" feature blocks AI search engine bots by default. If you want your site to appear in AI-generated answers (Google AI Overviews, Perplexity, ChatGPT Search, Claude Web, Bing Copilot), you **must** allow these bots:

1. Cloudflare Dashboard → Security → Bots
2. Turn **OFF** "AI Scrapers and Crawlers" blocking
3. Or create custom WAF rules to selectively allow:

| Bot | User-Agent | Source |
|-----|-----------|--------|
| GPTBot | `GPTBot` | OpenAI (ChatGPT Search) |
| ChatGPT-User | `ChatGPT-User` | OpenAI browse mode |
| Google-Extended | `Google-Extended` | Google AI Overviews |
| PerplexityBot | `PerplexityBot` | Perplexity AI |
| ClaudeBot | `ClaudeBot` | Anthropic (Claude Web) |
| anthropic-ai | `anthropic-ai` | Anthropic training |
| Bytespider | `Bytespider` | ByteDance AI |
| cohere-ai | `cohere-ai` | Cohere AI |
| CCBot | `CCBot` | Common Crawl |

**Why this matters**: If AI bots can't crawl your site, your content will never appear in AI-generated answers — which is increasingly where B2B buyers start their research.

See [07-seo-optimization.md](07-seo-optimization.md) for the full GEO setup guide.

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
