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
?>
<?php
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
?>
<?php
$paged               = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$search_result_query = new WP_Query( array( 'post_type' => 'any', 'post__in' => $matched_posts, 'paged' => $paged ) );
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
get_footer();