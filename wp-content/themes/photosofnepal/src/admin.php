<?php
function photographer_remove_menu_items() {
	if ( ! wc_current_user_has_role( 'administrator' ) && ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) || wc_current_user_has_role( 'seller' ) ) ) {

		global $menu, $submenu;

//		echo "<pre>";
//		print_r( $menu );
//		echo "</pre>";
//
//		echo "<pre>";
//		print_r( $submenu );
//		echo "</pre>";
//		exit;

		//change products menu and submenu
		$menu[26][0]                                 = "Photographs";
		$submenu['edit.php?post_type=product'][5][0] = "All Photographs";
//		$submenu['edit.php?post_type=product'][10][2] = get_page_link( get_page_by_title( 'Add Photograph' ) );

		remove_menu_page( 'upload.php' );
		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'edit.php?post_type=delete_request' );                  //Delete Requests

		unset( $submenu['edit.php?post_type=product'][15] );
		unset( $submenu['edit.php?post_type=product'][16] );

//		remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_cat&post_type=product' );
//		remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_tag&post_type=product' );
		remove_submenu_page( 'edit.php?post_type=product', 'product_attributes' );
	}
}

add_action( 'admin_menu', 'photographer_remove_menu_items' );

//force the mode into grid view
add_action( 'admin_init', function () {
	if ( isset( $_GET['mode'] ) ) {
		$_GET['mode'] = 'grid';
	}
}, 100 );

function custom_post_author_archive( $query ) {
	if ( is_admin() && get_query_var( 'post_type' ) == 'gallery' && ! current_user_can( 'edit_others_posts' ) ) {
		$query->set( 'author', get_current_user_id() );
	}
}

add_action( 'pre_get_posts', 'custom_post_author_archive' );

if ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) || wc_current_user_has_role( 'vendor' ) ) {
	function z_remove_media_controls() {
		remove_action( 'media_buttons', 'media_buttons' );
	}

	add_action( 'admin_head', 'z_remove_media_controls' );


// disable wyswyg for custom post type, using the global $post
	add_filter( 'user_can_richedit', function ( $default ) {
		global $post;
		if ( $post->post_type === 'product' ) {
			return false;
		}

		return $default;
	} );
}

//add featured product filter in admin
add_action( 'restrict_manage_posts', 'featured_products_sorting' );
function featured_products_sorting() {
	global $typenow;
	$post_type = 'product'; // change to your post type
	$taxonomy  = 'product_visibility'; // change to your taxonomy
	if ( $typenow == $post_type ) {
		$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy = get_taxonomy( $taxonomy );
		wp_dropdown_categories( array(
			'show_option_all' => __( "Show all {$info_taxonomy->label}" ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		) );
	};
}

add_filter( 'parse_query', 'featured_products_sorting_query' );
function featured_products_sorting_query( $query ) {
	global $pagenow;
	$post_type = 'product'; // change to your post type
	$taxonomy  = 'product_visibility'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
		$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
		$q_vars[ $taxonomy ] = $term->slug;
	}
}