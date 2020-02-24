<?php

function thoughfulmuse_filter_exif( $output, $postID, $imgID ) {
	if ( 'post' !== get_post_type( $postID ) ) {
		return '';
	}

	return $output;
}

add_filter( 'exifography_display_exif', 'thoughfulmuse_filter_exif', 10, 3 );
