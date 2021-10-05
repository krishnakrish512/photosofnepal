<?php
$photo_ids = get_sub_field('photographs');
?>
<section class="discover-photos section-spacing">
    <div class="container">
        <div class="section-title text-center section-spacing">
            <h4 class="text-capitalize"><?php the_sub_field('heading'); ?></h4>
            <p class="lead"><?php the_sub_field('sub_heading'); ?></p>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="discover-photos__grid justified-gallery">
            <?php
            foreach ($photo_ids as $photo_id):
                $photograph = wc_get_product($photo_id);
                $photograph_image_id = $photograph->get_image_id();

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
            endforeach;
            ?>
        </div>
    </div>
</section>