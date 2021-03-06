<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>
    <header class="woocommerce-products-header">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php // woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        //do_action( 'woocommerce_archive_description' );
        ?>
    </header>

    <section class="search-hero text-center text-white search-hero__inner section-spacing mb-5">
        <div class="search-hero__content sticky-search-bar">
            <h1 class="search-hero__title">Moving the world with images</h1>
            <div class="search-hero__form  input-style">
                <?php
                if (isset($_GET['author'])):
                    ?>
                    <span class="badge mr-2 font-weight-normal text-dark" id="portfolio-button">Portfolio <i
                                class="fas fa-times ml-3"></i></span>
                <?php
                endif;
                ?>
                <form action="<?= get_home_url() ?>" class="">
                    <input type="text" name="s" id="s" class="form-control photography-product-search"
                           placeholder="Search photos"/>
                    <input type="hidden" name="post_type" value="product">
                    <?php
                    if (isset($_GET['author'])):
                        ?>
                        <input type="hidden" name="author" value="<?= $_GET['author'] ?>"/>
                    <?php
                    endif;
                    ?>
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
<?php
if (woocommerce_product_loop()) {

    /**
     * Hook: woocommerce_before_shop_loop.
     *
     * @hooked woocommerce_output_all_notices - 10
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
//	do_action( 'woocommerce_before_shop_loop' );

    woocommerce_product_loop_start();

    if (wc_get_loop_prop('total')) {
        while (have_posts()) {
            the_post();

            /**
             * Hook: woocommerce_shop_loop.
             */
            do_action('woocommerce_shop_loop');

            wc_get_template_part('content', 'product');
        }
    }

    woocommerce_product_loop_end();

    /**
     * Hook: woocommerce_after_shop_loop.
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action('woocommerce_after_shop_loop');
} else {
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

get_footer('shop');
