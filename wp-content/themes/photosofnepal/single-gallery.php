<?php
get_header();
?>
    <section class="search-hero text-center text-white search-hero__inner section-spacing mb-5">
        <div class="search-hero__content sticky-search-bar">
            <h1 class="search-hero__title">Moving the world with images</h1>
            <div class="search-hero__form input-style">

                <form action="<?= get_home_url() ?>" class="">
                    <input type="text" name="s" id="s" class="form-control" placeholder="Search photos"/>
                    <input type="hidden" name="post_type" value="product">
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
    <main class="main section-spacing">
        <div class="container-fluid">
            <div class="infiniteScroll-gallery justified-gallery discover-photos__grid ">
                <?php
                while (have_posts()):
                    the_post();
                    $album_images = get_field('photographs');

                    foreach ($album_images as $image):
                        $photography_product_id = get_post_meta($image, 'photography_product_id', true);
                        if ($photography_product_id):
                            $product = wc_get_product($photography_product_id);
                            ?>
                            <div class="discover-photos__grid-item">
                                <?php
                                $image_id = $product->get_image_id();
                                ?>
                                <img src="<?= wp_get_attachment_image_url($image_id, 'photography_thumbnail') ?>"
                                     alt="<?= $product->get_title() ?>"/>
                                <figcaption>
                                    <div class="figure-tools">
                                        <div class="figure-icons">
                                            <?php echo do_shortcode("[ti_wishlists_addtowishlist product_id='" . $product->get_id() . "']"); ?>
                                            <!-- <a href="#"> <span class="icon-shopping-cart"></span></a> -->
                                            <!--                                            <a href="#"> <span class="icon-stack"></span></a>-->
                                        </div>
                                    </div>

                                    <div class="figure-info ">
                                        <h6 class="font-weight-light mb-0"><?= $product->get_title() ?></h6>
                                        <a href="<?= esc_url($product->get_permalink()) ?>"
                                           class="btn btn-primary btn-sm">Buy</a>
                                    </div>
                                </figcaption>
                                <a href="<?= $product->get_permalink() ?>" class="stretched-link"></a>
                            </div>
                        <?php
                        endif;
                    endforeach;
                endwhile;

                ?>
            </div>
        </div>
    </main>
<?php
get_footer();