<?php
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
set_time_limit(0);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'job');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'iIjo&a7]@IrAO@Z!^&yyKu&>l32o2EOwA:;=aiB] e#0+<>zZVnAF?_-aB/m^:EJ');
define('SECURE_AUTH_KEY',  'kU.baM,feUBSc=;J0@P|UNy^s>xA_0~]Hk8%`4-A$4jQ<Rg4uJ/NxGf6{?4PZEko');
define('LOGGED_IN_KEY',    'kNVsZU IwjV4M/jW_;cdGo$*I;^7;Px)j52k%*Q1HU<pXf&(-[m0lHMqf#~R}V=a');
define('NONCE_KEY',        'sYTpnR^BUa9MDsTO+(0aX<>Vu.<E:}W2l{<}!Qc;y]*I2yce;)bd1NmqnCM`d:VW');
define('AUTH_SALT',        '6L5{w_C#Xn41Q1iYC9j WDq$Wp%o^_e[kkM7;GHnBnJS%/S2=3Oe3E$l`X )=G=f');
define('SECURE_AUTH_SALT', 'f`{?~^6~ >P+.im>N_2S*-&Yhf7&,S&HC_aQ*z(>16ldpEg^Zrsp(;>wdWzND8[n');
define('LOGGED_IN_SALT',   'UkC|Rhc|TluX$DcS?i?]+MgBH$Ig~ o{O%*]z|/`TRSTONT~>rD7F%g-^G(^Iu&[');
define('NONCE_SALT',       '6zi$$.6d.P{W[@63R)Q OrJ%E6,I8y1FB.@VBX%]dH:PA(x8nn;r{<>?~lwC^S_5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
