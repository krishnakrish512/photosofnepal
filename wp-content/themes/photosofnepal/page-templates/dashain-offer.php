<?php
/*
Template Name: Dashain Offer
*/

get_header();
while (have_posts()):
    the_post();

    $query_product_id = get_query_var('product_id');

    if (!$query_product_id):
        $offer_photographs = get_field('photographs');
        ?>
        <main class="main section-spacing">
            <div class="container-fluid">
                <div class="infiniteScroll-gallery justified-gallery discover-photos__grid ">
                    <?php

                    foreach ($offer_photographs as $photograph_id):
                        $product_id = get_post_meta($photograph_id, 'photography_product_id', true);
                        $product = wc_get_product($product_id);
                        ?>
                        <div class="discover-photos__grid-item">
                            <img src="<?= wp_get_attachment_image_url($photograph_id, 'photography_thumbnail') ?>"
                                 alt="<?= $product->get_title() ?>"/>
                            <figcaption>
                                <div class="figure-tools">
                                    <div class="figure-icons">
                                        <?php echo do_shortcode("[ti_wishlists_addtowishlist product_id='" . $product->get_id() . "']"); ?>
                                    </div>
                                </div>

                                <div class="figure-info ">
                                    <h6 class="font-weight-light mb-0"><?= $product->get_title() ?></h6>
                                    <a href="<?= esc_url($product->get_permalink()) ?>"
                                       class="btn btn-primary btn-sm">Buy</a>
                                </div>
                            </figcaption>
                            <a href="<?= get_page_link() . $product_id ?>" class="stretched-link"></a>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </main>
    <?php
    else:

    endif;
endwhile;

get_footer();