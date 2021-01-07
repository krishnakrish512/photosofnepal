<?php
function photographer_remove_menu_items() {
	if ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) ) {

		global $menu, $submenu;

		//change products menu and submenu
		$menu[26][0]                                  = "Photographs";
		$submenu['edit.php?post_type=product'][5][0]  = "All Photographs";
		$submenu['edit.php?post_type=product'][10][2] = get_page_link( get_page_by_title( 'Add Photograph' ) );

//		remove_menu_page( 'edit.php' );                   //Posts
//		remove_menu_page( 'edit-comments.php' );          //Comments
//		remove_menu_page( 'tools.php' );                  //Tools
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

add_action( "admin_print_styles-upload.php", 'photography_admin_media_style' );

function custom_post_author_archive( $query ) {

	if ( ! is_admin() && $query->is_author && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'product' ) );
	}


	if ( is_admin() && get_query_var( 'post_type' ) == 'attachment' && ! current_user_can( 'edit_others_posts' ) ) {
		$query->set( 'author', get_current_user_id() );
	}

	if ( is_admin() && get_query_var( 'post_type' ) == 'album' && ! current_user_can( 'edit_others_posts' ) ) {
		$query->set( 'author', get_current_user_id() );
	}
}

//add_action( 'pre_get_posts', 'custom_post_author_archive' );