<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * You can view all defined constants with:
 * print_r(@get_defined_constants());
 *
 * @package WordPress
 */

define( 'PROJECT_ROOT', dirname( dirname( __FILE__ ) ) );

/* Bootstrap composer dependencies, if present */
if ( file_exists( PROJECT_ROOT . '/vendor/autoload.php' ) ) {
	require_once PROJECT_ROOT . '/vendor/autoload.php';
}

/**
 * Load environment variables from the .env file with Dotenv, if we're not in a docker environment
 */
if ( class_exists( 'Dotenv\Dotenv' ) && file_exists( PROJECT_ROOT . '/.env' ) ) {
	$dotenv = Dotenv\Dotenv::create( PROJECT_ROOT );
	$dotenv->load();
	$dotenv->required( [ 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'DB_PORT' ] );
	$db_name     = getenv( 'DB_NAME' );
	$db_user     = getenv( 'DB_USER' );
	$db_password = getenv( 'DB_PASSWORD' );
	$db_host     = getenv( 'DB_HOST' ) . ':' . getenv( 'DB_PORT' );
} else {
	define( 'DATABASE_URL', getenv( 'DATABASE_URL' ) );

	if ( DATABASE_URL ) {
		$database_url = parse_url( DATABASE_URL );

		$db_name     = trim( $database_url['path'], '/' );
		$db_user     = $database_url['user'];
		$db_password = $database_url['pass'];
		$db_host     = $database_url['host'] . ':' . $database_url['port'];
	}
}

define( 'DB_NAME', $db_name );
define( 'DB_USER', $db_user );
define( 'DB_PASSWORD', $db_password );
define( 'DB_HOST', $db_host );

// What environment are we in?
define( 'WP_ENV', getenv( 'WP_ENV' ) );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) );
define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) );

$table_prefix = 'wp_';

if ( 'local' === WP_ENV ) {
	define( 'WP_DEBUG', true );
	define( 'WP_CACHE', false );
	define( 'JETPACK_DEV_DEBUG', true );
} else {
	define( 'WP_DEBUG', false );
	// Use advanced-cache.php for production.
	define( 'WP_CACHE', true );
}

if ( WP_DEBUG ) {
	// Custom logging function.
	if ( ! function_exists( 'log_me' ) ) {
		function log_me( $message ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}

	/*
	 * This will log all errors notices and warnings to a file called debug.log in
	 * wp-content only when WP_DEBUG is true. if Apache does not have write permission,
	 * you may need to create the file first and set the appropriate permissions (i.e. use 644).
	 */
	define( 'WP_DEBUG_LOG', true );


	/* Display notices or not (set logging to true if this is false) */
	define( 'WP_DEBUG_DISPLAY', true );

	/*
	* Save database queries to an array that can be displayed
	* Note that this will have a performance impact on the site
	*
	* Access these through $wpdb->queries
	*/
	// define( 'SAVEQUERIES', true );

	/* Script Debugging */
	/*
	 * If true, changes made to the scriptname.dev.js and filename.dev.css files in the
	 * wp-includes/js, wp-includes/css, wp-admin/js, and wp-admin/css directories will be
	 * reflected on your site.
	 */
	define( 'SCRIPT_DEBUG', true );

	/*
	 * Disable javascript concatenation in admin area
	 */
	// define( 'CONCATENATE_SCRIPTS', false );
}

/**
 * Home and siteurl
 * Setting the constants overrides the database settings
 */
define( 'WP_HOME', getenv( 'WP_HOME' ) );
define( 'WP_SITEURL', getenv( 'WP_SITEURL' ) );

/**
 * wp-content settings
 * Required when WordPress core files are storied in a subdirectory
 */
define( 'WP_CONTENT_DIR', PROJECT_ROOT . '/web/wp-content' );
define( 'WP_CONTENT_URL', WP_HOME . '/wp-content' );

/**
 * Theme and stylesheet paths
 * (probably shouldn't use these)
 */
// define( 'TEMPLATEPATH', get_template_directory() );
// define( 'STYLESHEETPATH', get_stylesheet_directory() );

/**
 * Set the default theme
 *
 * Put this in wp-config-sample.php and WordPress will use this setting when installing
 */
// define( 'WP_DEFAULT_THEME', 'twentyfourteen' );

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/* Enable this constant temporarily to change the site url in the database
 * 1. Uncomment line below
 * 2. Navigate to http://mynewsitedomain.com/wp-login.php and login
 * 3. Be sure to recomment this line
 */
// define( 'RELOCATE',true );


/* Additional WordPress settings */

/* Change interval for AJAX saves when editing posts */
// define( 'AUTOSAVE_INTERVAL', 160 );  // seconds

/* Specify number of post revisions to save (or disable with 'false') */
// define( 'WP_POST_REVISIONS', 3 );

/* Specify number of days content is held in trash before being permanently deleted */
// define( 'EMPTY_TRASH_DAYS', 30 );  // default is 30 days; set to 0 to disable trash

/* Enable the Trash feature for media */
// define( 'MEDIA_TRASH', true );

/* Change the URLs temporarily before doing a search and replace in the database */
// ob_start( 'nacin_dev_urls' );
// 	function nacin_dev_urls( $buffer ) {
// 	$live = 'http://olddomain.com';
// 	$dev = 'http://newdomain.com'; return str_replace( $live, $dev, $buffer );
// 	}

/**
 * Set Cookie Domain
 *
 * The domain set in the cookies for WordPress can be specified for those with unusual domain
 * setups. One reason is if subdomains are used to serve static content. To prevent WordPress
 * cookies from being sent with each request to static content on your subdomain you can set
 * the cookie domain to your non-static domain only.
 */
// define( 'COOKIE_DOMAIN', 'www.askapache.com' );

/* Additional Cookie Settings */
// define( 'COOKIEPATH', preg_replace( '|https?://[^/]+|i', '', get_option( 'home' ) . '/' ) );
// define( 'SITECOOKIEPATH', preg_replace( '|https?://[^/]+|i', '', get_option( 'siteurl' ) . '/' ) );
// define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'wp-admin' );
// define( 'PLUGINS_COOKIE_PATH', preg_replace( '|https?://[^/]+|i', '', WP_PLUGIN_URL ) );


/**
 * Disable Plugin and Theme Editors
 *
 * Warning: may break plugins that rely on current_user_can('edit_plugins')
 */
define( 'DISALLOW_FILE_EDIT', true );

/**
 * Disable Plugin and Theme Update Installation
 *
 * Blocks users being able to use the plugin and theme installation/update functionality
 * from the WordPress admin area. Also disallows the theme and plugin editors
 */
define( 'DISALLOW_FILE_MODS', true );

/**
 * Allow unfiltered uploads--administrators can upload any file type
 */
// define( 'ALLOW_UNFILTERED_UPLOADS', true );

/* Enable WordPress Multisite */

// define( 'WP_ALLOW_MULTISITE', true );
// define( 'SUBDOMAIN_INSTALL', true );
// define( 'DOMAIN_CURRENT_SITE', getenv('DOMAIN_CURRENT_SITE') ? getenv('DOMAIN_CURRENT_SITE') : $_SERVER['SERVER_NAME'] );
// define( 'PATH_CURRENT_SITE', '/' );
// define( 'SITE_ID_CURRENT_SITE', 1 );
// define( 'BLOG_ID_CURRENT_SITE', 1 );

/* Configure Multisite */
// define( 'SUNRISE', 'on' );

/**
 * WP_CRON Settings
 */
// If disabling WP_CRON, set a cron job like `*/5 * * * * curl http://example.com/wp/wp-cron.php` in your server's crontab file

/* Disable cron entirely */
define( 'DISABLE_WP_CRON', true );

/* Make sure a cron process cannot run more than once every so many seconds */
// define( 'WP_CRON_LOCK_TIMEOUT',60 );

/* Alternative cron that uses redirection, but isn't as reliable */
// define( 'ALTERNATE_WP_CRON', true );

/**
 * Server Setting Overrides
 */

/* View all defined php constants */
// print_r( @get_defined_constants() );

/* Increase PHP memory limit settings, if possible/needed */
// define( 'WP_MEMORY_LIMIT', '64M' );

/* Change PHP memory limit in WordPress administration area */
// define( 'WP_MAX_MEMORY_LIMIT', '256M' );

/* Attempt to override default file permissions */
// define( 'FS_CHMOD_DIR', (0755 & ~ umask()) );
// define( 'FS_CHMOD_FILE', (0644 & ~ umask()) );

/**
 * Enable Automatic Database Repair
 * Note that this can be accessed at /wp-admin/maint/repair.php even when not logged in
 */
// define( 'WP_ALLOW_REPAIR', true );

/**
 * Do Not Upgrade Global Tables
 *
 * Prevents upgrade functions from doing expensive database queries on global tables
 *
 * Particularly useful for sites with large user and usermeta tables, so the database upgrade
 * can be done manually
 *
 * Also useful for installations that share user tables between bbPress and WordPress installs
 * Where only one site should be the upgrade master
 */
// define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true );

/**
 * Custom User and Usermeta Tables
 *
 * Defined a custom user and usermeta table that can be used for multiple instances of WordPress
 */
// define( 'CUSTOM_USER_TABLE', $table_prefix.'my_users' );
// define( 'CUSTOM_USER_META_TABLE', $table_prefix.'my_usermeta' );

/**
 * SSL
 */
/* Force SSL Login */
define( 'FORCE_SSL_LOGIN', true );

/* Force SSL for Logins and Admin */
define( 'FORCE_SSL_ADMIN', true );

/**
 * Auto updating
 */
/* Disable all core updates: */
// define( 'WP_AUTO_UPDATE_CORE', false );

/* Enable all core updates, including minor and major: */
// define( 'WP_AUTO_UPDATE_CORE', true );

/* Enable core updates for minor releases (default) */
// define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/* Disable automatic updater completely */
define( 'AUTOMATIC_UPDATER_DISABLED', true );

/* Skip adding new default theme with new major versions */
// define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );

/**
 * Block external URL requests
 *
 * WP_ACCESSIBLE_HOSTS allow additional hosts to bypass the block, and is a comma separated list of hostnames to allow, and can include wildcard subdomains
 */
// define( 'WP_HTTP_BLOCK_EXTERNAL', true );
// define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,*.github.com' );

/**
 * WordPress.com API key
 */
// define( 'WPCOM_API_KEY', 'YourKeyHere' );

/**
 * SSL Configuration: we need to tell WordPress that we're using SSL, since it's handled by
 * a reverse proxy through docker and nginx
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

/**
 * Redis Caching
 *
 * @link https://wordpress.org/plugins/wp-redis
 */
define( 'REDIS_URL', getenv( 'REDIS_URL' ) );

if ( REDIS_URL ) {
	$redis_url = parse_url( REDIS_URL );
	define( 'REDIS_HOST', $redis_url['host'] );
	define( 'REDIS_PORT', $redis_url['port'] );
	define( 'REDIS_AUTH', $redis_url['pass'] );
}

$redis_server = array(
	'host' => REDIS_URL ? REDIS_HOST : '127.0.0.1',
	'port' => REDIS_URL ? REDIS_PORT : 6379,
	'auth' => REDIS_URL ? REDIS_AUTH : '',
);

define( 'WP_CACHE_KEY_SALT', getenv( 'WP_CACHE_KEY_SALT' ) );

/**
 * AWS Credentials
 */
define( 'DBI_AWS_ACCESS_KEY_ID', getenv( 'AWS_ACCESS_KEY_ID' ) );
define( 'DBI_AWS_SECRET_ACCESS_KEY', getenv( 'AWS_SECRET_ACCESS_KEY' ) );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/* Redis page caching */
require_once PROJECT_ROOT . '/web/redis-page-cache-config.php';

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
