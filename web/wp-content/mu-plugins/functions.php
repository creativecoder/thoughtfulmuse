<?php

function thoughfulmuse_filter_exif( $output, $postID, $imgID ) {
	if ( 'post' !== get_post_type( $postID ) ) {
		return '';
	}

	return $output;
}

add_filter( 'exifography_display_exif', 'thoughfulmuse_filter_exif', 10, 3 );

function thoughtfulmuse_phpmailer_init( $phpmailer ) {
	if ( ! defined( 'SMTP_HOST' ) || ! SMTP_HOST ) {
		error_log( 'SMTP_HOST not defined, using default PHP mailer for thoughtfulmuse.' );
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host       = SMTP_HOST;
	$phpmailer->SMTPAuth   = SMTP_AUTH;
	$phpmailer->Port       = SMTP_PORT;
	$phpmailer->Username   = SMTP_USER;
	$phpmailer->Password   = SMTP_PASS;
	$phpmailer->SMTPSecure = SMTP_SECURE;
	$phpmailer->From       = SMTP_FROM;
	$phpmailer->FromName   = SMTP_NAME;
}

add_action( 'phpmailer_init', 'thoughtfulmuse_phpmailer_init' );
