<?php
/**
 * Function to automatically update the focus keyword with the post title on post_save, if no focus keyword is set
 */
function photography_update_product_focus_keyword($post_id)
{
    $rank_math_keyword = get_post_meta($post_id, 'rank_math_focus_keyword', true);
    if (!$rank_math_keyword) {
        update_post_meta($post_id, 'rank_math_focus_keyword', strtolower(get_the_title($post_id)));
    }
}

add_action('save_post', 'photography_update_product_focus_keyword');

/**
 * Function to automatically update the title and alt text of post thumbnail with the post title on post_save
 */
function photography_sync_product_title_with_thumbnail($post_id)
{
    if (get_post_type($post_id) !== "product") {
        return;
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);

    if (isset($_POST['post_title']) && $thumbnail_id) {

        wp_update_post(array(
            'ID' => $thumbnail_id,
            'post_title' => $_POST['post_title']
        ));
        update_post_meta($thumbnail_id, '_wp_attachment_image_alt', $_POST['post_title']);
    }
}

add_action('save_post', 'photography_sync_product_title_with_thumbnail');