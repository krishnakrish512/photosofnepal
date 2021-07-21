<?php
function photography_update_yoast_meta($post_id)
{
    if (isset($_POST['content']) && $_POST['content']) {
        $_POST["yoast_wpseo_title"] = $_POST['post_title'] . ' - ' . $_POST['content'];

    } else {
        $_POST['yoast_wpseo_title'] = $_POST['post_title'] ?? "";
    }
    $_POST["yoast_wpseo_metadesc"] = $_POST['content'] ?? "";
}

add_action('save_post', 'photography_update_yoast_meta');

add_filter('wpseo_opengraph_image', 'photography_update_product_yoast_image');

function photography_update_product_yoast_image($url)
{
    if (is_admin()) {
        return $url;
    }

    global $post;

    $thumbnail_id = get_post_thumbnail_id($post->ID);
    if ($thumbnail_id) {
        return get_text_watermarked_image($thumbnail_id, "ID: {$post->ID}");
    }

    return $url;
}

function photography_remove_yoast_metabox()
{
    if (!wc_current_user_has_role('administrator') && (wc_current_user_has_role('wc_product_vendors_admin_vendor') ||
            wc_current_user_has_role('wc_product_vendors_manager_vendor') || wc_current_user_has_role('seller'))) {
        remove_meta_box('wpseo_meta', 'product', 'normal');
        remove_meta_box('wpseo_meta', 'gallery', 'normal');
    }
}

add_action('add_meta_boxes', 'photography_remove_yoast_metabox', 11);
