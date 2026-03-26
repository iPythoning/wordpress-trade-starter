# 07 — SEO Optimization (Rank Math)

## Install & Setup

1. Install Rank Math plugin
2. Run the setup wizard:
   - Business type: **Corporation** or **Organization**
   - Enter your logo, social profiles
   - Enable: Sitemap, Schema, 404 Monitor, Redirections

## On-Page SEO Checklist

For every product/page:

- [ ] **Focus keyword** — Set in Rank Math metabox (e.g., "3 axle dump trailer")
- [ ] **Title tag** — Include keyword, under 60 chars (e.g., "3 Axle Dump Trailer | 50CBM | TITAN Vehicle")
- [ ] **Meta description** — 120-155 chars, include keyword + call to action
- [ ] **H1 heading** — One per page, contains focus keyword
- [ ] **URL slug** — Short, keyword-rich (e.g., `/products/3-axle-dump-trailer/`)
- [ ] **Image alt text** — Describe the image with keywords
- [ ] **Internal links** — Link to related products/pages

## Schema / Structured Data

Rank Math auto-generates:
- **Organization** schema (company name, logo, contact)
- **Product** schema (for product pages)
- **Article** schema (for blog posts)
- **FAQ** schema (for FAQ pages)
- **Breadcrumb** schema

Verify with [Google Rich Results Test](https://search.google.com/test/rich-results).

## XML Sitemap

Rank Math auto-generates at `yourdomain.com/sitemap_index.xml`.

Submit to:
1. [Google Search Console](https://search.google.com/search-console) → Sitemaps → Add
2. [Bing Webmaster Tools](https://www.bing.com/webmasters) → Sitemaps → Submit

## Robots.txt

WordPress auto-generates a basic `robots.txt`. Add:

```
User-agent: *
Allow: /
Disallow: /wp-admin/
Sitemap: https://yourdomain.com/sitemap_index.xml
```

## Blog Strategy for B2B

Write 2-4 articles per month targeting buyer keywords:

- "How to choose the right [product]"
- "Top 5 mistakes when importing [product] from China"
- "[Product] specifications guide"
- "Case study: [Customer] uses [product] for [use case]"

Each article should:
- Target a specific long-tail keyword
- Be 800-1500 words
- Include product images
- Link to relevant product pages
- Have translations for your key markets

## Open Graph & Social

Rank Math auto-adds Open Graph tags. Set a default social image in:
Rank Math → General Settings → Social → Default Social Image

## Next Step

→ [08 — Performance](08-performance.md)
