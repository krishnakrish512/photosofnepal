<?php
$args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => get_sub_field('number_of_photographs')
];

$photograph_query = new WP_Query($args);
?>
<section class="discover-photos section-spacing">
    <div class="container">
        <div class="section-title text-center section-spacing">
            <h4 class="text-capitalize"><?php the_sub_field('heading'); ?></h4>
            <p class="lead"><?php the_sub_field('sub_heading'); ?></p>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="discover-photos__grid justified-gallery" id="photography-html">
            <?php
            while ($photograph_query->have_posts()):
                $photograph_query->the_post();

                $photograph = wc_get_product(get_the_ID());
                $photograph_image_id = $photograph->get_image_id();

                //get album post in which photographs(gallery) field consists of photograph image
                $args = [
                    'post_type' => 'gallery',
                    'post_status' => 'publish',
                    'meta_query' => [
                        [
                            'key' => 'photographs',
                            'value' => $photograph_image_id,
                            'compare' => 'LIKE'
                        ]
                    ],
                ];

                $gallery = get_posts($args);
                if (!empty($gallery)) {
                    $gallery_url = get_permalink($gallery[0]);
//					var_dump($gallery_url);
//					exit();
                }
                ?>
                <div class="discover-photos__grid-item">
                    <img src="<?= wp_get_attachment_image_url($photograph_image_id, 'photography_thumbnail') ?>"
                         alt="<?= $photograph->get_title() ?>"/>
                    <figcaption>
                        <div class="figure-tools">
                            <div class="figure-icons">
                                <?php echo do_shortcode("[ti_wishlists_addtowishlist product_id='" . $photograph->get_id() . "']"); ?>
                                <?php
                                if (!empty($gallery)):
                                    ?>
                                    <a href="<?= esc_url($gallery_url) ?>"> <span class="icon-stack"></span></a>
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>

                        <div class="figure-info">
                            <h6 class="font-weight-light"><?= $photograph->get_title() ?></h6>
                            <a href="<?= esc_url($photograph->get_permalink()) ?>"
                               class="btn btn-primary btn-sm">Buy</a>
                        </div>
                    </figcaption>
                    <a href="<?= esc_url($photograph->get_permalink()); ?>" class="stretched-link"></a>
                </div>
            <?php
            endwhile;

            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" class="popup-form" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Sign Up</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="sign-up-form">
                    <div class="form-group">
                        <label> Email</label>
                        <input type="text" class="form-control" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <label> Password</label>
                        <input type="password" class="form-control" placeholder="password">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Continue" class="btn btn-primary d-block w-100">
                    </div>
                </form>
                <p class="mb-4">By creating an account, I agree to Photosofnepal's Website terms, Privacy policy and
                    Licensing terms.</p>
            </div>
            <div class="modal-footer">
                <p>Already have an account? <a href="#"> Log in</a></p>
            </div>
        </div>
    </div>
</div>