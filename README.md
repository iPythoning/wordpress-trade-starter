# WordPress Trade Starter

[![Clawhub](https://img.shields.io/badge/Clawhub-wordpress--trade--site-blue)](https://clawhub.ai/ipythoning/wordpress-trade-site)

**English | [中文](README.zh-CN.md)**

> Production-ready WordPress template for international trade businesses. Docker-based, performance-optimized, multilingual-ready.

```
                    ┌─────────────┐
                    │  Cloudflare  │  CDN + WAF + SSL
                    │   (Free)     │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │    Nginx     │  Reverse Proxy + Cache + Gzip
                    │   :80/:443  │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  WordPress   │  6.7 + Apache
                    │   + Plugins  │  Super Cache / Imagify / Rank Math
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │   MySQL 8    │  Persistent Volume
                    └─────────────┘
```

## Features

- **One-click deploy** — `setup.sh` handles Docker, SSL, and Nginx configuration
- **Triple-layer cache** — WP Super Cache + Nginx proxy cache + Cloudflare CDN
- **Auto WebP** — Imagify converts images; Nginx/Apache serve WebP to supported browsers
- **SEO-ready** — Rank Math with structured data, XML sitemap, Open Graph
- **GEO-ready** — Generative Engine Optimization for AI search (Google AI Overviews, Perplexity, ChatGPT Search, Claude Web)
- **Multilingual** — Polylang for multi-language support (EN/ZH/RU/ES/...)
- **Security hardened** — HTTPS everywhere, file editor disabled, Cloudflare WAF
- **Production-tested** — Battle-tested on a real B2B semi-trailer manufacturer site

## AI-Guided Setup (via OpenClaw)

Install the Clawhub skill and let an AI agent guide you through the entire process interactively:

```bash
clawhub install wordpress-trade-site
```

Then tell your OpenClaw agent: **"帮我建一个外贸独立站"** — it will walk you through 9 phases from server setup to final verification.

## Quick Start (5 minutes)

### Prerequisites

- Linux server (Ubuntu 22.04+ recommended), 1 CPU / 1GB RAM minimum
- Domain name with DNS access

### Deploy

```bash
git clone https://github.com/iPythoning/wordpress-trade-starter.git
cd wordpress-trade-starter
cp .env.example .env        # Edit with your domain & passwords
sudo bash setup.sh
```

That's it. Open `https://your-domain.com/wp-admin` to complete the WordPress setup wizard.

### Manual Setup

If you prefer manual control, see [docs/02-docker-deploy.md](docs/02-docker-deploy.md).

## Documentation

| # | Topic | Description |
|---|-------|-------------|
| 01 | [Server Setup](docs/01-server-setup.md) | Server selection and initial configuration |
| 02 | [Docker Deploy](docs/02-docker-deploy.md) | Deploy WordPress with Docker Compose |
| 03 | [SSL & HTTPS](docs/03-ssl-https.md) | Let's Encrypt certificate setup |
| 04 | [WordPress Setup](docs/04-wordpress-setup.md) | Basic WordPress configuration |
| 05 | [Theme & Plugins](docs/05-theme-plugins.md) | Recommended theme and plugin stack |
| 06 | [Multilingual](docs/06-multilingual.md) | Multi-language setup with Polylang |
| 07 | [SEO](docs/07-seo-optimization.md) | SEO optimization with Rank Math |
| 08 | [Performance](docs/08-performance.md) | Full performance optimization guide |
| 09 | [Cloudflare](docs/09-cloudflare.md) | Cloudflare CDN configuration |
| 10 | [Security](docs/10-security.md) | Security hardening checklist |
| 11 | [Maintenance](docs/11-maintenance.md) | Daily operations and monitoring |
| 12 | [GEO Optimization](docs/12-geo-optimization.md) | AI search engine optimization (citability, llms.txt, schema) |

## Recommended Plugin Stack

| Plugin | Purpose | Free? |
|--------|---------|-------|
| [Astra](https://wpastra.com/) | Lightweight theme, Elementor-compatible | Yes |
| [Elementor](https://elementor.com/) | Visual page builder | Freemium |
| [Rank Math](https://rankmath.com/) | SEO (sitemap, schema, meta) | Yes |
| [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) | Page caching | Yes |
| [Imagify](https://imagify.io/) | Image optimization + WebP | Freemium |
| [Jetpack Boost](https://jetpack.com/boost/) | Critical CSS, lazy loading | Yes |
| [Polylang](https://polylang.pro/) | Multilingual content | Yes |
| [Contact Form 7](https://contactform7.com/) | Contact forms | Yes |
| [Flamingo](https://wordpress.org/plugins/flamingo/) | Store CF7 submissions in WP admin | Yes |
| [Chaty](https://premio.io/downloads/chaty/) | WhatsApp/chat widget | Freemium |
| [eCommerce Product Catalog](https://implecode.com/) | Product showcase (no WooCommerce) | Yes |

## Performance Results

Tested on a 1-core / 1GB VPS with Cloudflare Free plan:

| Metric | Before | After |
|--------|--------|-------|
| PageSpeed Desktop | 45 | 78+ |
| TTFB | 1.8s | 0.3s |
| LCP | 4.2s | 2.1s |
| Total page size | 3.2MB | 1.1MB |

## File Structure

```
├── docker-compose.yml    # Docker orchestration (WordPress + MySQL + Nginx)
├── nginx.conf            # Nginx: SSL, proxy cache, Gzip, WebP, Cloudflare, security headers
├── .htaccess             # Apache: Super Cache, browser cache, WebP, Gzip
├── wp-config-extra.php   # Extra wp-config.php snippets
├── setup.sh              # One-click deployment script
├── .env.example          # Environment variables template
├── assets/
│   └── geo-functions.php # GEO: AI search engine optimization (JSON-LD, robots.txt, meta)
└── docs/                 # 11-part documentation
```

## Who Is This For?

- **Foreign trade companies** building B2B websites (manufacturers, exporters, trading companies)
- **WordPress beginners** who want a production-ready starting point
- **Developers** deploying WordPress sites for international clients

## Contributing

Issues and PRs welcome! Please see our documentation for the technical details.

## License

[MIT](LICENSE)

---

**Built with real-world experience from [TitanPuls.com](https://titanpuls.com)** — a semi-trailer manufacturer serving 50+ countries.
