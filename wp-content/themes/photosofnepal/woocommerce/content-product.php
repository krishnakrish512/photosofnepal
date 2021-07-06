<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'discover-photos__grid-item', $product ); ?>>
	<?php
	$image_id = $product->get_image_id();

	$args = [
		'post_type'   => 'gallery',
		'post_status' => 'publish',
		'meta_query'  => [
			[
				'key'     => 'photographs',
				'value'   => $image_id,
				'compare' => 'LIKE'
			]
		],
	];

	$gallery = get_posts( $args );
	if ( ! empty( $gallery ) ) {
		$gallery_url = get_permalink( $gallery[0] );
	}
	?>
    <img src="<?= wp_get_attachment_image_url( $image_id, 'photography_thumbnail' ) ?>"
         alt="<?= $product->get_title() ?>"/>
    <figcaption>
        <div class="figure-tools">
            <div class="figure-icons">
				<?php echo do_shortcode( "[ti_wishlists_addtowishlist product_id='" . $product->get_id() . "']" ); ?>
				<?php
				if ( ! empty( $gallery ) ):
					?>
                    <a href="<?= esc_url( $gallery_url ) ?>"> <span class="icon-stack"></span></a>
				<?php
				endif;
				?>
            </div>
        </div>

        <div class="figure-info ">
            <h6 class="font-weight-light mb-0"><?= $product->get_title() ?></h6>
            <a href="<?= get_photogtaphy_buy_url( $product ) ?>" class="btn btn-primary btn-sm">Buy</a>
        </div>
    </figcaption>
    <a href="<?= $product->get_permalink() ?>" class="stretched-link"></a>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</div>
