<?php
define('WP_CACHE', true); // Added by WP Rocket
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'undy_dev');

/** MySQL database username */
define('DB_USER', 'undy_dev');

/** MySQL database password */
define('DB_PASSWORD', '@Dev2018');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'bxzvrnr9kyf5req5akcoylpo3bmk3xfowahdgllmitwisarcot78nu8geiajozxh');
define('SECURE_AUTH_KEY',  'll08qy4v9eflce6mrkftu1jbuzmhwtq779vbzlf8s4fxll6mz9cekegl7dmzgyf4');
define('LOGGED_IN_KEY',    'nosdfgyeltptuhuxwqqaw7swlwbcgazm6mzzhe70xoyzmsu3xd2ljfq0cmkylrb2');
define('NONCE_KEY',        'w7mbk8vqnvokeu5vu8fld7qkjyl08smpkiuebkz3jobgdemmpsgqdp6xbkr9m8gc');
define('AUTH_SALT',        'zash6aofix68q7jp9gqt9t9xezghny2hvkrbzmof8decjc8n2mye3xtmdjdeq74d');
define('SECURE_AUTH_SALT', 'pwon5esqpk3k1zjpcdx2lexeuwjijg3kknm2s244l69dfo4uwliuxr3u5puthblq');
define('LOGGED_IN_SALT',   'icrwnqvioiuq7mgloduwyi6rctu8henw03ostqdqjwmvummevi6xebdoe3a4kd6e');
define('NONCE_SALT',       'uffxqr29otgwg4hzmtesert9zgbpgugdqevnkehnwdtgtewh90nxluwhflvr7ttq');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpdd_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
