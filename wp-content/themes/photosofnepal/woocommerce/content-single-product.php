<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.

	return;
}

//echo "<pre>";
//print_r( get_userdata( get_the_author_meta( 'ID' ) ) );
//echo "</pre>";
//exit;
?>
<section
        id="product-<?php the_ID(); ?>" <?php wc_product_class( 'search-hero text-center text-white search-hero__inner section-spacing', $product ); ?>>
    <div class="search-hero__content">
        <h1 class="search-hero__title">Moving the world with images</h1>
        <div class="search-hero__form">
            <form action="<?= get_home_url() ?>" class="">
                <input type="text" name="s" id="s" class="form-control" placeholder="Search photos">
                <input type="hidden" name="post_type" value="product">
                <span><i class="icon-search"></i></span>
            </form>
        </div>

        <p class="search-hero__trending">Trending: Flowers, Wallpapers, Background</p>
    </div>
</section>
<main class="main">
    <section class="section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="single-image-display">
						<?php woocommerce_show_product_images(); ?>
                    </div>
                    <div class="single-image-display__info">
                        <p class="image__id mb-2">ID: <?= $product->get_sku() ?></p>
                        <div class="d-lg-flex justify-content-between align-items-center mb-5 mb-lg-0">
                            <div class="single-image-display__info-left pr-lg-5 mb-4 mb-lg-0">

                                <h1 class="h6"><?php woocommerce_template_single_title(); ?></h1>
								<?php the_content(); ?>
                            </div>
                            <div class="single-image-display__info-right pl-lg-5">
                                <div class="profile__share d-lg-flex justify-content-end">
									<?php photography_single_product_sharing(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="single-image-download__area">
                        <div class="single-image-download__area-box single-image-display__header d-flex align-items-center justify-content-between">
                            <div class="media">
                                <div class="media-image mr-4">
									<?= get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
                                </div>
                                <div class="media-body">
									<?php
									$sold_by = WC_Product_Vendors_Utils::get_sold_by_link( $post->ID );


									?>
                                    <h5 class="mb-0"><?= get_the_author() ?></h5>
                                    <a href="<?= esc_url( $sold_by['link'] ) ?>"><?= '@' . getProductVendorUsername( $post->ID ) ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="single-image-download__actions single-image-download__area-box">
                            <h5 class="mb-0">Purchase a License</h5>
                            <span>select size/format</span>
							<?php woocommerce_template_single_add_to_cart(); ?>
							<?php /*photography_variations_display( $product ); */ ?>

                            <!--<div class="single-image-download__btn">
                                <a href="#" class="d-block btn btn-primary mb-4"> Download Now</a>
                                <a href="#" class="d-block btn btn-outline"> Add to Cart</a>
                            </div>-->
                            <div class="inf-badge">
                                Editorial use only
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<?php
	//	var_dump( $product->get_image_id() );
	$args = [
		'post_type'   => 'gallery',
		'post_status' => 'publish',
		'meta_query'  => [
			[
				'key'     => 'photographs',
				'value'   => $product->get_image_id(),
				'compare' => 'LIKE'
			]
		]
	];

	$gallery_posts = get_posts( $args );

	//	echo "<pre>";
	//	print_r( $gallery_posts );
	//	echo "</pre>";
	//
	//	var_dump( count( $gallery_posts ) );

	if ( ! empty( $gallery_posts ) ):
		$gallery = $gallery_posts[0];

		$gallery_photos = get_field( 'photographs', $gallery->ID );

		//remove current photograph from gallery images list
		$current_photograph_key = array_search( $product->get_image_id(), $gallery_photos );
		unset( $gallery_photos[ $current_photograph_key ] );

		if ( count( $gallery_photos ) >= 1 ):
			?>
            <section class="section-spacing same-series">
                <div class="container">
                    <h2 class="mb-4">Same Galleries</h2>
                    <div class="row discover-photos__grid gutter-md justify-content-center">
                        <div class="col-lg-10">
                            <div class="row gutter-md column-5 justify-content-center justify-content-lg-start">
								<?php
								//display five random photos from gallery_photos
								$rand_photos = [];
								if ( count( $gallery_photos ) == 1 ) {
									$rand_photos = [ array_key_first( $gallery_photos ) ];
								} else {
									$rand_elem_count = count( $gallery_photos ) <= 5 ? count( $gallery_photos ) : 5;
									$rand_photos     = array_rand( $gallery_photos, $rand_elem_count );
								}

								foreach ( $rand_photos as $key ):
									$photography_product_id = get_post_meta( $gallery_photos[ $key ], 'photography_product_id', true );
									if ( $photography_product_id ):
										$photography_product = wc_get_product( $photography_product_id );
										?>
                                        <div class="col-lg-3 column mb-4 mb-lg-0">
                                            <div class="discover-photos__grid-item grid-item--sm position-relative">
                                                <figure class="aspect-ratio mb-0">
                                                    <img src="<?= wp_get_attachment_image_url( $gallery_photos[ $key ], 'gallery_thumbnail' ) ?>"
                                                         alt="<?= $photography_product->get_title() ?>">
                                                </figure>

                                                <figcaption>
                                                    <div class="figure-tools">
                                                        <div class="figure-icons">
															<?php echo do_shortcode( "[ti_wishlists_addtowishlist product_id='" . $photography_product->get_id() . "']" ); ?>
                                                            <!-- <a href="#"> <span class="icon-shopping-cart"></span></a> -->
                                                            <a href="<?= esc_url( get_permalink( $gallery ) ) ?>"> <span
                                                                        class="icon-stack"></span></a>
                                                        </div>
                                                    </div>

                                                    <div class="figure-info">
                                                        <a href="<?= get_photogtaphy_buy_url( $photography_product ) ?>"
                                                           class="btn btn-primary btn-sm">Buy</a>
                                                    </div>
                                                </figcaption>
                                                <a href="<?= esc_url( $photography_product->get_permalink() ) ?>"
                                                   class="stretched-link"></a>
                                            </div>

                                        </div>
									<?php
									endif;
								endforeach;
								?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <a href="<?= esc_url( get_permalink( $gallery ) ) ?>"
                               class="thumb-link ">
                                <div class="thumb-link--inner text-center">
                                    <span class="icon-layers"></span>
                                    See More
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </section>
		<?php
		endif;
	endif;
	?>

	<?php woocommerce_output_related_products(); ?>

	<?php
	$product_tags = get_the_terms( $product->get_id(), 'product_tag' );
	if ( $product_tags ):
		?>
        <section class="section-spacing keyword">
            <div class="container">
                <h4 class="mb-4">Related Tags</h4>
                <div class="keywords">
					<?php
					foreach ( $product_tags as $product_tag ) {
						echo "<a href='" . get_term_link( $product_tag->term_id ) . "' class='btn btn-outline btn-sm mb-3' rel='tag'>$product_tag->name</a>";
					}
					?>
                </div>
            </div>
        </section>
	<?php
	endif;
	?>

    <!--    <div class="summary entry-summary">-->
	<?php
	/**
	 * Hook: woocommerce_single_product_summary.
	 *
	 * @hooked woocommerce_template_single_title - 5
	 * @hooked woocommerce_template_single_rating - 10
	 * @hooked woocommerce_template_single_price - 10
	 * @hooked woocommerce_template_single_excerpt - 20
	 * @hooked woocommerce_template_single_add_to_cart - 30
	 * @hooked woocommerce_template_single_meta - 40
	 * @hooked woocommerce_template_single_sharing - 50
	 * @hooked WC_Structured_Data::generate_product_data() - 60
	 */
	//		do_action( 'woocommerce_single_product_summary' );
	?>
    <!--    </div>-->

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//	do_action( 'woocommerce_after_single_product_summary' );
	?>
</main>
<?php do_action( 'woocommerce_after_single_product' ); ?>
