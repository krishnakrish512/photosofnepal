<?php

//remove order details from thankyou page
remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

add_filter( 'woocommerce_prevent_admin_access', '__return_false' );

function photos_remove_all_quantity_fields( $return, $product ) {
	return true;
}

add_filter( 'woocommerce_is_sold_individually', 'photos_remove_all_quantity_fields', 10, 2 );

// Remove unused default image sizes
function remove_wc_image_sizes() {

	foreach ( get_intermediate_image_sizes() as $size ) {
		if ( ! in_array( $size, array(
			'photography_thumbnail',
			'photography_small',
			'photography_medium',
			'photography_large',
			'photography_preview'
		) ) ) {
			remove_image_size( $size );
		}
	}
}

//add_action( 'init', 'remove_wc_image_sizes' );

/*
* Reduce the strength requirement for woocommerce registration password.
* Strength Settings:
* 0 = Nothing = Anything
* 1 = Weak
* 2 = Medium
* 3 = Strong (default)
*/

add_filter( 'woocommerce_min_password_strength', 'photos_woocommerce_password_filter', 10 );
function photos_woocommerce_password_filter() {
	return 2;
}

//Disable Redirect to Product Page on Search Results Page
add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );


// hide edit-address tab

add_filter( 'woocommerce_account_menu_items', 'photos_remove_address_my_account', 999 );

function photos_remove_address_my_account( $items ) {
	unset( $items['edit-address'] );

	return $items;
}


//add_action( 'init', 'photos_woocommerce_author_support', 999 );

function photos_woocommerce_author_support() {
	add_post_type_support( 'product', 'author' );
}

function remove_linked_products( $tabs ) {

	unset( $tabs['general'] );

	unset( $tabs['inventory'] );

	unset( $tabs['shipping'] );

	unset( $tabs['linked_product'] );

	unset( $tabs['attribute'] );

	unset( $tabs['variations'] );

	unset( $tabs['advanced'] );


	return $tabs;

}

//add_filter( 'woocommerce_product_data_tabs', 'remove_linked_products', 10, 1 );

//add_action( 'add_meta_boxes_product', 'bbloomer_remove_metaboxes_edit_product', 9999 );

function bbloomer_remove_metaboxes_edit_product() {

	// e.g. remove short description
	remove_meta_box( 'postexcerpt', 'product', 'normal' );

	remove_meta_box( 'woocommerce-product-images', 'product', 'side' );

	remove_meta_box( 'woocommerce-product-data', 'product', 'normal' );


}


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


function variation_radio_buttons( $html, $args ) {
	$args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
		'options'          => false,
		'attribute'        => false,
		'product'          => false,
		'selected'         => false,
		'name'             => '',
		'id'               => '',
		'class'            => '',
		'show_option_none' => __( 'Choose an option', 'woocommerce' ),
	) );

	if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
		$selected_key     = 'attribute_' . sanitize_title( $args['attribute'] );
		$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] );
	}

	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
	$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
	$class                 = $args['class'];
	$show_option_none      = (bool) $args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );

	if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[ $attribute ];
	}

	$radios = '<div class="variation-radios"><div class="size-table my-4">
';

	if ( ! empty( $options ) ) {
		if ( $product && taxonomy_exists( $attribute ) ) {
			$terms = wc_get_product_terms( $product->get_id(), $attribute, array(
				'fields' => 'all',
			) );

			global $wpdb;

			foreach ( $terms as $term ) {
				if ( in_array( $term->slug, $options, true ) ) {

					$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = '{$term->slug}' AND products.post_parent = {$product->get_id()}";

					$variation_id = $wpdb->get_col( $query );

					$_product = new WC_Product_Variation( $variation_id[0] );

					$radios .= '<label class="w-100">';
					$radios .= '<div class="size-table__item">';
					$radios .= '<div class="size-table__item-detail">';
					$radios .= '<input type="radio" class="radio-btn" name="' . esc_attr( $name ) . '" value="' . esc_attr( $term->slug ) . '" ' . checked( sanitize_title( $args['selected'] ), $term->slug, false ) . '>';
					$radios .= '<div class="size-table__item-description">';
					$radios .= '<label class="mb-0" for="' . esc_attr( $term->slug ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</label>';
					$radios .= '<div class="size-table__item-info">';
					$radios .= '<span>' . get_downloadable_photograph_size( $variation_id[0] ) . '</span>';
					$radios .= '</div>';
					$radios .= '</div>';
					$radios .= '</div>';
					$radios .= '<div class="size-table__item-size">';
					$radios .= '<h6>' . get_woocommerce_currency_symbol() . ' ' . $_product->get_price() . '</h6>';
					$radios .= '</div>';
					$radios .= '</div>';
					$radios .= '</label>';
				}
			}
		} else {
			foreach ( $options as $option ) {
				$checked = sanitize_title( $args['selected'] ) === $args['selected'] ? checked( $args['selected'], sanitize_title( $option ), false ) : checked( $args['selected'], $option, false );
				$radios  .= '<input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $option ) . '" id="' . sanitize_title( $option ) . '" ' . $checked . '><label for="' . sanitize_title( $option ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</label>';
			}
		}
	}

	$radios .= '</label></div>';

	return $html . $radios;
}

add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2 );

function variation_check( $active, $variation ) {
	if ( ! $variation->is_in_stock() && ! $variation->backorders_allowed() ) {
		return false;
	}

	return $active;
}

add_filter( 'woocommerce_variation_is_active', 'variation_check', 10, 2 );

//set product id as sku
add_action( 'save_post', 'photography_set_sku', 10, 3 );
function photography_set_sku( $post_id, $post, $update ) {
	// Only want to set if this is a new post!
	if ( $update ) {
		return;
	}

	// Only set for post_type = post!
	if ( 'product' !== $post->post_type ) {
		return;
	}

	$product = wc_get_product( $post_id );

	//return if sku is already set
	if ( $product->get_sku() ) {
		return;
	}

	$product->set_sku( $post_id );

	$product->save();
}

/**
 * function to add meta tags to event single page.
 * these meta tags are required for proper functioning of facebook share feature
 */
function photography_share_meta() {
	global $post;

	if ( is_front_page() ) {
		$image = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
		?>
        <meta property="og:url" content="<?= esc_url( site_url() ) ?>"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="<?php bloginfo( 'title' ); ?>"/>
        <meta property="og:description" content="<?php bloginfo( 'description' ) ?>"/>
        <meta property="og:image" content="<?= esc_url( $image ) ?>"/>
		<?php
		return;
	}

	if ( $post ) {
		if ( $post->post_type == "product" && is_single() ) {
			$product = wc_get_product( $post->ID );

			$image_url = wp_get_attachment_image_url( $product->get_image_id(), 'photography_medium' );
			?>
            <meta property="og:url" content="<?= esc_url( $product->get_permalink() ) ?>"/>
            <meta property="og:type" content="website"/>
            <meta property="og:title" content="<?= esc_attr( $product->get_title() ) ?>"/>
            <meta property="og:description" content="<?= esc_attr( $product->get_description() ) ?>"/>
            <meta property="og:image" content="<?= esc_url( $image_url ) ?>"/>
            <meta property="og:image:width" content="600"/>
            <meta property="og:image:height" content="600"/>

            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="">
            <meta name="twitter:title" content="<?= esc_attr( $product->get_title() ) ?>">
            <meta name="twitter:description"
                  content="<?= esc_attr( $product->get_description() ) ?>">
            <meta name="twitter:image"
                  content="<?= esc_url( $image_url ) ?>">
			<?php
		}
	}
}

add_action( 'wp_head', 'photography_share_meta' );

function photography_set_customer_username( $username, $email, $new_user_args, $suffix ) {
	return $email;
}

add_filter( 'woocommerce_new_customer_username', 'photography_set_customer_username', 10, 4 );


function photography_customer_login_redirect( $redirect, $user ) {

	if ( wc_user_has_role( $user, 'customer' ) ) {
		$redirect = get_home_url(); // homepage
	}

	return $redirect;
}

add_filter( 'woocommerce_login_redirect', 'photography_customer_login_redirect', 9999, 2 );

// After registration, logout the user and redirect to home page
function photography_customer_registration_redirect() {
	wp_logout();

	return wc_get_page_permalink( 'myaccount' ) . "edit-account";
}

add_action( 'woocommerce_registration_redirect', 'photography_customer_registration_redirect', 2 );


//  print the edit-address tab content into edit-account tab
add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_address' );


// Rename, re-order my account menu items
function photography_reorder_account_menu() {

	$neworder = [
		'downloads'       => 'Downloads',
		'orders'          => 'Purchase History',
		'tinv_wishlist'   => 'Wishlist',
		'edit-address'    => 'Addresses',
		'edit-account'    => 'Profile',
		'customer-logout' => 'Logout',
	];

	return $neworder;
}

add_filter( 'woocommerce_account_menu_items', 'photography_reorder_account_menu' );


add_action( 'profile_update', 'sync_woocommerce_email', 10, 2 );

function sync_woocommerce_email( $user_id, $old_user_data ) {
	$current_user = wp_get_current_user();

	if ( $current_user->user_email != $old_user_data->user_email ) {
		wp_update_user( [
			'ID'            => $current_user->ID,
			'billing_email' => $current_user->user_email
		] );
	}

	if ( $current_user->user_firstname != $old_user_data->user_firstname ) {
		wp_update_user( [
			'ID'                 => $current_user->ID,
			'billing_first_name' => $current_user->user_firstname
		] );
	}
}

// alter unknown email login error message
function photography_wc_email_login_error( $error ) {
	if ( 'Unknown email address. Check again or try your username.' == $error ) {
		$error = 'Unknown email address';
	}

	return $error;
}

add_filter( 'woocommerce_add_error', 'photography_wc_email_login_error' );


//add first_name field as full name to registration form
function photography_extra_register_fields() { ?>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="reg_billing_first_name"><?php _e( 'Full Name', 'woocommerce' ); ?> <span
                        class="required">*</span></label>
            <input type="text" class="form-control" name="billing_first_name" id="reg_billing_first_name"
                   value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) {
				       esc_attr_e( $_POST['billing_first_name'] );
			       } ?>" required/>
        </div>
    </div>
    <div class="clear"></div>
	<?php
}

add_action( 'woocommerce_register_form_start', 'photography_extra_register_fields' );

//save additional registration form fields
function photography_save_extra_register_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		//First name field which is by default
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		// First name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}
}

add_action( 'woocommerce_created_customer', 'photography_save_extra_register_fields' );

//save edit-account form additional fields
add_action( 'woocommerce_save_account_details', 'photography_save_account_details' );
function photography_save_account_details( $user_id ) {

	if ( isset( $_POST['billing_phone'] ) ) {
		update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}
	if ( isset( $_POST['billing_address_1'] ) ) {
		update_user_meta( $user_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
	}
	if ( isset( $_POST['billing_country'] ) ) {
		update_user_meta( $user_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
	}
	if ( isset( $_POST['billing_company'] ) ) {
		update_user_meta( $user_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
	}

	if ( isset( $_POST['billing_company_email'] ) ) {
		update_user_meta( $user_id, 'billing_company_email', sanitize_text_field( $_POST['billing_company_email'] ) );
	}

}

//Add the Field into WordPress /wp-admin/ Edit Profile page
add_filter( 'woocommerce_customer_meta_fields', 'photography_admin_address_field' );

function photography_admin_address_field( $admin_fields ) {

	$admin_fields['billing']['fields']['billing_company_email'] = array(
		'label'       => 'Company Email',
		'description' => '',
	);

	return $admin_fields;

}
