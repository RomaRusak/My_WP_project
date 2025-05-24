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
define( 'DB_NAME', 'best_blog' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '9302' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'klj]F39qDGL$49{|m5amNYiIM4g9#]zXFFl>>F=I1=%kF6.,J6Eu[dBUY}9+7)FP' );
define( 'SECURE_AUTH_KEY',  'Mn 7K}_lRW8>$I}oLZ<W:j8XFNJ2iJTZwE}aR~%-DJ.fh@HhgCnLeZLRPs-F2Xp)' );
define( 'LOGGED_IN_KEY',    '6/^%u}zGP?HYx>gdp-?P% CT<K3F9X&;<Eu_0!?#!e+!KY4a#aKRt/#=.hE/G(ri' );
define( 'NONCE_KEY',        'V>9y@V{~[ix$R-G|d2dD1]B?@2]p()/G0ay+exfno}xNyR:5%Ivif4(,i)!g*bv!' );
define( 'AUTH_SALT',        'h7{J9.d&.D1;YLvXU^CkW$APkldQcbVc_do*sefc@Z[*wctQYGV@)0_J;zghs,9/' );
define( 'SECURE_AUTH_SALT', 'N_<$eI:u}1D2u>xv:+lr%8wM22`%OUk7&% GlP-=~y/x sZnGP10B-ko6wk[ZNOn' );
define( 'LOGGED_IN_SALT',   'YArI{g,vcU=ke%@tKsH2s?FDcM=11uS,R04H0w/~<E$(Nm<gq%:!#.=D~xM8P<BJ' );
define( 'NONCE_SALT',       '?5hvHe=^RG,<^Tt*y9<S8~agNtgBu-CBq}#~d`;v`rsX_Ge=4yns_I*ha9I1>DgS' );

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
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
