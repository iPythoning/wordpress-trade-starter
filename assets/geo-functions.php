<?php
/**
 * GEO (Generative Engine Optimization) Functions
 *
 * Optimize for AI search engines: Google AI Overviews, ChatGPT Search,
 * Perplexity, Claude Web, Gemini, Bing Copilot.
 *
 * Usage: require_once get_stylesheet_directory() . '/geo-functions.php';
 *
 * Configuration: Define these constants in wp-config.php or functions.php
 * before including this file:
 *
 *   define('GEO_SAMEAS', [
 *       'https://en.wikipedia.org/wiki/Your_Company',
 *       'https://www.wikidata.org/wiki/Q12345',
 *       'https://www.linkedin.com/company/yourcompany',
 *       'https://www.youtube.com/@yourcompany',
 *       'https://twitter.com/yourcompany',
 *   ]);
 *   define('GEO_LANGUAGES', ['en', 'zh']);
 *   define('GEO_CONTACT_EMAIL', 'info@example.com');
 *   define('GEO_CONTACT_PHONE', '+86-xxx-xxxx-xxxx');
 */

// =============================================================
// GEO 1: Triple JSON-LD Schema Stacking
// Organization (with sameAs) + WebSite + Article + Speakable + BreadcrumbList
// =============================================================
add_action('wp_head', function () {
    $site_name = get_bloginfo('name');
    $site_url  = home_url('/');
    $site_desc = get_bloginfo('description');
    $schemas   = [];

    // --- Organization schema (every page) ---
    $org = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        '@id'         => $site_url . '#organization',
        'name'        => $site_name,
        'url'         => $site_url,
        'description' => $site_desc,
        // Customize for your business:
        'knowsAbout'  => apply_filters('geo_knows_about', [
            'International Trade',
            'Manufacturing',
            'Product Export',
            'B2B Commerce',
        ]),
        'areaServed'  => apply_filters('geo_area_served', [
            ['@type' => 'Country', 'name' => 'China'],
            ['@type' => 'Country', 'name' => 'United States'],
            ['@type' => 'Country', 'name' => 'Global'],
        ]),
    ];

    // sameAs — critical for AI entity recognition (Wikipedia > Wikidata > LinkedIn > YouTube)
    if (defined('GEO_SAMEAS') && is_array(GEO_SAMEAS)) {
        $org['sameAs'] = GEO_SAMEAS;
    }

    // Contact
    if (defined('GEO_CONTACT_EMAIL')) {
        $org['email'] = GEO_CONTACT_EMAIL;
    }
    if (defined('GEO_CONTACT_PHONE')) {
        $org['telephone'] = GEO_CONTACT_PHONE;
    }

    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
        $org['logo'] = wp_get_attachment_url($logo_id);
    }

    $schemas[] = $org;

    // --- WebSite + SearchAction (homepage only) ---
    if (is_front_page()) {
        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => $site_url . '#website',
            'name'            => $site_name,
            'url'             => $site_url,
            'description'     => $site_desc,
            'publisher'       => ['@id' => $site_url . '#organization'],
            'inLanguage'      => defined('GEO_LANGUAGES') ? GEO_LANGUAGES : apply_filters('geo_site_languages', ['en']),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => $site_url . '?s={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    // --- Article + Speakable (single posts) ---
    if (is_single()) {
        global $post;
        $article = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            '@id'              => get_permalink() . '#article',
            'headline'         => get_the_title(),
            'description'      => wp_trim_words(get_the_excerpt(), 30, '...'),
            'url'              => get_permalink(),
            'datePublished'    => get_the_date('c'),
            'dateModified'     => get_the_modified_date('c'),
            'author'           => [
                '@type' => 'Person',
                'name'  => get_the_author(),
                'url'   => get_author_posts_url(get_the_author_meta('ID')),
            ],
            'publisher'        => ['@id' => $site_url . '#organization'],
            'isPartOf'         => ['@id' => $site_url . '#website'],
            'mainEntityOfPage' => get_permalink(),
            'wordCount'        => str_word_count(strip_tags($post->post_content)),
            'speakable'        => [
                '@type'       => 'SpeakableSpecification',
                'cssSelector' => [
                    '.entry-content p:nth-of-type(1)',
                    '.entry-content p:nth-of-type(2)',
                ],
            ],
        ];

        $cats = get_the_category();
        if ($cats) {
            $article['about'] = [];
            foreach (array_slice($cats, 0, 3) as $cat) {
                $article['about'][] = [
                    '@type' => 'Thing',
                    'name'  => $cat->name,
                    'url'   => get_category_link($cat->term_id),
                ];
            }
        }

        $thumb = get_the_post_thumbnail_url($post, 'full');
        if ($thumb) {
            $article['image'] = $thumb;
        }

        $schemas[] = $article;
    }

    // --- BreadcrumbList (non-homepage) ---
    if (!is_front_page()) {
        $items = [];
        $pos   = 1;
        $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => 'Home', 'item' => $site_url];

        if (is_single()) {
            $cats = get_the_category();
            if ($cats) {
                $cat = $cats[0];
                if ($cat->parent) {
                    $parent  = get_category($cat->parent);
                    $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $parent->name, 'item' => get_category_link($parent->term_id)];
                }
                $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $cat->name, 'item' => get_category_link($cat->term_id)];
            }
            $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title()];
        } elseif (is_category()) {
            $cat = get_queried_object();
            if ($cat->parent) {
                $parent  = get_category($cat->parent);
                $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $parent->name, 'item' => get_category_link($parent->term_id)];
            }
            $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $cat->name];
        } elseif (is_page()) {
            $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title()];
        }

        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">'
            . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            . "</script>\n";
    }
}, 5);

// =============================================================
// GEO 2: AI-friendly robots.txt
// Allow AI search crawlers, block aggressive/training-only bots
// Based on: https://github.com/zubair-trabzada/geo-seo-claude
// =============================================================
add_filter('robots_txt', function ($output, $public) {
    $site_url    = home_url('/');
    $sitemap_url = home_url('/sitemap_index.xml');

    $r  = "# === Standard Crawlers ===\n";
    $r .= "User-agent: *\nAllow: /\n";
    $r .= "Disallow: /wp-admin/\nDisallow: /wp-includes/\n";
    $r .= "Disallow: /wp-content/plugins/\nDisallow: /wp-content/cache/\n";
    $r .= "Disallow: /*?s=\nDisallow: /*?p=\n\n";

    // Tier 1: AI Search — MUST allow (blocking = invisible to AI search)
    $tier1 = [
        'GPTBot'           => 'ChatGPT (content + search)',
        'OAI-SearchBot'    => 'ChatGPT Search (search only, no training)',
        'ChatGPT-User'     => 'ChatGPT user-initiated browsing',
        'ClaudeBot'        => 'Claude web search',
        'anthropic-ai'     => 'Anthropic AI crawler',
        'PerplexityBot'    => 'Perplexity AI search',
    ];

    // Tier 2: AI Platform — recommended allow
    $tier2 = [
        'Google-Extended'   => 'Gemini training (does NOT affect Google Search ranking)',
        'Applebot-Extended' => 'Apple Intelligence / Siri',
        'cohere-ai'        => 'Cohere AI models',
        'CCBot'             => 'Common Crawl (open AI training data)',
    ];

    $r .= "# === Tier 1: AI Search Bots (ALLOW — blocking = invisible) ===\n";
    foreach ($tier1 as $bot => $desc) {
        $r .= "User-agent: {$bot}\nAllow: /\nAllow: /llms.txt\n# {$desc}\n\n";
    }

    $r .= "# === Tier 2: AI Platform Bots (recommended ALLOW) ===\n";
    foreach ($tier2 as $bot => $desc) {
        $r .= "User-agent: {$bot}\nAllow: /\nAllow: /llms.txt\n# {$desc}\n\n";
    }

    // ByteDance / TikTok — allow (valuable for Chinese & international trade sites)
    $r .= "# === ByteDance / TikTok ===\n";
    $r .= "User-agent: Bytespider\nAllow: /\nAllow: /llms.txt\n# TikTok/Douyin/Toutiao ecosystem\n\n";

    // Rate-limit SEO bots
    $r .= "# === Rate-limit SEO bots ===\n";
    $r .= "User-agent: AhrefsBot\nCrawl-delay: 10\n\n";
    $r .= "User-agent: SemrushBot\nCrawl-delay: 10\n\n";

    $r .= "# Sitemaps\nSitemap: {$sitemap_url}\n";
    return $r;
}, 10, 2);

// =============================================================
// GEO 3: AI summary meta tags
// =============================================================
add_action('wp_head', function () {
    if (is_single() || is_page()) {
        global $post;
        $summary = wp_trim_words(strip_tags($post->post_content), 40, '...');
        echo '<meta name="summary" content="' . esc_attr($summary) . "\" />\n";
    }
}, 4);

// =============================================================
// GEO 4: AI bot tracking via HTTP header
// =============================================================
add_action('send_headers', function () {
    $ua      = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ai_bots = ['GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'PerplexityBot', 'ClaudeBot', 'Claude-Web', 'Google-Extended', 'anthropic-ai', 'cohere-ai', 'Applebot-Extended'];
    foreach ($ai_bots as $bot) {
        if (stripos($ua, $bot) !== false) {
            header("X-AI-Bot: {$bot}");
            break;
        }
    }
});

// =============================================================
// GEO 5: Mark first paragraph for AI quick-answer extraction
// =============================================================
add_filter('the_content', function ($content) {
    if (!is_single() && !is_page()) {
        return $content;
    }
    return preg_replace(
        '/<p>(.+?)<\/p>/',
        '<p data-ai-summary="true">$1</p>',
        $content,
        1
    );
}, 20);

// =============================================================
// GEO 6: Auto-serve /llms.txt
// Generates structured Markdown from site metadata for AI engines.
// =============================================================
add_action('init', function () {
    if (!isset($_SERVER['REQUEST_URI']) || parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) !== '/llms.txt') {
        return;
    }

    $name = get_bloginfo('name');
    $desc = get_bloginfo('description');
    $url  = home_url('/');

    $out  = "# {$name}\n\n";
    $out .= "> {$desc}\n\n";

    // Pages
    $pages = get_pages(['sort_column' => 'menu_order', 'post_status' => 'publish', 'number' => 20]);
    if ($pages) {
        $out .= "## Pages\n\n";
        foreach ($pages as $p) {
            $link    = get_permalink($p);
            $excerpt = wp_trim_words(strip_tags($p->post_content), 15, '...');
            $out .= "- [{$p->post_title}]({$link}): {$excerpt}\n";
        }
        $out .= "\n";
    }

    // Categories
    $cats = get_categories(['hide_empty' => false, 'exclude' => [1], 'parent' => 0]);
    if ($cats) {
        $out .= "## Categories\n\n";
        foreach ($cats as $cat) {
            $link = get_category_link($cat->term_id);
            $out .= "- [{$cat->name}]({$link}): {$cat->description}\n";
        }
        $out .= "\n";
    }

    // Recent posts (latest 10)
    $posts = get_posts(['numberposts' => 10, 'post_status' => 'publish']);
    if ($posts) {
        $out .= "## Recent Articles\n\n";
        foreach ($posts as $p) {
            $link    = get_permalink($p);
            $excerpt = wp_trim_words(strip_tags($p->post_content), 15, '...');
            $out .= "- [{$p->post_title}]({$link}): {$excerpt}\n";
        }
        $out .= "\n";
    }

    // Contact
    $out .= "## Contact\n\n";
    $out .= "- Website: {$url}\n";
    if (defined('GEO_CONTACT_EMAIL')) {
        $out .= "- Email: " . GEO_CONTACT_EMAIL . "\n";
    }
    if (defined('GEO_CONTACT_PHONE')) {
        $out .= "- Phone: " . GEO_CONTACT_PHONE . "\n";
    }

    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: public, max-age=86400');
    header('X-Robots-Tag: noindex');
    echo $out;
    exit;
});
