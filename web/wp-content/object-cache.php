<?php
/**
 * Disable object caching for local development
 */
if ( ! defined('WP_ENV') || 'local' !== WP_ENV ) {
	require_once( WP_CONTENT_DIR . '/plugins/wp-redis/object-cache.php' );
}