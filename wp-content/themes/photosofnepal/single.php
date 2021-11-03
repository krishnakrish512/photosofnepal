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
endwhile;
get_footer();