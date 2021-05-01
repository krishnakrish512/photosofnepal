<?php
function photographer_remove_menu_items() {
	if ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) || wc_current_user_has_role( 'seller' ) ) {

		global $menu, $submenu;

		//change products menu and submenu
		$menu[26][0]                                 = "Photographs";
		$submenu['edit.php?post_type=product'][5][0] = "All Photographs";
//		$submenu['edit.php?post_type=product'][10][2] = get_page_link( get_page_by_title( 'Add Photograph' ) );

		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'edit.php?post_type=delete_request' );                  //Delete Requests

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