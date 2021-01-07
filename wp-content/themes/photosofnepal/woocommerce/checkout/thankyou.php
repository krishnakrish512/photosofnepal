<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
               class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
			<?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
                   class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
			<?php endif; ?>
        </p>

	<?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

        <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details mb-5">

            <li class="woocommerce-order-overview__order order">
				<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
                <strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>

            <li class="woocommerce-order-overview__date date">
				<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
                <strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>

			<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                <li class="woocommerce-order-overview__email email">
					<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
                    <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                </li>
			<?php endif; ?>

            <li class="woocommerce-order-overview__total total">
				<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
                <strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>

			<?php if ( $order->get_payment_method_title() ) : ?>
                <li class="woocommerce-order-overview__payment-method method">
					<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                    <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                </li>
			<?php endif; ?>

        </ul>

	<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() );

		$downloads      = $order->get_downloadable_items();
		$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();
		?>
        <div class="order-detail--download-summery mt-5">
            <table class="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
                <thead>
                <tr>
                    <th class="product-thumbnail">Product Image</th>
                    <th class="download-product"><span class="nobr">Product</span></th>
                    <th class="download-file"><span class="nobr">Download</span></th>
                </tr>
                </thead>

                <tbody>
				<?php
				if ( $show_downloads ):
					foreach ( $downloads as $download ):
						$product = wc_get_product( $download['product_id'] );
						?>
                        <tr>
                            <td class="product-thumbnail" width="10%">
                                <img src="<?= wp_get_attachment_image_url( $product->get_image_id(), 'photography_thumbnail' ) ?>"
                                     alt="" width="120">
                            </td>
                            <td class="download-product" data-title="Product" width='40%'>
                                <a href="<?= esc_url( $download['product_url'] ) ?>"><?= esc_html( $download['product_name'] ) ?></a>
                            </td>
                            <td class="download-file" data-title="Download" width="30%">
                                <a href="<?= esc_url( $download['download_url'] ) ?>"
                                   class="woocommerce-MyAccount-downloads-file button alt d-block text-center">
                                    <icon class="icon-download mr-3"></icon>
                                    Download</a>
                            </td>
                        </tr>
					<?php
					endforeach;
				endif;
				?>
                </tbody>
            </table>
        </div>
        <div class="alert alert-info text-center py-5" role="alert">
            <h5>Thank you for buying images with us</h5>
        </div>

	<?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
