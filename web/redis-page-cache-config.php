<?php

$redis_page_cache_config = array();

// Server
$redis_page_cache_config['redis_host'] = REDIS_URL ? REDIS_HOST : '127.0.0.1';
$redis_page_cache_config['redis_port'] = REDIS_URL ? REDIS_PORT : 6379;
$redis_page_cache_config['redis_auth'] = REDIS_URL ? REDIS_AUTH : '';

// Change the cache time-to-live
$redis_page_cache_config['ttl'] = 300;

// Ignore/strip these cookies from any request to increase cachability.
// $redis_page_cache_config['ignore_cookies'] = array( 'wordpress_test_cookie' );

// Ignore/strip these query variables to increase cachability.
// $redis_page_cache_config['ignore_request_keys'] = array( 'utm_source', 'utm_medium' );

// Vary the cache buckets depending on the results of a function call.
// For example, if you have any mobile plugins, you may wish to serve
// all mobile requests from a different cache bucket:

// $redis_page_cache_config['unique'] = array( 'is_mobile' => my_is_mobile() );

// There are some other configuration options you may wish to adjust. You can
// find them all by looking at the contents of the advanced-cache.php file.
