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
define( 'DB_NAME', 'simplonw' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'o2T_6V1JDz_]K75O$OVwpL:Yg5)YW@_lDlXub TxuUy$)5&C;(LnuR21l`Gzk8:2' );
define( 'SECURE_AUTH_KEY',  'Q<FPv3ohn?x?yj]S+73p[}n_*CfFvlD;qS|urO)kY+H7;<UMA9E1Gpdp9c4R^Bp?' );
define( 'LOGGED_IN_KEY',    'FhwxDf0(%kP+v#J|sj|#AVd(vIj0|Q_W[({&L3:9w$w$gYqJXdABTN}8@ybPSj~f' );
define( 'NONCE_KEY',        '57Uo6EV0DCXo^m_Bsk_/.]z4^|5[@BAD|~_1Y.[_g(>LkYeY!q`C_O.nV2rf.u9f' );
define( 'AUTH_SALT',        '[I7zv~[w?QHf(vb3)Crusr,+q:gGUML[4e0w7g&gl:cMVVdTv5cYsdOUD[jMlv}A' );
define( 'SECURE_AUTH_SALT', 'aIa(BLiL Ye-Vf4i-%={-}{39^La2QM#T=)8FAboTw;z7JAK$&4K3]}m@?N{/>K1' );
define( 'LOGGED_IN_SALT',   'X-0KP(0&}#mCgD[9faO:wHvxvLFAx(Yo}r0UfjFxocQ`d(Z,#OTr.I2<<m0+P2ZV' );
define( 'NONCE_SALT',       'd%rH(A><Ga,f4XEUgXh4U E)dgVSfbiv9:d8CK:`?{Yz3>DWQ F^9xs(iaC0v`41' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
