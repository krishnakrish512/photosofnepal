<?php
/**
 * Template Name: Collections Listing
 */

get_header();


$args = [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'orderby'    => 'count',
	'order'      => 'DESC'
];

$collections = get_terms( $args );
?>
    <section class="search-hero text-center text-white search-hero__inner section-spacing">
        <div class="search-hero__content sticky-search-bar">
            <div class="search-hero__form">
                <form action="<?= get_home_url() ?>" class="">
                    <input type="text" name="s" id="s" class="form-control" placeholder="Search photos">
                    <input type="hidden" name="post_type" value="product">
                    <span><i class="icon-search"></i></span>
                </form>
            </div>
        </div>
    </section>
    <main class="main section-spacing">
        <div class="discover-collection">
            <div class="container-fluid">
                <div class="row">
					<?php
					foreach ( $collections as $collection ):
						$thumbnail_id = get_term_meta( $collection->term_id, 'thumbnail_id', true )
						?>
                        <div class="col-sm-6 col-md-6 col-lg-4 ">
                            <div class="card border-0 mb-3">
                                <a href="<?= get_term_link( $collection->term_id ) ?>" class="card-image d-block">
                                    <img src="<?= wp_get_attachment_image_url( $thumbnail_id, 'photography_thumbnail' ) ?>"
                                         class="card-img-top" alt="<?= $collection->name ?>">
                                </a>
                                <div class="card-body">
                                    <a href="<?= get_term_link( $collection->term_id ) ?>"
                                       class="card-title h5"><?= $collection->name ?></a>
                                    <p class="card-text"><?= $collection->count ?> Photos</p>
                                </div>
                            </div>
                        </div>
					<?php
					endforeach;
					?>
                </div>
            </div>
        </div>
    </main>
<?php

get_footer();