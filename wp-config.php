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
define( 'FS_METHOD', 'direct' );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dbs152300');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         's(98 bvl,n*.ht7J4Ul8V 7}i]1%%JrP?B)PLp>11<zn ~@Y1I>&,O:V *sWGb0[');
define('SECURE_AUTH_KEY',  'DC{Qpel;y)GC!L#&<xvQt-j^=&M!E=OnJ@}[;w*6%N(?Ke60Fp>^ULKH -la6]~d');
define('LOGGED_IN_KEY',    '00V{UuI]U_N)3pN^.{;[ps`v&u<1:@jPPx1`F_Z6]M4SsM?,SCEKFqCxuB[#! [^');
define('NONCE_KEY',        'FSic>RNX$>mgFrlnKPyzla=jc;Qg0? yw1z`5xdR`K79m)!!;+Or6Zy>:JPWZCCo');
define('AUTH_SALT',        'Qs7U$Q$;TcLJ?R/WGb B.A_8/U^N@IHPmYk6L@:8^T(0t81j[,FY(-71?0-Q%r)?');
define('SECURE_AUTH_SALT', 'bh>br^}EiMIh:9szIOV^Sc$lE-T,/$V5w} 5SN|M9Js`CXK)t@H8a$w`;.q?]f3C');
define('LOGGED_IN_SALT',   'A3,nsXL)M0?B&?-f 2[Pe_FBVaEJnqmw*oninKde;*&A^5Q$OmbnI}8-}rCLJGx-');
define('NONCE_SALT',       '?5rMo,PyZiFZCM^2D?BEz:{c`(|Eb+8?m-6Gl=)FKe[}7S>A)TXbJvXC`sQ#v8Vg');

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
