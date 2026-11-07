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
define( 'DB_NAME', 'wp-anishop' );

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
define( 'AUTH_KEY',         'Gc-ff+%t-rG<Re*{7#~^bTyCrW+sNGQ}~n&j-@L]@Gt]`<kqTGD:?YjJS/<8%wNI' );
define( 'SECURE_AUTH_KEY',  'g+**.yXM`LZRzn-{Q<Pe*o]DuI>b9?YWp2s>;V0gTwycxNe:Rb^CA,`J5+VM0%VV' );
define( 'LOGGED_IN_KEY',    'u3!/$jnC9P;.NV]*Zi/PW)R8&5;sZ.8J1[)*DXe}U(3aZcJdlR.j:Xb$Ew&2aq6E' );
define( 'NONCE_KEY',        '<1*{4H<[>T@HhgY^h~w tO5i$E.(*h(x}>+-~}Sm_sM@>4ZATS`/-(D0_{ _shj_' );
define( 'AUTH_SALT',        'N+2K<5OD]RZ*:$PQ(j:I+3jX<k{otpRopjF4E9[V8qNh|2`LGquDPrI#XNemGYqb' );
define( 'SECURE_AUTH_SALT', 's)3S6jF((7bz`ti#pi ;W!RO{wGo7f)_e-$L2%5u|^N#amkQ`gCBp1J5)f/6OaEI' );
define( 'LOGGED_IN_SALT',   'DweMPNdp#!$FxzM/(%$ZxZ*]@VnELlr{9oB*.,1esAn`_IEECe?GK5-3(.usF+:3' );
define( 'NONCE_SALT',       '/Y#CODgt_:M2~NHLxU4*q`9BBt8BN2LAPbk7EXW`c1_`)++s@;a*v+Ah4Tq$.PBz' );

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
