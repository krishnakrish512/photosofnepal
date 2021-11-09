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

                        if ($product_id):
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
                                        <a href="<?= get_page_link() . $product_id ?>"
                                           class="btn btn-primary btn-sm">Download</a>
                                    </div>
                                </figcaption>
                                <a href="<?= get_page_link() . $product_id ?>" class="stretched-link"></a>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </main>
    <?php
    else:
        $product_id = $query_product_id;
        $product = wc_get_product($product_id);
        ?>
        <section
                id="product-<?php the_ID(); ?>" <?php wc_product_class('search-hero text-center text-white search-hero__inner section-spacing', $product); ?>>
            <div class="search-hero__content">
                <h1 class="search-hero__title">Moving the world with images</h1>
                <div class="search-hero__form">
                    <form action="<?= get_home_url() ?>" class="">
                        <input type="text" name="s" id="s" class="form-control" placeholder="Search photos">
                        <input type="hidden" name="post_type" value="product">
                        <button><i class="icon-search"></i></button>
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

                                        <h1 class="h6"><?= $product->get_title() ?></h1>
                                        <?php $product->get_description() ?>
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

                                <div class="single-image-download__actions single-image-download__area-box position-relative">
                                    <div class="single-image-download__btn">
                                        <?php
                                        if (is_user_logged_in()):
                                            ?>
                                            <a href="<?= esc_url(get_the_post_thumbnail_url($product_id, 'photography_medium')) ?>"
                                               download="" class="d-block btn btn-primary mb-4"> Download Now</a>
                                        <?php
                                        else:
                                            ?>
                                            <a href="<?= wc_get_page_permalink('myaccount') ?>"
                                               class="d-block btn btn-primary mb-4"> Download Now</a>
                                        <?php
                                        endif;
                                        ?>
                                        <a href="<?= esc_url(get_permalink($product_id)) ?>"
                                           class="d-block btn btn-outline">Buy Full Size</a>
                                    </div>
                                </div>
                                <div class="single-image-download__area-box single-image-display__header d-flex align-items-center justify-content-between">
                                    <div class="media position-relative">
                                        <div class="media-image mr-4">
                                            <?php
                                            $author_id = get_post_field('post_author', $product_id);
                                            ?>
                                            <?= get_avatar($author_id, 120); ?>
                                        </div>
                                        <div class="media-body">
                                            <?php
                                            $sold_by = WC_Product_Vendors_Utils::get_sold_by_link($product_id);
                                            ?>
                                            <h5 class="mb-0"><?= get_the_author() ?></h5>
                                            <a href="javascript:void(0)"><?= '@' . getProductVendorUsername($product_id) ?></a>
                                        </div>
                                        <a href="<?= esc_url($sold_by['link']) ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            $args = [
                'post_type' => 'gallery',
                'post_status' => 'publish',
                'meta_query' => [
                    [
                        'key' => 'photographs',
                        'value' => $product->get_image_id(),
                        'compare' => 'LIKE'
                    ]
                ]
            ];

            $gallery_posts = get_posts($args);

            if (!empty($gallery_posts)):
                $gallery = $gallery_posts[0];

                $gallery_photos = get_field('photographs', $gallery->ID);

                //remove current photograph from gallery images list
                $current_photograph_key = array_search($product->get_image_id(), $gallery_photos);
                unset($gallery_photos[$current_photograph_key]);

                if (count($gallery_photos) >= 1):
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
                                        if (count($gallery_photos) == 1) {
                                            $rand_photos = [array_key_first($gallery_photos)];
                                        } else {
                                            $rand_elem_count = count($gallery_photos) <= 5 ? count($gallery_photos) : 5;
                                            $rand_photos = array_rand($gallery_photos, $rand_elem_count);
                                        }

                                        foreach ($rand_photos as $key):
                                            $photography_product_id = get_post_meta($gallery_photos[$key], 'photography_product_id', true);
                                            if ($photography_product_id):
                                                $photography_product = wc_get_product($photography_product_id);
                                                if ($photography_product):
                                                    ?>
                                                    <div class="col-lg-3 column mb-4 mb-lg-0">
                                                        <div class="discover-photos__grid-item grid-item--sm position-relative">
                                                            <figure class="aspect-ratio mb-0">
                                                                <img src="<?= wp_get_attachment_image_url($gallery_photos[$key], 'related_photo_thumbnail') ?>"
                                                                     alt="<?= esc_attr($photography_product->get_title()) ?>">
                                                            </figure>

                                                            <figcaption>
                                                                <div class="figure-tools">
                                                                    <div class="figure-icons">
                                                                        <?php echo do_shortcode("[ti_wishlists_addtowishlist product_id='" . $photography_product->get_id() . "']"); ?>
                                                                        <!-- <a href="#"> <span class="icon-shopping-cart"></span></a> -->
                                                                        <a href="<?= esc_url(get_permalink($gallery)) ?>"> <span
                                                                                    class="icon-stack"></span></a>
                                                                    </div>
                                                                </div>

                                                                <div class="figure-info">
                                                                    <a href="<?= esc_url($photography_product->get_permalink()) ?>"
                                                                       class="btn btn-primary btn-sm">Buy</a>
                                                                </div>
                                                            </figcaption>
                                                            <a href="<?= esc_url($photography_product->get_permalink()) ?>"
                                                               class="stretched-link"></a>
                                                        </div>

                                                    </div>
                                                <?php
                                                endif;
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <a href="<?= esc_url(get_permalink($gallery)) ?>"
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

            <!--            --><?php //woocommerce_output_related_products();
            ?>

            <?php
            $product_tags = get_the_terms($product->get_id(), 'product_tag');
            if ($product_tags):
                ?>
                <section class="section-spacing keyword">
                    <div class="container">
                        <h4 class="mb-4">Related Tags</h4>
                        <div class="keywords">
                            <?php
                            foreach ($product_tags as $product_tag) {
                                echo "<a href='" . get_term_link($product_tag->term_id) . "' class='btn btn-outline btn-sm mb-3' rel='tag'>$product_tag->name</a>";
                            }
                            ?>
                        </div>
                    </div>
                </section>
            <?php
            endif;
            ?>
        </main>
    <?php
    endif;
endwhile;

get_footer();