<?php
get_header();

$search = get_search_query();

$all_product_tags = get_terms( array( 'taxonomy' => 'product_tag', 'hide_empty' => true ) );

$matching_product_tags = [];

foreach ( $all_product_tags as $all ) {
	$par = $all->name;
	if ( stripos( $par, $search ) !== false ) {
		array_push( $matching_product_tags, $all->term_id );
	}
}

$matched_posts = [];
$args1         = [
	'post_status'    => 'publish',
	'posts_per_page' => - 1,
	'tax_query'      => [
		'relation' => 'OR',
		[
			'taxonomy' => 'product_tag',
			'field'    => 'term_id',
			'terms'    => $matching_product_tags
		]
	]
];

$the_query = new WP_Query( $args1 );
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		array_push( $matched_posts, get_the_id() );
	}
	wp_reset_postdata();
}


// now we will do the normal wordpress search
$query2 = new WP_Query( [ 's' => $search, 'post_type' => 'product', 'posts_per_page' => - 1 ] );
if ( $query2->have_posts() ) {
	while ( $query2->have_posts() ) {
		$query2->the_post();
		array_push( $matched_posts, get_the_id() );
	}
	wp_reset_postdata();
}

$matched_posts = array_unique( $matched_posts );
$matched_posts = array_values( array_filter( $matched_posts ) );

$search_result_query = null;
$limit               = 40;

if ( sizeof( $matched_posts ) > 0 ) {
	$paged               = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$search_result_query = new WP_Query( [
		'post_type' => 'product',
		'post__in'  => $matched_posts,
		'paged'     => $paged,
		'limit'     => $limit
	] );
}
?>
    <section class="search-hero text-center text-white search-hero__inner section-spacing mb-5">
        <div class="search-hero__content sticky-search-bar">
            <h1 class="search-hero__title">Moving the world with images</h1>
            <div class="search-hero__form input-style">
				<?php
				if ( isset( $_GET['author'] ) ):
					?>
                    <span class="badge mr-2 font-weight-normal text-dark" id="portfolio-button">Portfolio <i
                                class="fas fa-times ml-3"></i></span>
				<?php
				endif;
				?>
                <form action="<?= get_home_url() ?>" class="">
                    <input type="text" name="s" id="s" class="form-control" placeholder="Search photos"
                           autocomplete="off"/>
                    <input type="hidden" name="post_type" value="product">
					<?php
					if ( isset( $_GET['author'] ) ):
						?>
                        <input type="hidden" name="author" value="<?= $_GET['author'] ?>"/>
					<?php
					endif;
					?>
                    <button><i class="icon-search"></i></button>
                </form>
            </div>

            <p class="search-hero__trending">Trending: Flowers, Wallpapers, Background</p>
        </div>
        <div class="search-hero__image-info">
            <div class="container-fluid">
                <p class="mb-0">Rara Lake by John Doe</p>
                <ul class="social-links inline-list">
                    <li><a href="#"><span class="icon-facebook"></span></a></li>
                    <li><a href="#"><span class="icon-twitter"></span></a></li>
                    <li><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
            </div>
        </div>
    </section>

<?php
if ( sizeof( $matched_posts ) > 0 ) {
	?>
    <main class="main section-spacing">
        <div class="container-fluid">
            <div class="infiniteScroll-gallery justified-gallery discover-photos__grid ">
				<?php
				if ( $search_result_query->have_posts() ) {
					while ( $search_result_query->have_posts() ) {
						$search_result_query->the_post();

						wc_get_template_part( 'content', 'product' );
					}
					wp_reset_postdata();
				}
				?>
            </div>
        </div>
    </main>
	<?php


	$total = $search_result_query->max_num_pages;

	$current = max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) );
	$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
	$format  = isset( $format ) ? $format : '';

	if ( $total > 1 ) {
		$paginate_links = paginate_links( [
			'base'      => $base,
			'format'    => $format,
			'current'   => $current,
			'total'     => $total,
			'prev_text' => "<i class='fas fa-angle-left'></i>",
			'next_text' => "<i class='fas fa-angle-right'></i>",
			'type'      => 'array'
		] );
		?>
        <section class="section-spacing">
            <div class="container">
                <div class="row section-spacing">
                    <div class="col-lg-12">
                        <div class="pagination-wrap">
                            <nav aria-label="Page navigation">
                                <ul class="pagination text-center justify-content-center">
									<?php
									foreach ( $paginate_links as $paginate_link ):
										echo "<li class='page-item'>" . $paginate_link . "</li>";
									endforeach;
									?>
                                </ul>
                            </nav>
                        </div><!-- end pagination-wrap -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
            </div>
        </section>
		<?php
	}
} else {
	wc_no_products_found();
}

get_footer();