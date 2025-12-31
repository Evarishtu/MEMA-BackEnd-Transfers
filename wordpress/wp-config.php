<?php
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress5');

/** Database username */
define('DB_USER', 'wordpress5');

/** Database password */
define('DB_PASSWORD', '2ZNG53TdCaOoLpvp');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset */
define('DB_CHARSET', 'utf8mb4');

/** Database collate type */
define('DB_COLLATE', '');

/** Table prefix */
$table_prefix = 'wp_';

/** Debug mode (ponlo en false en producción) */
define('WP_DEBUG', false);

/** Authentication keys and salts */
define('AUTH_KEY',         'pon-una-clave-unica-aqui');
define('SECURE_AUTH_KEY',  'pon-una-clave-unica-aqui');
define('LOGGED_IN_KEY',    'pon-una-clave-unica-aqui');
define('NONCE_KEY',        'pon-una-clave-unica-aqui');
define('AUTH_SALT',        'pon-una-clave-unica-aqui');
define('SECURE_AUTH_SALT', 'pon-una-clave-unica-aqui');
define('LOGGED_IN_SALT',   'pon-una-clave-unica-aqui');
define('NONCE_SALT',       'pon-una-clave-unica-aqui');

/** Absolute path to the WordPress directory */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files */
require_once ABSPATH . 'wp-settings.php';