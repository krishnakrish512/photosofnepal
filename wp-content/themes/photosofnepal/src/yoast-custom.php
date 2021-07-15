<?php
function photography_update_yoast_meta($post_id)
{
    if ($_POST['content']) {
        $_POST["yoast_wpseo_title"] = $_POST['post_title'] . ' - ' . $_POST['content'];

    } else {
        $_POST['yoast_wpseo_title'] = $_POST['post_title'];
    }
    $_POST["yoast_wpseo_metadesc"] = $_POST['content'];
}

add_action('save_post', 'photography_update_yoast_meta');

add_filter('wpseo_opengraph_image', 'photography_update_product_yoast_image');

function photography_update_product_yoast_image($url)
{
    global $post;

    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $watermarked_image = get_text_watermarked_image($thumbnail_id, "ID: {$post->ID}");

    return $watermarked_image;
}
