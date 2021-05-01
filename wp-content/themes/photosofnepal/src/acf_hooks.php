<?php

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'manage_options',
//		'redirect'		=> false
	) );
}


add_filter( 'acf/fields/post_object/query/name=gallery', 'my_acf_fields_post_object_query', 10, 3 );
function my_acf_fields_post_object_query( $args, $field, $post_id ) {

	$args['author'] = get_current_user_id();

	$args['meta_key']     = 'photography_product_id';
	$args['meta_compare'] = 'EXISTS';


	return $args;
}

add_filter( 'acf/fields/post_object/query/name=gallery_photographs', 'my_acf_fields_photographs_query', 10, 3 );
function my_acf_fields_photographs_query( $args, $field, $post_id ) {

//	$args['author'] = get_current_user_id();

	$args['meta_key']     = 'photography_product_id';
	$args['meta_compare'] = 'EXISTS';

	var_dump( $args );


	return $args;
}