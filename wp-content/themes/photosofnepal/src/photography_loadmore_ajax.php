<?php

function photography_loadmore_ajax_handler() {
//	var_dump( $_POST );
//	exit;
	// prepare our arguments for the query
	$args                = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
//
//	var_dump( $args );
//	exit;

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if ( have_posts() ) :

		// run the loop
		while ( have_posts() ): the_post();
			$photograph = wc_get_product( get_the_ID() );

			$photograph_image_id = $photograph->get_image_id();
			?>
            <div class="discover-photos__grid-item">
                <!--                <figure>-->
                <img src="<?= wp_get_attachment_image_url( $photograph_image_id, 'photography_medium' ) ?>"
                     alt="">
                <figcaption>
                    <div class="figure-icons">
                        <a href="#"> <span class="icon-heart-o"></span></a>
                        <a href="#"> <span class="icon-shopping-cart"></span></a>
                        <a href="#"> <span class="icon-stack"></span></a>
                    </div>
                    <div class="figure-info">
                        <h6 class="font-weight-light"><?= $photograph->get_title() ?></h6>
                    </div>
                </figcaption>
                <a href="<?= esc_url( $photograph->get_permalink() ); ?>"
                   class="stretched-link"></a>
                <!--                </figure>-->
            </div>
		<?php
		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}


add_action( 'wp_ajax_nopriv_photography_loadmore', 'photography_loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}
add_action( 'wp_ajax_photography_loadmore', 'photography_loadmore_ajax_handler' ); // wp_ajax_{action}
