<?php
function photography_update_yoast_meta($post_id)
{
    if (get_post_type($post_id) !== "product") {
        return;
    }
    if (isset($_POST['post_title'])) {
        $_POST["yoast_wpseo_title"] = $_POST['post_title'] ?? "";
        $_POST['yoast_wpseo_focuskw'] = $_POST['post_title'] ?? "";
    }
    if (isset($_POST['content'])) {
        $_POST["yoast_wpseo_metadesc"] = $_POST['content'] ?? "";
    }
}

//add_action('save_post', 'photography_update_yoast_meta');

//add_filter('wpseo_opengraph_image', 'photography_update_yoast_image');

function photography_update_yoast_image($url)
{
    if (is_admin()) {
        return $url;
    }

    global $post;

    if (is_front_page()) {
        return getHomepageBannerImageUrl();
    }

    if ($post->post_type === "product") {
        $thumbnail_id = get_post_thumbnail_id($post->ID);
        if ($thumbnail_id) {
            return get_text_watermarked_image($thumbnail_id, "ID: {$post->ID}");
        }
    }

    return $url;
}


add_action('wpseo_add_opengraph_images', 'add_images');

function add_images($object)
{
    if (is_front_page()) {
        $object->add_image(getHomepageBannerImageUrl());
    }
}
