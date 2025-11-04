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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'CuMug%G:crxPr,fnAt1s2#{0 vlEDYGenK<q]/<;qww<Dg9T9J27:lf$ dL2bF? ' );
define( 'SECURE_AUTH_KEY',  'Pm:Q.4Rq5vhrYCEA09NsiMI6;4fei45%ZI3Vn<x95(%] E6tB7lTb.@S7-P f[i{' );
define( 'LOGGED_IN_KEY',    'pW+Ps^}VxeGbJe&#3|C&!O,3vedw!PfLp}&4x7wk*3GC1BRV0nd/@wWGe>Fr=dDj' );
define( 'NONCE_KEY',        'Oz=4[J47ZVHWF@FBMSM B@v$Jzx``wO8PrTk.hA:oSK=YYhPdu7?I?Hw1_e/+~?:' );
define( 'AUTH_SALT',        'O|>zT7*g5e{;@gYyO:YSb5c2W5)8>T$UqC:qY*^XXS+uwYx{#wDRAdx&6kdY{,};' );
define( 'SECURE_AUTH_SALT', ',B?nO&]*%.T6`w`GSF<Ff^3(q;{&{;vLDHM|/8$K%Fi^/KEew{+o8;yt$R*#[iP,' );
define( 'LOGGED_IN_SALT',   'wYa0/a y>SP.R%M4O8(sX;~Ae{$k80;TUk+Q7j6acmHzh*rzUsR8],.6==>4bVB8' );
define( 'NONCE_SALT',       '~wQ7.TM7rWSI/!)lb<-[Jr_X3*HSz<`]a#=%dNqB/3ci5RCO$v`Cr5W,#f7yeaH.' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
