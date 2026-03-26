# 04 — WordPress Setup

## Initial Configuration

Open `https://yourdomain.com` and complete the 5-minute setup wizard:

1. **Language**: English (you'll add more languages later with Polylang)
2. **Site Title**: Your Company Name
3. **Username**: Choose a non-obvious admin username (not "admin")
4. **Password**: Use a strong password
5. **Email**: Your business email

## Essential Settings

### Settings → General

- **Site Title**: Your Company Name
- **Tagline**: One-line description (e.g., "Leading Semi-Trailer Manufacturer in China")
- **WordPress Address / Site Address**: `https://yourdomain.com`
- **Timezone**: Your target market timezone

### Settings → Permalinks

Select **Post name**: `/%postname%/`

This gives you clean, SEO-friendly URLs like `yourdomain.com/product-name/`.

### Settings → Reading

- **Homepage displays**: A static page
- Create a "Home" page and a "Blog" page first, then set them here

### Settings → Discussion

- Uncheck "Allow people to submit comments on new posts" (unless you need blog comments)
- This reduces spam and improves security

## wp-config.php Additions

Add the snippets from `wp-config-extra.php` to your `wp-config.php`:

```bash
docker compose exec wordpress bash
nano /var/www/html/wp-config.php
```

Or set them via `WORDPRESS_CONFIG_EXTRA` in `docker-compose.yml` (already included in our template).

Key settings:
- `WP_MEMORY_LIMIT` = 256M
- `DISALLOW_FILE_EDIT` = true (security)
- `FORCE_SSL_ADMIN` = true
- `WP_POST_REVISIONS` = 5

## Create Core Pages

For a trade/manufacturing site, create these pages:

1. **Home** — Hero banner, key products, company highlights
2. **About** — Company story, factory photos, certifications
3. **Products** — Product catalog
4. **Cases / Projects** — Customer success stories
5. **Blog / News** — Industry articles for SEO
6. **Contact** — Contact form, office address, map
7. **FAQ** — Common buyer questions
8. **Privacy Policy** / **Terms of Service** — Legal pages

## Next Step

→ [05 — Theme & Plugins](05-theme-plugins.md)
