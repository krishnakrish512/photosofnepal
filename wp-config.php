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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'photosofnepal' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', 'u^.P4KVA&^X/dpYZ[<q=oc]U7;QAU(T|pj<O{=CBInrJf(>q^ZE9ItJSO_Z?uHoK' );
define( 'SECURE_AUTH_KEY', '<Q+U2uQ%flqpaUj<#m6td$.jzuP/uI8!A%*g=DKrqjV-Wx7M;|~h%fbcD&=xvHEy' );
define( 'LOGGED_IN_KEY', ':M1h@MbsdurLb*gNnc3;Gru`*:DT#]27N407S&|j2[7ec(=)yG%(P-1R8f%T-xG9' );
define( 'NONCE_KEY', '*!`FU/cXc=K1hF~x?lD2)h&T.=^BRj}`y7trUo[(,O#F:SCS[!4;ndx^nxmBA<IU' );
define( 'AUTH_SALT', '/:11$GJU=v%s&T7qUAU|PYtI<K3[S8pmM=#F8x*m5r|D^ 9o,tIt?]!A8P$Q1`+2' );
define( 'SECURE_AUTH_SALT', ' i%bx9skG,~t}pz>JS$_X Z7*M:jY#Z.T)<+iLz0Th(L%.qKL9ytYF=ykkHfba@f' );
define( 'LOGGED_IN_SALT', '01EeQiCS)NI,?~R^gE[>i @s(zq#@gG&;1i)X4GWkW#N-oh(g>bvY~($[V--*N/7' );
define( 'NONCE_SALT', '>w,cdd=4[)P!)V|9aP.?<#O*/`VpP/lf:L`$#=[zv)_#1cG7`S|#!Nc)UvoPp(kY' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pn_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_POST_REVISIONS', 3 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
