<?php

//stop wp from resizing big images
add_filter( 'big_image_size_threshold', '__return_false' );

//jpeg image compression
//add_filter( 'jpeg_quality', function ( $arg ) {
//	return 100;
//} );

add_filter( 'wp_check_filetype_and_ext', 'wpse_file_and_ext', 10, 4 );
function wpse_file_and_ext( $types, $file, $filename, $mimes ) {
	if ( false !== strpos( $filename, '.webp' ) ) {
		$types['ext']  = 'webp';
		$types['type'] = 'image/webp';
	}
	if ( false !== strpos( $filename, '.svg' ) ) {
		$types['ext']  = 'svg';
		$types['type'] = 'image/svg+xml';
	}
	if ( false !== strpos( $filename, '.svgz' ) ) {
		$types['ext']  = 'svgz';
		$types['type'] = 'image/svg+xml';
	}

	return $types;
}


/**
 * Adds webp filetype to allowed mimes
 *
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
 *
 * @param array $mimes Mime types keyed by the file extension regex corresponding to
 *                     those types. 'swf' and 'exe' removed from full list. 'htm|html' also
 *                     removed depending on '$user' capabilities.
 *
 * @return array
 */
function wpse_mime_types( $mimes ) {
	if ( is_user_logged_in() && current_user_can( 'administrator' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';
	}

	return $mimes;
}

add_filter( 'upload_mimes', 'wpse_mime_types' );

//remove admin footer text and wp version
add_filter( 'admin_footer_text', '__return_empty_string', 11 );
add_filter( 'update_footer', '__return_empty_string', 11 );

/*
*@remove default <p> and <br> tags from CF7
*/
//
//add_filter( 'wpcf7_autop_or_not', '__return_false' );

function wpdocs_channel_nav_class( $classes, $item, $args ) {

	$classes[] = 'header__nav-item';

	if ( in_array( 'current_page_item', $classes ) ) {
		$classes[] = 'active';
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'wpdocs_channel_nav_class', 10, 4 );


// search all taxonomies, based on: http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23

function photography_search_where( $where, $query ) {
	global $wpdb;
	if ( $query->is_search() ) {
		$where .= "OR (t.name LIKE '%" . get_search_query() . "%' AND {$wpdb->posts}.post_status = 'publish')";
		//for search by post id
		if ( is_numeric( get_search_query() ) ) {
			$where .= " OR {$wpdb->posts}.ID =" . get_search_query();
		}
	}

	return $where;
}

function photography_search_join( $join, $query ) {
	global $wpdb;
	if ( $query->is_search() ) {
		$join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
	}

	return $join;
}

function photography_search_groupby( $groupby, $query ) {
	global $wpdb;

	// we need to group on post ID
	$groupby_id = "{$wpdb->posts}.ID";
	if ( ! $query->is_search() || strpos( $groupby, $groupby_id ) !== false ) {
		return $groupby;
	}

	// groupby was empty, use ours
	if ( ! strlen( trim( $groupby ) ) ) {
		return $groupby_id;
	}

	// wasn't empty, append ours
	return $groupby . ", " . $groupby_id;
}

//add_filter( 'posts_where', 'photography_search_where', 10, 2 );
//add_filter( 'posts_join', 'photography_search_join', 10, 2 );
//add_filter( 'posts_groupby', 'photography_search_groupby', 10, 2 );

//delete the attachment and respective delete_request post on appoproval
function photography_delete_request_approval( $post_id ) {
	if ( get_post_type( $post_id ) !== 'delete_request' ) {
		return;
	}

	$photograph_id = get_field( 'photograph', $post_id );

	if ( $photograph_id && get_field( 'approve_for_deletion', $post_id ) ) {
		if ( wp_delete_attachment( $photograph_id, true ) ) {
			if ( wp_delete_post( $post_id, true ) ) {
				wp_redirect( admin_url( "edit.php?post_type='delete_request'" ) );
				exit;
			}
		};
	}
}

add_action( 'acf/save_post', 'photography_delete_request_approval' );
