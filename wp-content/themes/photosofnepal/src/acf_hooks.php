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

function populate_vacancy_applied_for( $field ) {
	// only on front end
	if ( is_admin() ) {
		return $field;
	}

	global $wp;
	$gallery_id = $wp->query_vars['wcfm-cpt1-manage'];

	$field['value'] = get_field( 'photographs', $gallery_id );

	return $field;
}

add_filter( 'acf/prepare_field/key=field_5fa8ce7d8504b', 'populate_vacancy_applied_for' );