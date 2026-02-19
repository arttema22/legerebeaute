<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'legere_beaute');

/** Database username */
define('DB_USER', 'arttema');

/** Database password */
define('DB_PASSWORD', '1234qwerQWER');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '^/XOJt0?ohp[fCMGTG|BJv+H}+d~!BQ8Up3|Cg>^a~Bd5.U5fuD=sN-6Pe#Tai|m');
define('SECURE_AUTH_KEY', 'n/9*+$xn4;EHqv}:;;er-~;$.b2eg1.mKo~/I0G5c4$d[(J2@55r5{RkC;NTponY');
define('LOGGED_IN_KEY', '_PGRSh|^N^S(2qp.:U.+f1/PzP8U==>~t^)>ctB}q6EOvQ>|A2Oq<$Blx}3mkNTH');
define('NONCE_KEY', '4%:WOCf!e.Z=EZO slQLMTW%&(1TA=8e|APP{;]XD!d/6 $ds-K2&cpy#B)zl!sD');
define('AUTH_SALT', '?bj1$FGgC@8p!60-I%BN_}|FR!/Nye2|k,s`xieF&Bvf85P|6O!P?bayF%MuO|:K');
define('SECURE_AUTH_SALT', 'P*_)V1.J,LTaq66ga+m#)fvQ?ZpOh6Z08E7/qDIe;RLY&Z_~jkqn(pFM}S}p(e38');
define('LOGGED_IN_SALT', '/-uw<pZDWRyj?F!3ZgO055qaw(0kyDo*t{(W,nT&g1J:$3`OoUxCg51(cTW/,UA/');
define('NONCE_SALT', '-{x^@7hRR<d0HBuC~VU+^Lk(Yp1<Nlv]&:c7KXI6A(t$G)Z.{h{;&2C>l~#/Ey29');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'lb_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


// Включить вывод ошибок (ТОЛЬКО для разработки!)
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false);