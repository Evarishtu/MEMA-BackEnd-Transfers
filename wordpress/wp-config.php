<?php
/**
 * The base configuration for WordPress
 *
 * This file has been adapted for Docker-based local development.
 */

if (!function_exists('getenv_docker')) {
    function getenv_docker($env, $default) {
        if ($fileEnv = getenv($env . '_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        } elseif (($val = getenv($env)) !== false) {
            return $val;
        } else {
            return $default;
        }
    }
}

/** ===============================
 * Database settings
 * =============================== */

define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'mema_wordpress_p4') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wpuser') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wppassword') );
define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'database-wordpress-producto4') );

define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/** ===============================
 * Authentication keys and salts
 * =============================== */

define( 'AUTH_KEY',         '7a4f72968bf1dda6e72402d111533f24506f0d09' );
define( 'SECURE_AUTH_KEY',  'e27328bb3cf5b34182b1758a172add55b4530030' );
define( 'LOGGED_IN_KEY',    '4eb2b0928deb7b018a4505913130e08a443d6ae7' );
define( 'NONCE_KEY',        '7bfd5afc94a5090032c90cbe0e5329159ebf605a' );
define( 'AUTH_SALT',        '60156e54fa0e8a07ed54e262b1c57a2084527f8e' );
define( 'SECURE_AUTH_SALT', 'c9058a4a2bb499e15f8e6fde2457e0865c52d649' );
define( 'LOGGED_IN_SALT',   'be4a0fd34e662362e7889b6c34a655d00a10dd77' );
define( 'NONCE_SALT',       'ce0a237336436f61992bdc3b13b87cea12f585e1' );

/** ===============================
 * Table prefix
 * =============================== */

$table_prefix = 'wp_';

/** ===============================
 * Debug
 * =============================== */

define( 'WP_DEBUG', false );

/** ===============================
 * Reverse proxy / HTTPS support
 * =============================== */

if (
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false
) {
    $_SERVER['HTTPS'] = 'on';
}

/** ===============================
 * Absolute path & bootstrap
 * =============================== */

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';