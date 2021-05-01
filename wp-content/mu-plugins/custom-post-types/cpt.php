<?php

/**
 * @param $name
 * @param array $args
 * https://developer.wordpress.org/resource/dashicons/#schedule
 */
function add_post_type( $name, $args = array() ) {
	add_action( 'init', function () use ( $name, $args ) {
		$upper = ucwords( $name );
		$name  = strtolower( str_replace( ' ', '_', $name ) );

		$args = array_merge(
			[
				'public'      => true,
				'label'       => $upper . "s",
				'labels'      => array( 'add_new_item' => "Add new $upper" ),
				'supports'    => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'has_archive' => true
			],
			$args );

		register_post_type( $name, $args );
	} );
}

function add_taxonomy( $name, $post_type, $args = array() ) {
	$name = strtolower( $name );
	add_action( 'init', function () use ( $name, $post_type, $args ) {
		$args = array_merge(
			[
				'label' => ucwords( $name )
			],
			$args );

		register_taxonomy( $name, $post_type, $args );
	} );
}

add_post_type( 'delete_request', [
	'public'      => true,
	'label'       => 'Delete Requests',
	'menu_icon'   => 'dashicons-calendar',
	'labels'      => [ 'add_new_item' => "Add new delete request" ],
	'supports'    => [ 'title' ],
	'has_archive' => true
] );

add_post_type( 'gallery', [
	'public'      => true,
	'label'       => 'Galleries',
	'menu_icon'   => 'dashicons-calendar',
	'labels'      => [ 'add_new_item' => "Add new gallery" ],
	'supports'    => [ 'title', 'thumbnail', 'author' ],
	'has_archive' => true
] );


$labels = [
	'name'                       => 'Albums',
	'singular_name'              => 'Album',
	'menu_name'                  => 'Album',
	'all_items'                  => 'All Albums',
	'parent_item'                => 'Parent Album',
	'parent_item_colon'          => 'Parent Album:',
	'new_item_name'              => 'New Album Name',
	'add_new_item'               => 'Add New Album',
	'edit_item'                  => 'Edit Album',
	'update_item'                => 'Update Album',
	'separate_items_with_commas' => 'Separate Album with commas',
	'search_items'               => 'Search Albums',
	'add_or_remove_items'        => 'Add or remove Albums',
	'choose_from_most_used'      => 'Choose from the most used Albums',
];

//add_taxonomy( "album", 'product', [
//	'labels'       => $labels,
//	'hierarchical' => false
//] );
// clear the permalinks after the post type has been registered
flush_rewrite_rules();