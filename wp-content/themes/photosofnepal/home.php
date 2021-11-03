<?php
get_header();
?>
    <section class="blog-page-title section-spacing">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h3>Blog</h3>
                </div>
                <div class="col-lg-5">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <main class="main section-spacing">
        <div class="container">
            <div class="row">
                <?php
                while (have_posts()):
                    the_post();
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

                ?>
            </div>
        </div>

        <?php
        global $wp_query;

        $total_pages = $wp_query->max_num_pages;
        $current_page = max(1, get_query_var('paged'));

        $big = 999999999; // need an unlikely integer

        $paginate_links = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => "<i class='fas fa-angle-left'></i>",
            'next_text' => "<i class='fas fa-angle-right'></i>",
            'type' => 'array'
        ]);
        ?>
        <section class="section-spacing">
            <div class="container">
                <div class="row section-spacing">
                    <div class="col-lg-12">
                        <div class="pagination-wrap">
                            <nav aria-label="Page navigation">
                                <ul class="pagination text-center justify-content-center">
                                    <?php
                                    foreach ($paginate_links as $paginate_link):
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

    </main>
<?php

get_footer();