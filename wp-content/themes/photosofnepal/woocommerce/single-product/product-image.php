<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$watermarked_image = get_text_watermarked_image( $product->get_image_id(), "ID: {$product->get_id()}" );

$watermarked_image_size = getimagesize( $watermarked_image );

?>
<div class="single-image-display__area bg-gray text-center <?= $watermarked_image_size[0] > $watermarked_image_size[1] ? 'landscape-photography' : 'portrait-photography' ?>">
    <figure class="lg-popup">
		<a href="<?php echo $watermarked_image ?>" data-rel="lightcase"  data-lc-options='{"maxWidth":440, "maxHeight":550}' >
			<img src="<?php echo $watermarked_image ?>" alt="<?= esc_attr( $product->get_title() ) ?>">
		</a>
        
    </figure>
</div>
