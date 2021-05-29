<?php
$featured_photo_id = get_sub_field( 'featured_photograph' );
if ( $featured_photo_id ) {
	$featured_photo          = wc_get_product( $featured_photo_id );
	$featured_photo_image_id = $featured_photo->get_image_id();
	$author_id               = get_post_field( 'post_author', $featured_photo_image_id );
}

$args = [
	'taxonomy'   => 'product_tag',
	'number'     => 5,
	'orderby'    => 'count',
	'order'      => 'DESC',
	'hide_empty' => true,
];

$popular_tags = get_terms( $args );
?>
<section class="search-hero text-center text-white">
    <div class="search-hero__img has-overlay">
		<?php
		if ( $featured_photo_id ):
			?>
            <img src="<?= wp_get_attachment_image_url( $featured_photo_image_id, 'photography_medium' ) ?>"
                 alt="<?= $featured_photo->get_title() ?>">
		<?php endif; ?>
    </div>

    <div class="search-hero__content sticky-search-bar">
        <h1 class="search-hero__title"><?php the_sub_field( 'heading' ); ?></h1>
        <div class="search-hero__form">
            <form action="<?= get_home_url() ?>" class="">
                <input type="text" name="s" id="s" class="form-control" placeholder="Search photos"/>
                <input type="hidden" name="post_type" value="product">
                <!--            <input type="hidden" name="author" value="1"/>-->
                <span><i class="icon-search"></i></span>
            </form>
        </div>

        <p class="search-hero__trending">
            Trending:
			<?php
			foreach ( $popular_tags as $tag ):
				?>
                <a href="<?= esc_url( get_term_link( $tag->term_id ) ) ?>"><?= $tag->name ?></a>
			<?php
			endforeach;
			?>
        </p>
    </div>
    <div class="search-hero__image-info">
        <div class="container-fluid">
            <p class="mb-0">
				<?php
				if ( $featured_photo_id ):
					$sold_by = WC_Product_Vendors_Utils::get_sold_by_link( $featured_photo->get_id() );
					?>
                    <a class="text-white"
                       href="<?= $featured_photo->get_permalink() ?>  "><?= $featured_photo->get_title() ?></a>
                    by <a class="text-white"
                          href="<?= esc_url( $sold_by['link'] ) ?>"><?= getProductVendorUsername( $featured_photo->get_id() ) ?></a>
				<?php endif; ?>
            </p>
        </div>
    </div>
</section>