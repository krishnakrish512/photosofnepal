<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

    <section class="similar-section section-spacing bg-gray section-spacing__y-padding">
        <div class="container">

			<?php
			$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related Photos', 'woocommerce' ) );

			if ( $heading ) :
				?>
                <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php //woocommerce_product_loop_start(); ?>
            <div class="discover-photos__grid justified-gallery--sm">
				<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

//				wc_get_template_part( 'content', 'product' );

					$product_thumbnail_id = $related_product->get_image_id();

					$args = [
						'post_type'   => 'gallery',
						'post_status' => 'publish',
						'meta_query'  => [
							[
								'key'     => 'photographs',
								'value'   => $product_thumbnail_id,
								'compare' => 'LIKE'
							]
						],
					];

					$gallery = get_posts( $args );
					if ( ! empty( $gallery ) ) {
						$gallery_url = get_permalink( $gallery[0] );
					}
					?>
                    <div class="discover-photos__grid-item">

                        <img src="<?= wp_get_attachment_image_url( $product_thumbnail_id, 'gallery_thumbnail' ) ?>"
                             alt="">
                        <figcaption>
                            <div class="figure-tools">
                                <div class="figure-icons">
									<?php echo do_shortcode( "[ti_wishlists_addtowishlist product_id='" . $related_product->get_id() . "']" ); ?>
									<?php
									if ( ! empty( $gallery ) ):
										?>
                                        <a href="<?= esc_url( $gallery_url ) ?>"> <span class="icon-stack"></span></a>
									<?php
									endif;
									?>
                                </div>
                            </div>
                            <div class="figure-info">
                                <h6 class="font-weight-light"><?php the_title() ?></h6>
                                <a href="<?= get_photogtaphy_buy_url( $related_product ) ?>"
                                   class="btn btn-primary btn-sm">Buy</a>
                            </div>
                        </figcaption>
                        <a href="<?= esc_url( $related_product->get_permalink() ) ?>" class="stretched-link"></a>

                    </div>

				<?php endforeach; ?>
            </div>
			<?php //woocommerce_product_loop_end(); ?>

        </div>
    </section>
<?php
endif;

wp_reset_postdata();
