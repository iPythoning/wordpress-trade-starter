<?php
/**
 * WordPress Extra Configuration for Trade Sites
 *
 * Add these lines to wp-config.php (before "That's all, stop editing!")
 * or use WORDPRESS_CONFIG_EXTRA in docker-compose.yml
 */

// --- Memory ---
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// --- Cache ---
define('WP_CACHE', true);
define('WPCACHEHOME', '/var/www/html/wp-content/plugins/wp-super-cache/');

// --- Security ---
define('DISALLOW_FILE_EDIT', true);       // Disable theme/plugin editor
define('FORCE_SSL_ADMIN', true);          // Force HTTPS for admin

// --- Performance ---
define('WP_POST_REVISIONS', 5);           // Limit post revisions
define('AUTOSAVE_INTERVAL', 120);         // Autosave every 2 minutes
define('EMPTY_TRASH_DAYS', 7);            // Auto-empty trash after 7 days

// --- Behind reverse proxy (Nginx/Cloudflare) ---
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
