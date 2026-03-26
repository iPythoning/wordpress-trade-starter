# 05 — Theme & Plugins

## Theme: Astra + Child Theme

[Astra](https://wpastra.com/) is the best free theme for trade sites:
- Lightweight (~50KB frontend)
- Fully compatible with Elementor
- Responsive out of the box

### Install

1. Appearance → Themes → Add New → Search "Astra" → Install & Activate
2. Create a child theme for customizations:

```bash
docker compose exec wordpress bash -c '
mkdir -p /var/www/html/wp-content/themes/astra-child
cat > /var/www/html/wp-content/themes/astra-child/style.css << "CHILD"
/*
Theme Name: Astra Child
Template: astra
Version: 1.0.0
*/
CHILD
cat > /var/www/html/wp-content/themes/astra-child/functions.php << "FUNC"
<?php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("parent-style", get_template_directory_uri() . "/style.css");
});
FUNC
'
```

3. Activate the child theme in Appearance → Themes

## Must-Have Plugins

Install all from Plugins → Add New:

### 1. Elementor (Page Builder)

Visual drag-and-drop editor. Use the free version — it covers 90% of needs.

### 2. Rank Math (SEO)

- Run the setup wizard after activation
- Set your business type, social profiles, sitemap options
- See [07-seo-optimization.md](07-seo-optimization.md)

### 3. WP Super Cache (Performance)

- Settings → WP Super Cache → Enable caching
- Expert tab: enable mod_rewrite mode
- See [08-performance.md](08-performance.md)

### 4. Imagify (Image Optimization)

- Sign up at imagify.io for a free API key (20MB/month free)
- Settings → Imagify → Enter API key
- Recommended config:

```json
{
    "auto_optimize": true,
    "backup": true,
    "lossless": true,
    "optimization_format": "webp",
    "resize_larger": true,
    "resize_larger_w": 2560
}
```

### 5. Jetpack Boost (Critical CSS + Lazy Load)

Enable all modules:
- Critical CSS generation
- Lazy image loading
- Concatenate JS/CSS

### 6. Polylang (Multilingual)

See [06-multilingual.md](06-multilingual.md)

### 7. Contact Form 7

Create a contact form with: Name, Email, Phone, Country, Message, Product Interest.

### 8. Chaty (Chat Widget)

Add a floating WhatsApp/Email button. Configure your WhatsApp business number.

### 9. eCommerce Product Catalog

Lightweight product showcase without WooCommerce overhead. Good for B2B catalog-style sites.

## Plugin Performance Note

Only install plugins you actually use. Each plugin adds overhead. The 9 plugins above are carefully selected to balance functionality and performance.

## Next Step

→ [06 — Multilingual](06-multilingual.md)
