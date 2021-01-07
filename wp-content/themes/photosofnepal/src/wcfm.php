<?php
add_filter( 'wcfm_menus', 'change_dashboard_product_menu' );

function change_dashboard_product_menu( $wcfm_menus ) {

	if ( wcfm_is_vendor() ) {
		unset( $wcfm_menus['wcfm-orders'] );
	}

	$wcfm_menus['wcfm-products']['new_url'] = esc_url( get_page_link( get_page_by_title( 'Add Photograph' ) ) );

	$wcfm_menus['wcfm-profile-manager'] = [
		'label' => 'Profile',
		'url'   => get_wcfm_profile_url(),
		'icon'  => 'user'
	];

	return $wcfm_menus;
}

add_action( 'wcfm_profile_update', function ( $vendor_id, $wcfm_profile_form ) {
	global $WCFM, $wpdb, $_POST, $blog_id;

	$description = wcfm_get_user_meta( $vendor_id, 'description', true );
	wcfm_update_user_meta( $vendor_id, '_store_description', $description );

	if ( isset( $wcfm_profile_form['wp_user_avatar'] ) && ! empty( $wcfm_profile_form['wp_user_avatar'] ) ) {
		$vendor_data             = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
		$vendor_data['gravatar'] = $WCFM->wcfm_get_attachment_id( $wcfm_profile_form['wp_user_avatar'] );
		update_user_meta( $vendor_id, 'wcfmmp_profile_settings', $vendor_data );
	}

}, 50, 2 );

add_action( 'wcfm_vendor_settings_update', function ( $vendor_id, $wcfm_settings_form ) {
	global $WCFM, $wpdb, $_POST, $blog_id;

	$description = wcfm_get_user_meta( $vendor_id, '_store_description', true );
	wcfm_update_user_meta( $vendor_id, 'description', $description );

	if ( isset( $wcfm_settings_form['gravatar'] ) && ! empty( $wcfm_settings_form['gravatar'] ) ) {
		$wp_user_avatar = $wcfm_settings_form['gravatar'];

		// Remove old attachment postmeta
		delete_metadata( 'post', null, '_wp_attachment_wp_user_avatar', $vendor_id, true );
		// Create new attachment postmeta
		add_post_meta( $wp_user_avatar, '_wp_attachment_wp_user_avatar', $vendor_id );
		// Update usermeta
		update_user_meta( $vendor_id, $wpdb->get_blog_prefix( $blog_id ) . 'user_avatar', $wp_user_avatar );
	}

}, 50, 2 );

add_filter( 'wcfm_is_products_type_filter', '__return_false' );
add_filter( 'wcfm_is_products_category_filter', '__return_false' );
add_filter( 'wcfm_is_allow_archive_product', '__return_false' );
add_filter( 'wcfm_is_allow_products_export', '__return_false' );


//hide soical media in profile
add_filter( 'wcfm_profile_fields_social', function ( $social_fields ) {
	$social_fields = wcfm_hide_field( 'google_plus', $social_fields );

	return $social_fields;
}, 50 );

//vendor setting
add_filter( 'wcfm_is_allow_profile_complete_bar', '__return_false' );
add_filter( 'wcfm_is_allow_store_visibility', '__return_false' );
add_filter( 'wcfm_is_allow_store_address', '__return_false' );
add_filter( 'wcfm_is_allow_vseo_settings', '__return_false' );
add_filter( 'wcfm_is_allow_customer_support_settings', '__return_false' );
add_filter( 'wcfm_is_allow_brand_settings', '__return_false' );
add_filter( 'wcfm_is_allow_vshipping_settings', '__return_false' );
add_filter( 'wcfm_is_allow_policy_settings', '__return_false' );

add_filter( 'wcfm_is_allow_rich_editor', function ( $editor ) {
	return '';
}, 750 );

add_filter( 'wcfm_products_limit_label', function ( $label ) {
	return '';
}, 100 );

//hide store settings from vendor setting
add_filter( 'wcfm_setting_default_tab', function ( $default_tab ) {
	if ( wcfm_is_vendor() ) {
		$default_tab = 'wcfm_settings_form_payment_head';
	}

	return $default_tab;
}, 50 );
add_action( 'after_wcfm_marketplace_settings', function ( $user_id ) {
	if ( wcfm_is_vendor() ) {
		?>
        <style>
            #wcfm_settings_dashboard_head {
                display: none
            }
        </style>
        <script>
            jQuery(document).ready(function ($) {
                $('#wcfm_settings_dashboard_head').remove();
            });
        </script>
		<?php
	}
}, 50 );
