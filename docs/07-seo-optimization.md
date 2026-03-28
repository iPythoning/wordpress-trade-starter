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

## GEO — Generative Engine Optimization

GEO optimizes your site for AI search engines: Google AI Overviews, Perplexity, ChatGPT Search, Claude Web, and Bing Copilot. These engines generate answers by citing structured, authoritative sources.

### Quick Setup

Add the GEO functions to your child theme:

```php
// In your child theme's functions.php:
require_once get_stylesheet_directory() . '/geo-functions.php';
```

Copy `assets/geo-functions.php` to your child theme directory.

### What GEO Does

| Feature | Purpose |
|---------|---------|
| **Triple JSON-LD Schema** | Organization + WebSite + Article/Speakable — AI engines parse structured data first |
| **AI-friendly robots.txt** | Explicitly allows GPTBot, ClaudeBot, PerplexityBot, etc. |
| **Speakable Schema** | Marks first 2 paragraphs for AI voice assistants |
| **AI summary meta** | `<meta name="summary">` for quick-answer extraction |
| **AI bot tracking** | `X-AI-Bot` header for GA4 analytics |
| **Content marking** | `data-ai-summary` on first paragraph |

### Customize for Your Business

Edit `geo-functions.php` and update:

```php
'knowsAbout' => [
    'Your Industry',
    'Your Product Category',
    'Your Expertise',
],
'areaServed' => [
    ['@type' => 'Country', 'name' => 'China'],
    // Add your target markets
],
```

### Cloudflare: Allow AI Bots

**Critical**: Cloudflare's "AI Scrapers and Crawlers" feature blocks AI bots by default. You **must** disable it:

1. Cloudflare Dashboard → Security → Bots
2. Turn **OFF** "AI Scrapers and Crawlers" blocking
3. Or create custom rules to allow specific bots (GPTBot, ClaudeBot, etc.)

See [09-cloudflare.md](09-cloudflare.md) for details.

### Verify GEO

```bash
# Check robots.txt allows AI bots
curl -s https://yourdomain.com/robots.txt | grep -A1 "GPTBot"

# Check JSON-LD schemas
curl -s https://yourdomain.com/ | grep -c "ld+json"
# Should return 2+ (Organization + WebSite)

# Test with Google Rich Results
# https://search.google.com/test/rich-results
```

### Content Writing for GEO

AI engines prefer content that:
- **Answers directly** in the first 40-60 words
- **Includes statistics** every 150-200 words
- **Cites sources** (links to authoritative references)
- **Uses clear headings** (H2/H3) as topic markers
- **Has FAQ sections** matching real user questions

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
