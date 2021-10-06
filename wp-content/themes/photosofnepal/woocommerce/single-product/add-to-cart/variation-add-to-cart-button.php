<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button single-image-download__btn">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
			// WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

    <button type="submit"
            class="single_add_to_cart_button d-block btn btn-primary w-100"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

    <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>"/>
    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>"/>
    <input type="hidden" name="variation_id" class="variation_id" value="0"/>

	<a href="javascript:void(0)" class="d-block btn btn-transparent w-100 mt-2" data-toggle="modal" data-target="#exampleModal"> <i class="far fa-image mr-2"></i>
 Buy the Print Copy</a>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make Inquiry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form action="#">
				<div class="form-group">
					<label for="">Full Name *</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="">Address *</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="">Phone *</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="">Email Address *</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label class="d-block">Print Type</label>
					<label for="iframe" class="mr-3">
						<input type="radio" id="iframe" name="print-type" aria-label="Radio button for following text input"> Photo Print with Frame
					</label>
					<label for="canvas" class="mr-3">
						<input type="radio" id="canvas"  name="print-type" aria-label="Radio button for following text input"> Canvas
					</label>
					<label for="others" class="mr-3">
						<input type="radio" id="others" name="print-type" aria-label="Radio button for following text input"> Others
					</label>
				</div>
				<input type="submit" class="btn btn-primary" value="submit">
			</form>
      </div>
    </div>
  </div>
</div>

</div>


