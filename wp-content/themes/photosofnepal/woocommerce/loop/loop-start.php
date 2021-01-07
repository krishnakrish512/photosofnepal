<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!--<ul class="products columns---><?php //echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?><!--">-->
<main class="main section-spacing">
    <div class="container-fluid">
		<?php
		global $wp_query;

		$term = $wp_query->queried_object;
		if ( is_tax( WC_PRODUCT_VENDORS_TAXONOMY, $term->term_id ) ):
//			global $wp_query;
			$tax_post_count = $wp_query->found_posts;

			$vendor_data = get_term_meta( $term->term_id, 'vendor_data', true );


//			echo "<pre>";
//			print_r( $vendor_data );
//			echo "</pre>";
//			exit;
			?>
            <section class="profile mb-5">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="profile__info text-center">
                            <h4 class="profile__info-name"><?= $vendor_data['name'] ?></h4>
                            <p class="font-weight-light"><?= $vendor_data['count'] ?> Images </p>
                        </div>
                    </div>
                </div>
            </section>
		<?php
		endif;
		?>
        <div class="infiniteScroll-gallery justified-gallery discover-photos__grid ">