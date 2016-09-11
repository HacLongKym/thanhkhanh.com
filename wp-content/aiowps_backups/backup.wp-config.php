<?php
/** Enable W3 Total Cache Edge Mode */
define('W3TC_EDGE_MODE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'wp_banhang');

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
define('AUTH_KEY',         'e4.Hy|Mv}osxNcY^da~4v7+[E}z!d!UAfqc=LR>xu,D/3?Slf)GnB_)/&Wl3bDB-');
define('SECURE_AUTH_KEY',  ' O1O>!&ErO?NKCw!Nb* Q{tlm[01 @xA[ ],#KVZg ]Bq=L#$w#<|qVaQuvrzpI!');
define('LOGGED_IN_KEY',    'ch|lf/iqc|es8r8ltR[@[.y4Vdh^>luwrb]svtLkzd@>(Ge$47]|p)^ 7&nn.b<N');
define('NONCE_KEY',        'RJ])[ tyubZC9` CRz9(e+m1^_,|K&{dlw#h(*~&FVDg>n8n!vecO/B54m?y,BYV');
define('AUTH_SALT',        'sct8h `|aUps9FT.~:6aiNntn6A%&NmQB}b0%>-ADKlzApEpCXw()n#~.~M*~HdK');
define('SECURE_AUTH_SALT', ':2Hn=FC21mBP(%7Pn%2@uOWvr@f4Ktn ;-[^cM 1Cte3P*8Lr4`/w-x>Cunb ,?6');
define('LOGGED_IN_SALT',   '=(QbKOw<C4T6D}UxVfJxOQ3iE]|imA,%G,Ex,Dg)=6d}cy,/)0^?OMiz/cWa%eix');
define('NONCE_SALT',       'b>JRHt,`r[%YHhH._0</)yQVA>@t]@Hg.,b&1wPX4]c_cjs32yvC[v6BW)Wp?e0r');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'xpqph_';

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
