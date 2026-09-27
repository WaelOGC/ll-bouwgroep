<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'ncC$g(d5<T=Yn;NZ9;5}j{T3/`akNdpn(QZH~dj=0l4=nKrMwR?!pU!^o1o~o)hz' );
define( 'SECURE_AUTH_KEY',   'II!JkJ!Q5R`WFoB[%W=.ASob8/dkGa>MN8u9DFkLcL4EtbDMIS/+l2^#MIW7wM:;' );
define( 'LOGGED_IN_KEY',     ' -UIm?<pEi1;hYrZa8z%6oMw,n*GrDS2EL!uB[/)Z:KlZ g/W;`w$KgwB+73zY<E' );
define( 'NONCE_KEY',         'O,:kaP&,;:P7a@EK5Ua:&3_7ZmeEnRR6]=HEnl,>9-$-)k4TxI3$PWEc/=#]B+iT' );
define( 'AUTH_SALT',         '5lv^lW+d3[uZ$-GJlP?$DI y0%_FQ}J?%>x1gDGE[A9I16og7E%:CRoE(<9`Gnnz' );
define( 'SECURE_AUTH_SALT',  'F!x_IuD$krK%@_F;=9Vf|h_h`nM?P HAQTm_=VN)*F+(P-=|UhqM#krI|(msK9Jl' );
define( 'LOGGED_IN_SALT',    'E:.9)X&O 5bnJ<B1KJPC6%A9Fgng<v2K~FoTNWaTSft#FXDKUqg++ =)$sD]d886' );
define( 'NONCE_SALT',        'zK|4x:(/X@$>dATO9s!<0uyc1R7*K-:^<TrndjKY:&kQV!$`HcU{_n2RnO5+2;uA' );
define( 'WP_CACHE_KEY_SALT', 'oa&,xW`_#&CIT4Y*wH}p_If}=P6.Hkne{Z3R [N?IYRgrQLJLE. ?G,SfWL~n@Dt' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
