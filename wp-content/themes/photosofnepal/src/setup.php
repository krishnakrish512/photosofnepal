<?php

function photos_setup() {
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );

	add_image_size( 'photography_thumbnail', 99999, 400, false );
	add_image_size( 'related_photo_thumbnail', 99999, 170, false );
	add_image_size( 'photography_small', 800, 800, false );
	add_image_size( 'photography_medium', 1920, 1920, false );
	add_image_size( 'photography_large', 1920, 1024, false );
	add_image_size( 'photography_preview', 1024, 1024, false );
	add_image_size( 'gallery_thumbnail', 300, 300, true );
	add_image_size( 'profile_gallery', 350, 350, true );
	add_image_size( 'collection_thumbnail', 400, 400, true );

	register_nav_menus( [
		'primary' => 'Primary',
		'footer'  => 'Footer'
	] );

}

add_action( 'after_setup_theme', 'photos_setup' );

function photos_scripts() {

	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'wp-block-library' );
		wp_deregister_style( 'dashicons' );
	}

	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri() . '/assets/css/fontawesome.min.css' );
	wp_enqueue_style( 'jquery-gallery-style', get_template_directory_uri() . '/assets/css/justifiedGallery.min.css' );
	wp_enqueue_style( 'photography-select2-style', get_template_directory_uri() . '/assets/css/select2.min.css' );
	wp_enqueue_style( 'magnific-style', get_template_directory_uri() . '/assets/css/magnific-popup.css' );

	wp_enqueue_style( 'jquery-tagit-style', get_template_directory_uri() . '/assets/css/jquery.tagit.css' );

//	if ( ! is_wcfm_endpoint_url() ) {
//		wp_deregister_script( 'jquery' );
//	}
	wp_enqueue_script( 'jquery-custom', get_template_directory_uri() . '/scripts/jquery-3.5.1.min.js', [], '1.0', false );
	wp_enqueue_script( 'jquery-ui-custom', get_template_directory_uri() . '/scripts/jquery-ui.js', [], '1.0', false );

	wp_enqueue_script( 'popper-script', get_template_directory_uri() . '/scripts/popper.min.js', [], '1.0', true );
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/scripts/bootstrap.min.js', [], '1.0', true );
	wp_enqueue_script( 'justified-gallery-script', get_template_directory_uri() . '/scripts/jquery.justifiedGallery.min.js', [], '1.0', true );
	wp_enqueue_script( 'photography-select2-script', get_template_directory_uri() . '/scripts/select2.min.js', [], '1.0', true );
	wp_enqueue_script( 'photography-tagit-script', get_template_directory_uri() . '/scripts/tag-it.js', [], '1.0', true );

	wp_enqueue_script( 'magnific-script', get_template_directory_uri() . '/scripts/jquery.magnific-popup.js', [], '1.0', true );

	wp_enqueue_style( 'photos-style', get_template_directory_uri() . '/assets/css/style.css' );

	wp_enqueue_script( 'photos-script', get_template_directory_uri() . '/scripts/script.js', [], '1.0', true );
	wp_enqueue_script( 'woocommerce-custom-script', get_template_directory_uri() . '/scripts/woocommerce-custom.js', [], '1.0', true );

	wp_localize_script( 'photos-script', 'localized_var', [
		'ajax_url'            => admin_url( 'admin-ajax.php' ),
		'home_url'            => get_home_url(),
		'admin_products_list' => admin_url( "/edit.php?post_type=product" ),
		'edit_photograph_url' => get_page_link( get_page_by_title( 'Edit Photograph' ) ),
		'image_sizes'         => get_photography_image_sizes(),
		'product_tags'        => get_all_product_tags()
	] );
}

add_action( 'wp_enqueue_scripts', 'photos_scripts' );

if ( ! wc_current_user_has_role( 'administrator' ) && ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) || wc_current_user_has_role( 'seller' ) ) ) {
	function photography_load_admin_scripts() {
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.1' );

		global $typenow;
		if ( $typenow === "product" ) {
			wp_enqueue_style( 'admin-product-css', get_template_directory_uri() . '/assets/css/admin-product.css', false, '1.15' );

			wp_enqueue_script( 'photography-admin-product-js', get_template_directory_uri() . '/scripts/admin-product.js', [], '1.04', true );
		}

		wp_enqueue_script( 'photography-admin-js', get_template_directory_uri() . '/scripts/admin.js', [], '1.02', true );

		wp_localize_script( 'photography-admin-js', 'localized_var', [
			'add_photograph_url'  => get_page_link( get_page_by_title( 'Add Photograph' ) ),
			'edit_photograph_url' => get_page_link( get_page_by_title( 'Edit Photograph' ) ),
		] );
	}

	add_action( 'admin_enqueue_scripts', 'photography_load_admin_scripts' );
}

function photos_login_scripts() {
	wp_enqueue_style( 'custom-login-style', get_template_directory_uri() . '/assets/css/custom-login.css' );
	wp_enqueue_script( 'custom-login-script', get_template_directory_uri() . '/scripts/custom-login.js' );


	wp_localize_script( 'custom-login-script', 'localized_var', [
		'home_url' => get_home_url(),
	] );
}

add_action( 'login_enqueue_scripts', 'photos_login_scripts' );
