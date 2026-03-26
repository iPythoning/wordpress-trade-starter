# 06 — Multilingual Setup (Polylang)

## Why Multilingual?

For B2B trade sites, supporting multiple languages dramatically increases your reach:
- **English** — Global default
- **Chinese (中文)** — Chinese-speaking markets
- **Russian (Русский)** — CIS countries, Africa
- **Spanish (Español)** — Latin America
- **French (Français)** — Africa, Middle East

## Install Polylang

1. Plugins → Add New → Search "Polylang" → Install & Activate
2. Follow the setup wizard

## Configure Languages

Languages → Settings:

1. Add English as the default language
2. Add additional languages (Chinese, Russian, etc.)
3. URL format: **Directory** (`/zh/`, `/ru/`) — best for SEO

### URL Structure Example

```
yourdomain.com/              → English (default)
yourdomain.com/zh/           → Chinese
yourdomain.com/ru/           → Russian
yourdomain.com/zh/products/  → Chinese product catalog
```

## Translate Content

### Pages

For each page (Home, About, Products, etc.):
1. Open the English version
2. In the Languages metabox, click "+" next to each language
3. Create the translated version
4. Polylang auto-links them

### Products

Same workflow — create the product in English, then add translations.

### Menus

1. Appearance → Menus
2. Create a menu for each language
3. Assign to the same menu location
4. Add the **Language Switcher** widget to your menu

## Language Switcher

Add to your header/menu:
1. Appearance → Menus → Add "Language Switcher" item
2. Display as: flags + language name
3. Or use a dropdown for space-saving

## SEO for Multilingual

Polylang automatically:
- Adds `hreflang` tags to link translations
- Creates separate sitemaps per language
- Sets correct `<html lang="xx">` attribute

Rank Math + Polylang work together — each translation gets its own SEO settings.

## Tips

- **Don't use machine translation alone** — have native speakers review
- Prioritize your top 2-3 markets first
- Product specs/technical data should be professionally translated
- Keep the same URL slug structure across languages for consistency

## Next Step

→ [07 — SEO Optimization](07-seo-optimization.md)
