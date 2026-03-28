# 12 — GEO: Generative Engine Optimization

GEO optimizes your site for AI search engines — Google AI Overviews, ChatGPT Search, Perplexity, Claude Web, Gemini, and Bing Copilot.

Traditional SEO gets you ranked in search results. **GEO gets you cited by AI.**

## Why GEO Matters

- AI answers now appear above traditional search results
- 79% of AI-generated responses include citations from web sources
- Brand mentions correlate with AI visibility **3x more** than backlinks (Ahrefs, 2025)
- Only **11% of domains** get cited by both ChatGPT and Google AI Overviews for the same query

## Setup

### 1. Include GEO Functions

Copy `assets/geo-functions.php` to your child theme and include it:

```php
// In functions.php
define('GEO_SAMEAS', [
    'https://en.wikipedia.org/wiki/Your_Company',  // highest priority
    'https://www.wikidata.org/wiki/Q12345',         // machine-readable entity ID
    'https://www.linkedin.com/company/yourcompany',
    'https://www.youtube.com/@yourcompany',
    'https://twitter.com/yourcompany',
    'https://github.com/yourcompany',               // for tech companies
]);
define('GEO_LANGUAGES', ['en', 'zh']);
define('GEO_CONTACT_EMAIL', 'info@example.com');
define('GEO_CONTACT_PHONE', '+86-xxx-xxxx-xxxx');

require_once get_stylesheet_directory() . '/geo-functions.php';
```

This auto-enables:
- Triple JSON-LD schema (Organization + WebSite + Article + BreadcrumbList)
- Speakable markup for voice assistants
- AI-friendly robots.txt with tiered bot management
- Auto-generated `/llms.txt`
- AI bot tracking headers
- First-paragraph marking for quick-answer extraction

### 2. Verify

```bash
# robots.txt — should show tiered AI bots
curl https://yourdomain.com/robots.txt

# llms.txt — auto-generated from site content
curl https://yourdomain.com/llms.txt

# Schema — check JSON-LD in page source
curl -s https://yourdomain.com/ | grep 'application/ld+json'
```

## AI Crawler Tiers

| Tier | Bot | Service | Action | Why |
|------|-----|---------|--------|-----|
| 1 | GPTBot | ChatGPT | **ALLOW** | Blocking = invisible to ChatGPT |
| 1 | OAI-SearchBot | ChatGPT Search | **ALLOW** | Search-only, no training |
| 1 | ChatGPT-User | ChatGPT browsing | **ALLOW** | User-initiated requests |
| 1 | ClaudeBot | Claude | **ALLOW** | Blocking = invisible to Claude |
| 1 | anthropic-ai | Anthropic | **ALLOW** | Claude ecosystem |
| 1 | PerplexityBot | Perplexity | **ALLOW** | Best referral traffic source |
| 2 | Google-Extended | Gemini training | **ALLOW** | Does NOT affect Google Search ranking |
| 2 | Applebot-Extended | Siri / Apple Intelligence | **ALLOW** | Apple ecosystem |
| 2 | cohere-ai | Cohere models | **ALLOW** | Enterprise AI |
| 2 | CCBot | Common Crawl | **ALLOW** | Open training data |
| 3 | Bytespider | TikTok/ByteDance | **BLOCK** | Aggressive crawler, low value, high resource cost |

## Writing for AI Citability

Research from Princeton/Georgia Tech/IIT Delhi (2024) shows optimized content gets **30-115% higher** AI visibility.

### The Citability Formula

**Best paragraph length: 134-167 words.** This is the sweet spot for AI citation extraction.

### 5 Rules for Citable Content

#### 1. Answer First (30% of citability score)

Bad:
> In the dynamic landscape of international trade, many factors influence the choice of payment method. After careful consideration of various options...

Good:
> **T/T (Telegraphic Transfer) is the most common payment method for B2B trade**, used in over 70% of international transactions. It offers low fees (typically 0.1-0.5%), fast processing (1-3 business days), and works with any bank worldwide.

**Pattern:** First sentence = complete answer. Following sentences = supporting evidence.

#### 2. Self-Contained Paragraphs (25%)

Each paragraph should be understandable without reading the rest of the article. AI engines extract individual paragraphs as citations — if yours requires context from a previous paragraph, it won't be selected.

#### 3. Structured Content (20%)

Use tables for comparisons, lists for features, and clear H2/H3 headings. AI engines strongly prefer structured content over prose paragraphs.

| Format | AI Preference | When to Use |
|--------|--------------|-------------|
| Tables | Highest | Comparisons, specs, pricing |
| Numbered lists | High | Step-by-step, rankings |
| Bullet lists | High | Features, requirements |
| Short paragraphs | Medium | Explanations, context |
| Long paragraphs | Low | Avoid — break into 2-4 sentences |

#### 4. Statistical Density (15%)

Include specific numbers, percentages, prices, and measurements. AI engines prioritize content with concrete data over vague claims.

Bad: "Our trailers are very affordable and ship quickly."
Good: "Flatbed semi-trailers start at $8,500 FOB Qingdao, with 15-25 day lead time and 1-unit MOQ."

#### 5. Unique Data (10%)

Original research, proprietary data, first-hand experience, and expert insights score highest. AI engines de-prioritize generic content that exists on thousands of sites.

## sameAs: The Entity Signal

The `sameAs` property in your Organization schema is the **#1 signal for AI entity recognition**. It tells AI engines "this is the same entity as the one on Wikipedia/LinkedIn/etc."

Priority order:
1. **Wikipedia** — highest authority for entity recognition
2. **Wikidata** — machine-readable entity ID (Q-number)
3. **LinkedIn** — B2B authority signal
4. **YouTube** — AI training data heavily sourced from YouTube transcripts
5. **Twitter/X** — real-time authority signal
6. **Crunchbase** — for tech/startup companies
7. **GitHub** — for developer products
8. **Industry directories** — trade-specific platforms (Alibaba, Made-in-China, etc.)

If your company doesn't have a Wikipedia page, prioritize LinkedIn and YouTube presence — they are the strongest alternative signals.

## Platform-Specific Tips

### Google AI Overviews
- Must rank in top 10 organic results first
- Q&A format content is strongly preferred
- Tables and lists get extracted most often

### ChatGPT Search
- Uses Bing index, not Google — optimize for Bing Webmaster Tools
- Wikipedia presence dramatically increases citation probability
- Entity Graph matters more than PageRank

### Perplexity
- Has its own crawler (PerplexityBot) — must be allowed
- Strongly favors Reddit mentions and discussions
- Original research and fresh content prioritized

### Gemini
- YouTube presence is the #1 signal (Google ecosystem)
- Google Knowledge Panel helps significantly
- Schema.org markup weighted heavily

### Bing Copilot
- Submit to IndexNow for faster indexing
- LinkedIn presence matters (Microsoft ecosystem)
- Bing Webmaster Tools verification recommended

## llms.txt

`llms.txt` is an emerging standard (proposed by Jeremy Howard, 2024) that helps AI engines understand your site's structure. Think of it as `robots.txt` but for telling AI **what's most important**, not what to avoid.

The GEO functions auto-generate `/llms.txt` from your WordPress content. To customize, you can create a static `llms.txt` file in your web root instead.

## Cloudflare Warning

Cloudflare's "Managed robots.txt" feature (Security → Bots) **automatically blocks AI crawlers**. You must disable this for GEO to work.

See [09-cloudflare.md](09-cloudflare.md) for details.

## Next Step

→ [Back to README](../README.md)
