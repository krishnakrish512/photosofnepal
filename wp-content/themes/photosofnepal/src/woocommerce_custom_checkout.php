<?php

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

/**
 * update default woocommerce address fields
 *
 * @param $fields
 *
 * @return mixed
 */
function photography_default_address_fields( $fields ) {

	unset( $fields['last_name'] );
	unset( $fields['address_2'] );
	unset( $fields['city'] );
	unset( $fields['state'] );
	unset( $fields['postcode'] );

	$fields['first_name']['label'] = 'Full Name';

	$fields['address_1']['label']       = 'Address';
	$fields['address_1']['placeholder'] = 'Address';
	$fields['address_1']['type']        = 'textarea';
	$fields['address_1']['required']    = false;

	$fields['country']['required'] = false;

	$fields['company_email'] = [
		'label'       => 'Company Email',
		'placeholder' => 'Company Email',
		'type'        => 'email',
		'required'    => false,
		'priority'    => 30
	];

	return $fields;
}

add_filter( 'woocommerce_default_address_fields', 'photography_default_address_fields', 20, 1 );


function photography_billing_fields_update( $fields ) {

	$order = [
		"billing_first_name",
		"billing_email",
		"billing_phone",
		"billing_address_1",
		"billing_country",
		"billing_company",
		"billing_company_email"
	];

	$priority = 10;
	foreach ( $order as $field ) {
		$fields[ $field ]['class']       = [ 'form-group' ];
		$fields[ $field ]['input_class'] = [ 'form-control' ];
		$fields[ $field ]['priority']    = $priority;
		$priority                        = $priority + 10;
	}

	return $fields;
}

add_filter( 'woocommerce_billing_fields', 'photography_billing_fields_update' );

function photography_shipping_fields_update( $fields ) {

	foreach ( $fields as $key => $field ) {
		$fields[ $key ]['class']       = [ 'form-group' ];
		$fields[ $key ]['input_class'] = [ 'form-control' ];
	}

	return $fields;
}

add_filter( 'woocommerce_shipping_fields', 'photography_shipping_fields_update' );

//remove additional information field from checkout page
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );

//Remove "(optional)" from our non required fields
add_filter( 'woocommerce_form_field', 'remove_checkout_optional_fields_label', 10, 4 );
function remove_checkout_optional_fields_label( $field, $key, $args, $value ) {
// Only on checkout page
	if ( is_checkout() && ! is_wc_endpoint_url() ) {
		$optional = '&nbsp;<span class="optional">(' . 'optional' . ')</span>';
		$field    = str_replace( $optional, '', $field );
	}

	return $field;
}

//function action_woocommerce_payment_complete( $order_id ) {
//	$order = new WC_Order( $order_id );
//	$order->update_status( 'completed' ); //Order status will be updated to “Invoice To Be Printed”.
//}
//
//add_action( 'woocommerce_checkout_order_processed', 'action_woocommerce_payment_complete', 1, 1 );


add_filter( 'woocommerce_payment_gateways', 'growdev_remove_payment_gateways', 20, 1 );

function growdev_remove_payment_gateways( $load_gateways ) {
	$remove_gateways = array(
		'WC_Gateway_COD'
	);
	foreach ( $load_gateways as $key => $value ) {
		if ( in_array( $value, $remove_gateways ) ) {
			unset( $load_gateways[ $key ] );
		}
	}

	return $load_gateways;
}

add_filter( 'woocommerce_payment_gateways', 'my_core_gateways', 30, 1 );

function my_core_gateways( $methods ) {
	$methods[] = 'WC_Gateway_COD_custom';

	return $methods;
}

class WC_Gateway_COD_custom extends WC_Gateway_COD {

	public function process_payment( $order_id ) {

		$order = wc_get_order( $order_id );

		// Mark as on-hold
		$order->update_status( 'completed' );

		// Reduce stock levels
		$order->reduce_order_stock();

		// Remove cart
		WC()->cart->empty_cart();

		// Return thankyou redirect
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order )
		);

	}

}


//restrict direct access to order-received/thank-you page
function thank_you_rd() {
	if ( ! is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	if ( wp_get_referer() == wc_get_checkout_url() ) {
		return;
	}

	wp_redirect( get_home_url() );
	exit;
}

add_action( 'template_redirect', 'thank_you_rd' );
