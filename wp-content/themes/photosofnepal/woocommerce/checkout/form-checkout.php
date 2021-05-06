<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	$error = false;
	if ( empty( $_POST['billing_first_name'] ) || empty( $_POST['billing_email'] ) || empty( $_POST['billing_phone'] ) ) {
		$error = true;
	}

	if ( ! $error ) {
		$cart_products = WC()->cart->get_cart();

		$product_details = '';

		foreach ( $cart_products as $product ) {
			$product_details .= "Id: " . $product['product_id'] . "  Size: " . $product['variation']['attribute_pa_resolution'] . "<br/>";
		}

		$to = 'chandra@nirvanstudio.com';
//	$to      = 'ajayprazz@gmail.com';
		$subject = 'ImagePasal Inquiry';

		$body = "Inquirer Details:<br/>";
		$body .= "Name: " . $_POST['billing_first_name'] . "<br/>";
		$body .= "Email: " . $_POST['billing_email'] . "<br/>";
		$body .= "Phone Number: " . $_POST['billing_phone'] . "<br/>";
		$body .= "Address: " . $_POST['billing_address_1'] . "<br/>";
		$body .= "Country: " . $_POST['billing_country'] . "<br/>";
		$body .= "Company: " . $_POST['billing_company'] . "<br/>";
		$body .= "Company Email: " . $_POST['billing_company_email'] . "<br/><br/>";
		$body .= "Inquiry For:<br/>";
		$body .= $product_details;

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		$success = wp_mail( $to, $subject, $body, $headers );
	}

//	var_dump( $success );

}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

	return;
}

?>

<form name="checkout" method="post" class="woocommerce-checkout"
      action="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-7 col-md-6 ">
            <div class="purchase-form">

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<?php
					if ( isset( $error ) && $error ) {
						echo "<p>Please all fill required information. </p>";
					}
					?>

					<?php do_action( 'woocommerce_checkout_billing' ); ?>


					<?php do_action( 'woocommerce_checkout_shipping' ); ?>


					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

                <div class="payment-option mb-4 d-none">
                    <h4 class="mb-4">Payment Option</h4>
					<?php woocommerce_checkout_payment(); ?>
                </div>
                <div class="payment-option mb-4">
                    <button class="btn btn-primary" type="submit">Inquiry</button>
                </div>

				<?php
				if ( isset( $success ) ) {
					if ( $success ) {
						echo "<p>Inquiry sent successfully</p>";
					} else {
						echo "<p>Failed Sending inquiry</p>";
					}
				}
				?>
            </div>
        </div>
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
        <div class="col-lg-5 col-md-6 border-left">
            <div class="purchase-detail">
                <div class=" d-flex justify-content-between align-items-center mb-5    ">

                    <h3 id="order_review_heading" class="mb-0">Purchase Detail</h3>
                    <a href="<?= wc_get_cart_url() ?>" class="text-primary">Edit Cart</a>
                </div>


				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="purchase-detail__list">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
            </div>
        </div>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>


    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
