<?php
get_header();

while (have_posts()):
    the_post();

    $image = getResizedImage(get_the_post_thumbnail_url(get_the_ID(), 'full'), [1920, 800]);

    global $post;
    ?>
    <style>
        #background-thumbnail {
            background-image: url(<?=esc_url($image['orig'])?>);
        }

        .no-webp #background-thumbnail {
            background-image: url(<?=esc_url($image['orig']);?>);
        }

        .webp #background-thumbnail {
            background-image: url(<?=esc_url($image['webp'])?>);
        }
    </style>
    <section class="blog-page-title section-spacing full-image bg-cover" id="background-thumbnail">
        <div class="container text-center">
            <h1 class="text-white mb-4"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <span class="enty-meta--auther"><?= get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name') ?></span>
                | <span
                        class="enty-meta--date"><?= get_the_date('F j, Y') ?></span>
            </div>
        </div>
    </section>
    <main class="main section-spacing single-blog-content">
        <div class="container">
            <div class="share-blog">
                <?php post_single_sharing(); ?>
            </div>
            <?php
            if (get_field('excerpt')):
                ?>
                <p class="lead"><?= get_field('excerpt') ?></p>
            <?php
            endif;

            the_content();
            ?>
        </div>

    </main>
    <?php
    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()]
    ];

    $other_posts_query = new WP_Query($args);
    ?>
    <section class="main section-spacing">
        <div class="container">
            <div class="row">
                <?php
                while ($other_posts_query->have_posts()):
                    $other_posts_query->the_post();
                    global $post;
                    ?>
                    <div class="col-lg-4">
                        <div class="card border-0 mb-3 blog-card">
                            <a href="<?php the_permalink(); ?>" class="card-image d-block">
                                <?php
                                $thumbnail_id = get_post_thumbnail_id();
                                $image = getResizedImage(get_the_post_thumbnail_url(get_the_ID(), 'full'), [400, 260]);
                                echo \NextGenImage\getWebPHTML($image['webp'], $image['orig'], [
                                    'class' => "card-img-top",
                                    'alt' => wp_get_attachment_caption($thumbnail_id) ? esc_attr(wp_get_attachment_caption($thumbnail_id)) : esc_attr(get_the_title($thumbnail_id))
                                ]);
                                ?>
                            </a>
                            <div class="card-body">
                                <div class="entry-meta d-none">
                                    <a href="<?= esc_url(get_author_posts_url($post->post_author)) ?>"
                                       class="entry-meta--auther"><?= get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name') ?></a>
                                    |
                                    <span class="entry-meta--date"><?= get_the_date('F j, Y') ?></span>
                                </div>
                                <a href="<?php the_permalink(); ?>"
                                   class="card-title h5 entry-title"><?php the_title(); ?></a>

                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();