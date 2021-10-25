<?php
$featured_photo_id = get_sub_field('featured_photograph');
if ($featured_photo_id) {
    $featured_photo = wc_get_product($featured_photo_id);
    $featured_photo_image_id = $featured_photo->get_image_id();
    $author_id = get_post_field('post_author', $featured_photo_image_id);
}

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 20,
    'orderby' => 'date',
    'order' => 'DESC',
);

$latest_posts = new WP_Query($args);

$temp_ids = [];

while ($latest_posts->have_posts()) :
    $latest_posts->the_post();
    $product_tags = wp_get_post_terms(get_the_id(), 'product_tag');

    if ($product_tags) {
        foreach ($product_tags as $product_tag) {
            $temp_ids[] = $product_tag->term_id;
        }
    }
endwhile;
wp_reset_query();

$sorted_terms = array_count_values($temp_ids);
?>
<section class="search-hero text-center text-white">
    <div class="search-hero__img has-overlay">
        <?php
        if ($featured_photo_id):
            $image_url = wp_get_attachment_image_url($featured_photo_image_id, 'full');
            $image = getResizedImage($image_url, [1600, 800]);
            echo \NextGenImage\getWebPHTML($image['webp'], $image['orig'], [
                'alt' => esc_attr($featured_photo->get_title())
            ]);
            ?>
        <?php endif; ?>
    </div>

    <div class="search-hero__content sticky-search-bar">
        <h1 class="search-hero__title"><?php the_sub_field('heading'); ?></h1>
        <div class="search-hero__form">
            <form action="<?= get_home_url() ?>" class="photography-product-search-form">
                <input type="text" name="s" id="s" class="form-control photography-product-search"
                       placeholder="Search photos" autocomplete="off"/>
                <input type="hidden" name="post_type" value="product">
                <!--            <input type="hidden" name="author" value="1"/>-->
                <button>
                    <i class="icon-search"></i>
                </button>

            </form>
        </div>

        <p class="search-hero__trending" data-sorted-count="<?= count($sorted_terms) ?>">
            Trending:
            <?php
            $temp_count = 1;
            foreach ($sorted_terms as $term_id => $count):
                if ($temp_count > 5) break;

                $term = get_term($term_id);
                ?>
                <a href="<?= esc_url(get_term_link($term_id)) ?>"><?= $term->name ?></a>
                <?php
                $temp_count = $temp_count + 1;
            endforeach;
            ?>
        </p>
        
    </div>
    <div class="search-hero__image-info text-left test">
        <div class="container">
            <p class="mb-0">
                <?php
                if ($featured_photo_id):
                    $sold_by = WC_Product_Vendors_Utils::get_sold_by_link($featured_photo->get_id());
                    ?>
                    <a class="text-white"
                       href="<?= $featured_photo->get_permalink() ?>  "><?= $featured_photo->get_title() ?></a>
                    by <a class="text-white font-italic text-capitalize name"
                          href="<?= esc_url($sold_by['link']) ?>"><?= getProductVendorUsername($featured_photo->get_id()) ?></a>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="fireworks-container">
            <div class="demo">
        </div>
    </div>
    <!-- <div class="kites">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 76.5 173.8" style="enable-background:new 0 0 76.5 173.8;" xml:space="preserve">
<polygon style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" points="56.9,138.7 55,143.3 48.7,141.7 48,142.7 55.6,145.7 
	56.3,145.5 59.3,139.5 "/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#4F0000;" d="M56.8,127.9c0,2.4,1.6,5.8,1.5,9l10.7-0.1
	c-0.1-3.2,1.6-6.6,1.5-8.9C70.3,118.1,57,118.1,56.8,127.9z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M59.8,125.6h4.6v-1.4l0.4,0.8l0.3-0.6l0.6,1.2h1.7v4.1
	c0,1.7-1.1,3.1-2.6,3.6v1.4c1.9,0.2,3.5,0.9,4.2,1.9h-4.2h-2.4h-4.1c0.7-0.9,2.2-1.6,4.1-1.9v-1.4c-1.6-0.5-2.7-1.9-2.7-3.6V125.6z"
	/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#D2A92D;" d="M69.6,135.2c0.5,0.6,0.8,1.3,0.8,2.1v2.9L59.2,141l-3-1.6
	l1.3-3.9l0.7-0.4H69.6z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#F48120;" d="M69.6,135.2c0.5,0.6,0.8,1.3,0.8,2.1v2.9h-6.8v-5H69.6z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M57.8,124.3c-0.5,0.6-1.2,1.1-1.7,0.4c-0.4-0.7,0.5-1.1,1.2-1.2
	c-0.8-0.2-1.6-0.5-1.2-1.2c0.5-0.7,1.2-0.1,1.7,0.4c-0.2-0.7-0.4-1.6,0.5-1.7c0.8,0,0.7,0.9,0.5,1.7c0.5-0.6,1.2-1.1,1.7-0.4
	c0.4,0.7-0.5,1.1-1.2,1.2c0.8,0.2,1.6,0.5,1.2,1.2c-0.5,0.7-1.2,0.1-1.7-0.4c0.2,0.7,0.4,1.6-0.5,1.7
	C57.4,126,57.6,125.1,57.8,124.3z"/>
<circle style="fill-rule:evenodd;clip-rule:evenodd;fill:#231F20;" cx="61.9" cy="128.7" r="0.6"/>
<circle style="fill-rule:evenodd;clip-rule:evenodd;fill:#231F20;" cx="65.3" cy="128.7" r="0.6"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#231F20;" d="M62.7,131.4h2.1C64.7,132.5,62.7,132.5,62.7,131.4z"/>
<rect x="59.2" y="135" style="fill-rule:evenodd;clip-rule:evenodd;fill:#00386D;" width="1.4" height="9.4"/>
<rect x="67" y="135" style="fill-rule:evenodd;clip-rule:evenodd;fill:#00386D;" width="1.4" height="9.4"/>
<rect x="59.2" y="139.7" style="fill-rule:evenodd;clip-rule:evenodd;fill:#00386D;" width="9.3" height="13.5"/>
<polygon style="fill-rule:evenodd;clip-rule:evenodd;fill:#345986;" points="59.2,159.1 62.6,159.1 63.8,157.1 65.2,159.1 
	68.5,159.1 68.5,153.2 59.2,153.2 "/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M47.8,141.4l0.2-0.4l0.8,0.4c0.1,0.1,0.2,0.2,0.1,0.3l0,0
	c-0.1,0.1-0.2,0.2-0.3,0.1L47.8,141.4z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M47.8,142.2l0.2-0.4l0.8,0.4c0.1,0.1,0.2,0.2,0.1,0.3v0
	c-0.1,0.1-0.2,0.2-0.3,0.1L47.8,142.2z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M47.7,142.8l0.2-0.4l0.8,0.4c0.1,0.1,0.2,0.2,0.1,0.3l0,0
	c-0.1,0.1-0.2,0.2-0.3,0.1L47.7,142.8z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M47.9,143.5l0.2-0.4l0.8,0.4c0.1,0.1,0.2,0.2,0.1,0.3h0
	c-0.1,0.1-0.2,0.2-0.3,0.1L47.9,143.5z"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" d="M50.2,142.5c0,0-0.4,0-0.6-0.3c-0.2-0.3,0.1-1,0.1-1v-0.7v-0.3
	l0.3-0.3l0.1,0.7l0.3,1.3L50.2,142.5z"/>
<rect x="59.7" y="159.1" style="fill-rule:evenodd;clip-rule:evenodd;fill:#EABF86;" width="2" height="9.5"/>
<rect x="65.8" y="159.1" style="fill-rule:evenodd;clip-rule:evenodd;fill:#CCA570;" width="2" height="9.5"/>
<polygon style="fill-rule:evenodd;clip-rule:evenodd;fill:#CCA570;" points="69.8,140.3 68.5,140.3 68.5,151.7 69.8,147.7 "/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EC1C24;" d="M59.3,167h2.8v6.7h-2.8h-1.8c0,0-0.1-1.6,0.7-1.7
	c0.3,0,0.7,0,1.1,0.1V167z"/>
<rect x="58.9" y="158.6" style="fill-rule:evenodd;clip-rule:evenodd;fill:#BBBDBF;" width="3.9" height="1"/>
<rect x="64.8" y="158.6" style="fill-rule:evenodd;clip-rule:evenodd;fill:#BBBDBF;" width="3.9" height="1"/>
<path style="fill-rule:evenodd;clip-rule:evenodd;fill:#EC1C24;" d="M65.5,167h2.8v6.7h-2.8h-1.8c0,0-0.1-1.6,0.7-1.7
	c0.3,0,0.7,0,1.1,0.1V167z"/>
<path style="fill:none;stroke:#AAD269;stroke-width:0.25;stroke-miterlimit:10;" d="M49.4,142.3c0,0,0.8,4.1,1.7,7.1
	c0.8,2.7,2,6,2,6"/>
<g id="zmeu">
	<path style="fill:none;stroke:#AAD269;stroke-width:0.25;stroke-miterlimit:10;" d="M39.2,48.1c0,0,11.9,35.3,9,62.5
		c-0.5,26.8,1.3,31.8,1.3,31.8"/>
	<path style="fill:#13603E;" d="M40.1,94.1L39.7,94c1.5-6.3-0.3-12.9-4.5-17.8c-1.6,5.8-3.7,9.5-6.5,11.4c-3.1,2-6,3-8.8,2.8
		c-2.4-0.1-4.7-1.2-6.5-2.9c-2-1.9-3.4-4.8-3.9-7.7c-0.5-3.1-0.1-5.9,1.3-8.1c1.2-1.9,3.1-3.2,5.4-3.7c2.7-0.6,5.9-0.2,9.6,1.2
		c3.5,1.3,6.7,3.4,9.2,6.2c0-0.1,0.1-0.2,0.1-0.4c1.4-5.5,2.1-11.8,2.7-17.4c0.4-3.8,0.8-7.1,1.3-9.6l0.5,0.1
		c-0.5,2.5-0.9,5.8-1.3,9.6c-0.6,5.6-1.3,11.9-2.7,17.5c-0.1,0.2-0.1,0.5-0.2,0.7c0.9,1,1.7,2.1,2.4,3.3
		C40.5,83.7,41.3,89,40.1,94.1z M18.7,68.1c-4.3,0-6.5,2.1-7.5,3.7c-2.7,4.3-1.5,11.3,2.5,15.3c3.8,3.7,9.2,3.7,14.7,0
		c2.7-1.8,4.8-5.5,6.4-11.4c-2.4-2.7-5.5-4.9-9.2-6.2C22.9,68.5,20.6,68.1,18.7,68.1z"/>
	<rect x="46.4" y="41" transform="matrix(0.2768 -0.9609 0.9609 0.2768 -5.7428 75.0684)" width="1.2" height="0.8"/>
	<polygon style="fill:#00ACC2;" points="67.4,25.1 53.6,0.1 48,19.5 	"/>
	<polygon style="fill:#F8B101;" points="53.6,0.1 28.6,13.9 48,19.5 	"/>
	<polygon style="fill:#AAD269;" points="67.4,25.1 48,19.5 39.6,48.6 67.4,25.1 	"/>
	<polygon style="fill:#E53935;" points="28.6,13.9 28.6,13.9 39.6,48.6 48,19.5 	"/>
	
		<rect x="27.8" y="19.2" transform="matrix(0.9609 0.2768 -0.2768 0.9609 7.2675 -12.5249)" style="fill:#13603E;" width="40.4" height="0.6"/>
	
		<rect x="46.3" y="-0.9" transform="matrix(0.9609 0.2768 -0.2768 0.9609 8.5558 -11.9495)" style="fill:#13603E;" width="0.6" height="50.5"/>
	
		<rect x="38.7" y="48.1" transform="matrix(0.2768 -0.9609 0.9609 0.2768 -18.0656 73.1018)" style="fill:#13603E;" width="1.6" height="1"/>
	<polygon style="fill:#F8B101;" points="43.6,48.5 39.6,48.5 36.3,46.3 35.2,50 39.3,49.6 42.5,52.1 	"/>
	<polygon style="fill:#7DB343;" points="40,71.5 36,71.5 32.6,69.4 31.6,73 35.7,72.6 38.9,75.2 	"/>
	<polygon style="fill:#00ACC2;" points="24.9,93.5 23.2,89.9 23.8,86 20.1,86.5 22.1,90.1 21.1,94.1 	"/>
	<polygon style="fill:#E53935;" points="6,73.2 9.7,74.6 12.1,77.8 14.4,74.8 10.4,73.7 8.3,70.1 	"/>
	<polygon style="fill:#F8B101;" points="40.2,76.2 37.7,79.3 33.9,80.5 36.1,83.6 38.4,80.2 42.4,79.3 	"/>
</g>
<style>
#zmeu{animation:dash 8s ease-in-out infinite; transform-origin: 60% bottom;}
@keyframes dash {
25% {
    transform:rotate(5deg);
}
 
75% {
    transform:rotate(-5deg);
}
}
</style>
</svg>  
    </div> -->
</section>