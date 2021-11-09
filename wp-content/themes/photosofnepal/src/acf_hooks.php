<?php

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'manage_options',
//		'redirect'		=> false
    ));
}


add_filter('acf/fields/post_object/query/name=gallery', 'my_acf_fields_post_object_query', 10, 3);
function my_acf_fields_post_object_query($args, $field, $post_id)
{

    $args['author'] = get_current_user_id();

    return $args;
}

add_filter('acf/fields/post_object/query/name=gallery_photographs', 'my_acf_fields_photographs_query', 10, 3);
function my_acf_fields_photographs_query($args, $field, $post_id)
{

//	$args['author'] = get_current_user_id();

    $args['meta_key'] = 'photography_product_id';
    $args['meta_compare'] = 'EXISTS';

    var_dump($args);


    return $args;
}

add_action('acf/save_post', 'my_acf_save_post', 5);
function my_acf_save_post($post_id)
{
    if (get_post_type($post_id) == "gallery") {

        // Get previous values.
        $old_gallery_photos = get_field("photographs", $post_id);

        if ($old_gallery_photos) {
            //for localhost
            if (isset($_POST['acf']['field_5fa8ce7d8504b'])) {
                $new_gallery_photos = $_POST['acf']['field_5fa8ce7d8504b'];


                foreach ($new_gallery_photos as $photo_id) {
                    if (!in_array($photo_id, $old_gallery_photos)) { // new photo has been added

                        $photography_product_id = (int)get_post_meta($photo_id, 'photography_product_id', true);
                        if ($photography_product_id) {
                            $photography_product_galleries = get_field('gallery', $photography_product_id);

                            if ($photography_product_galleries) {
                                if (!in_array($post_id, $photography_product_galleries)) {
                                    array_push($photography_product_galleries, intval($post_id));

                                    update_field("field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id);
                                }
                            } else {
                                update_field("field_5ffe9c9438f97", [intval($post_id)], $photography_product_id);
                            }

                        }
                    }
                }


                foreach ($old_gallery_photos as $photo_id) {
                    if (!in_array($photo_id, $new_gallery_photos)) { //photo removed from gallery
                        $photography_product_id = (int)get_post_meta($photo_id, 'photography_product_id', true);

                        if ($photography_product_id) {
                            $photography_product_galleries = get_field('gallery', $photography_product_id);

                            if ($photography_product_galleries) {
                                if (($key = array_search($post_id, $photography_product_galleries)) !== false) {
                                    unset($photography_product_galleries[$key]);

                                    update_field("field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id);

                                }
                            }
                        }
                    }
                }

            }

            //for live
            if (isset($_POST['acf']['field_5fa8f9dc28644'])) {
                $new_gallery_photos = $_POST['acf']['field_5fa8f9dc28644'];

                foreach ($new_gallery_photos as $photo_id) {
                    if (!in_array($photo_id, $old_gallery_photos)) { // new photo has been added

                        $photography_product_id = (int)get_post_meta($photo_id, 'photography_product_id', true);

                        if ($photography_product_id) {
                            $photography_product_galleries = get_field('gallery', $photography_product_id);

                            if ($photography_product_galleries) {
                                if (!in_array($post_id, $photography_product_galleries)) {
                                    array_push($photography_product_galleries, intval($post_id));

                                    update_field("field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id);
                                }
                            } else {
                                update_field("field_5ffe9c9438f97", [intval($post_id)], $photography_product_id);
                            }

                        }
                    }
                }

                foreach ($old_gallery_photos as $photo_id) {
                    if (!in_array($photo_id, $new_gallery_photos)) { //photo removed from gallery
                        $photography_product_id = (int)get_post_meta($photo_id, 'photography_product_id', true);

                        if ($photography_product_id) {
                            $photography_product_galleries = get_field('gallery', $photography_product_id);

                            if ($photography_product_galleries) {
                                if (($key = array_search($photo_id, $photography_product_galleries)) !== false) {
                                    unset($photography_product_galleries[$key]);

                                    update_field("field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id);

                                }
                            }
                        }
                    }
                }
            }
        }
    }

    if (get_post_type($post_id) == "product") {
        $old_galleries = get_field('gallery', $post_id);

        if (isset($_POST['acf']['field_5ffe9c9438f97'])) {
            $new_galleries = $_POST['acf']['field_5ffe9c9438f97'];

            if (!$old_galleries) {
                foreach ($new_galleries as $gallery_id) {
                    $gallery_photographs = get_field('photographs', $gallery_id);

                    $photograph_id = $_POST['_thumbnail_id'];

                    if (!in_array($photograph_id, $gallery_photographs)) {
                        array_push($gallery_photographs, $photograph_id);

                        update_field('field_5fa8ce7d8504b', $gallery_photographs, $gallery_id);
                        update_field('field_5fa8f9dc28644', $gallery_photographs, $gallery_id);
                    }
                }
            }

            foreach ($new_galleries as $gallery_id) {
                if (!in_array($gallery_id, $old_galleries)) {// new gallery added

                    $gallery_photographs = get_field('photographs', $gallery_id);

                    $photograph_id = $_POST['_thumbnail_id'];

                    if (!in_array($photograph_id, $gallery_photographs)) {
                        array_push($gallery_photographs, $photograph_id);

                        update_field('field_5fa8ce7d8504b', $gallery_photographs, $gallery_id);
                        update_field('field_5fa8f9dc28644', $gallery_photographs, $gallery_id);
                    }
                }
            }

            foreach ($old_galleries as $gallery_id) { //gallery removed
                if (!in_array($gallery_id, $new_galleries)) {
                    $gallery_photographs = get_field('photographs', $gallery_id);

                    $photograph_id = $_POST['_thumbnail_id'];

                    if (($key = array_search($photograph_id, $gallery_photographs)) !== false) {
                        unset($gallery_photographs[$key]);

                        update_field('field_5fa8ce7d8504b', $gallery_photographs, $gallery_id);
                        update_field('field_5fa8f9dc28644', $gallery_photographs, $gallery_id);

                    }
                }
            }
        }
    }
}