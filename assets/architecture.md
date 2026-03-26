# Architecture Diagram (Text)

```
┌─────────────────────────────────────────────────────────┐
│                     INTERNET                             │
│                                                          │
│  Visitors from 50+ countries                             │
└──────────────────────┬──────────────────────────────────┘
                       │
              ┌────────▼────────┐
              │   Cloudflare    │
              │   CDN + WAF     │
              │   (Free Plan)   │
              │                 │
              │ • Global CDN    │
              │ • DDoS protect  │
              │ • Auto minify   │
              │ • Brotli        │
              │ • Cache: 2h HTML│
              │ • Cache: 1y JS  │
              └────────┬────────┘
                       │ HTTPS
              ┌────────▼────────┐
              │     Nginx       │
              │  Reverse Proxy  │
              │   :80 / :443   │
              │                 │
              │ • SSL terminate │
              │ • Gzip compress │
              │ • Proxy cache   │
              │ • WebP serving  │
              │ • Static: 1y    │
              └────────┬────────┘
                       │ HTTP :80
              ┌────────▼────────┐
              │   WordPress     │
              │  6.7 + Apache   │
              │                 │
              │ Plugins:        │
              │ • Super Cache   │
              │ • Imagify       │
              │ • Jetpack Boost │
              │ • Rank Math     │
              │ • Polylang      │
              │ • Elementor     │
              └────────┬────────┘
                       │ TCP :3306
              ┌────────▼────────┐
              │    MySQL 8.0    │
              │                 │
              │ • Docker volume │
              │ • Health check  │
              │ • Auto restart  │
              └─────────────────┘
```
