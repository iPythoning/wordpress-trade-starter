<?php
/**
 * GEO (Generative Engine Optimization) Functions
 *
 * Add this to your child theme's functions.php to optimize for AI search engines:
 * Google AI Overviews, Perplexity, ChatGPT Search, Claude Web, Bing Copilot.
 *
 * Usage: Copy the functions below into your child theme's functions.php,
 * or include this file: require_once get_stylesheet_directory() . '/geo-functions.php';
 */

// =============================================================
// GEO 1: Triple JSON-LD Schema Stacking
// Organization + WebSite (homepage) + Article + Speakable (posts)
// + BreadcrumbList (non-homepage)
// =============================================================
add_action('wp_head', function () {
    $site_name = get_bloginfo('name');
    $site_url  = home_url('/');
    $site_desc = get_bloginfo('description');
    $schemas   = [];

    // Organization — E-E-A-T authority signal
    $schemas[] = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        '@id'         => $site_url . '#organization',
        'name'        => $site_name,
        'url'         => $site_url,
        'description' => $site_desc,
        // Customize these for your business:
        'knowsAbout'  => [
            'International Trade',
            'Manufacturing',
            'Product Export',
            'B2B Commerce',
        ],
        'areaServed'  => [
            ['@type' => 'Country', 'name' => 'China'],
            ['@type' => 'Country', 'name' => 'United States'],
            ['@type' => 'Country', 'name' => 'Global'],
        ],
    ];

    // WebSite + SearchAction (homepage only)
    if (is_front_page()) {
        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => $site_url . '#website',
            'name'            => $site_name,
            'url'             => $site_url,
            'description'     => $site_desc,
            'publisher'       => ['@id' => $site_url . '#organization'],
            'inLanguage'      => apply_filters('geo_site_languages', ['en']),
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

    // Article + Speakable (single posts)
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
            // Speakable: AI voice assistants extract these sections
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

        $schemas[] = $article;
    }

    // BreadcrumbList (non-homepage)
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
// Explicitly Allow AI search engine crawlers
// =============================================================
add_filter('robots_txt', function ($output, $public) {
    $sitemap_url = home_url('/sitemap_index.xml');

    $r  = "# === Standard Crawlers ===\n";
    $r .= "User-agent: *\nAllow: /\n";
    $r .= "Disallow: /wp-admin/\nDisallow: /wp-includes/\n";
    $r .= "Disallow: /wp-content/plugins/\nDisallow: /wp-content/cache/\n";
    $r .= "Disallow: /*?s=\nDisallow: /*?p=\n\n";

    // GEO: Explicitly allow AI crawlers
    $ai_bots = [
        'GPTBot', 'ChatGPT-User', 'Google-Extended',
        'PerplexityBot', 'ClaudeBot', 'anthropic-ai',
        'Bytespider', 'cohere-ai', 'CCBot',
    ];
    $r .= "# === AI Search Engine Bots (GEO) ===\n";
    foreach ($ai_bots as $bot) {
        $r .= "User-agent: {$bot}\nAllow: /\n\n";
    }

    $r .= "# === Rate-limit SEO bots ===\n";
    $r .= "User-agent: AhrefsBot\nCrawl-delay: 10\n\n";
    $r .= "User-agent: SemrushBot\nCrawl-delay: 10\n\n";

    $r .= "# Sitemaps\nSitemap: {$sitemap_url}\n";
    return $r;
}, 10, 2);

// =============================================================
// GEO 3: AI summary meta tags
// Helps AI engines extract key information
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
// Tag AI bot requests for analytics (GA4 custom segments)
// =============================================================
add_action('send_headers', function () {
    $ua      = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ai_bots = ['GPTBot', 'ChatGPT-User', 'PerplexityBot', 'ClaudeBot', 'Claude-Web', 'Google-Extended', 'Bytespider', 'cohere-ai', 'anthropic-ai'];
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
