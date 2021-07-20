<?php
function photographer_remove_menu_items()
{
    if (!wc_current_user_has_role('administrator') && (wc_current_user_has_role('wc_product_vendors_admin_vendor') || wc_current_user_has_role('wc_product_vendors_manager_vendor') || wc_current_user_has_role('seller'))) {

        global $menu, $submenu;

        //change products menu and submenu
        $menu[26][0] = "Photographs";
        $submenu['edit.php?post_type=product'][5][0] = "All Photographs";

        remove_menu_page('upload.php');
        remove_menu_page('edit.php');                   //Posts
        remove_menu_page('edit-comments.php');          //Comments
        remove_menu_page('tools.php');                  //Tools
        remove_menu_page('edit.php?post_type=delete_request');                  //Delete Requests
        remove_menu_page('wcpv-vendor-settings');         //wc product vendors store setting

        unset($submenu['edit.php?post_type=product'][15]);
        unset($submenu['edit.php?post_type=product'][16]);

        remove_submenu_page('edit.php?post_type=product', 'product_attributes');
    }
}

add_action('admin_menu', 'photographer_remove_menu_items', 9999);

//customize admin bar
add_action('admin_bar_menu', function ($wp_admin_bar) {
    if (!wc_current_user_has_role('administrator') && (wc_current_user_has_role('wc_product_vendors_admin_vendor') || wc_current_user_has_role('wc_product_vendors_manager_vendor') || wc_current_user_has_role('seller'))) {

        //Get a reference to the new-content node to modify.
        $new_content_node = $wp_admin_bar->get_node('new-content');

        //Change href
        $new_content_node->href = admin_url('post-new.php?post_type=product');

        //Update Node.
        $wp_admin_bar->add_node($new_content_node);

        $new_product_node = $wp_admin_bar->get_node('new-product');
        $new_product_node->title = "Photograph";
        $wp_admin_bar->add_node($new_product_node);

        $wp_admin_bar->remove_node('new-post');

        $wp_admin_bar->remove_node('new-media');
        $wp_admin_bar->remove_node('new-product');
        $wp_admin_bar->remove_node('new-shop_order');
        $wp_admin_bar->remove_node('new-delete_request');
        $wp_admin_bar->remove_node('new-gallery');
    }
}, 999);

//force the mode into grid view
add_action('admin_init', function () {
    if (isset($_GET['mode'])) {
        $_GET['mode'] = 'grid';
    }
}, 100);

function custom_post_author_archive($query)
{
    if (is_admin() && get_query_var('post_type') == 'gallery' && !current_user_can('edit_others_posts')) {
        $query->set('author', get_current_user_id());
    }
}

add_action('pre_get_posts', 'custom_post_author_archive');

if (wc_current_user_has_role('wc_product_vendors_admin_vendor') || wc_current_user_has_role('wc_product_vendors_manager_vendor') || wc_current_user_has_role('vendor')) {
    function z_remove_media_controls()
    {
        remove_action('media_buttons', 'media_buttons');
    }

    add_action('admin_head', 'z_remove_media_controls');


// disable wyswyg for custom post type, using the global $post
    add_filter('user_can_richedit', function ($default) {
        global $post;

        if ($post && $post->post_type === 'product') {
            return false;
        }

        return $default;
    });

    function update_contact_methods($contactmethods)
    {
        unset($contactmethods['facebook']);
        unset($contactmethods['instagram']);
        unset($contactmethods['linkedin']);
        unset($contactmethods['myspace']);
        unset($contactmethods['pinterest']);
        unset($contactmethods['soundcloud']);
        unset($contactmethods['tumblr']);
        unset($contactmethods['twitter']);
        unset($contactmethods['youtube']);
        unset($contactmethods['wikipedia']);


        return $contactmethods;

    }

    add_filter('user_contactmethods', 'update_contact_methods');
}

//add featured product filter in admin
add_action('restrict_manage_posts', 'featured_products_sorting');
function featured_products_sorting()
{
    global $typenow;
    $post_type = 'product'; // change to your post type
    $taxonomy = 'product_visibility'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Show all {$info_taxonomy->label}"),
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'orderby' => 'name',
            'selected' => $selected,
            'show_count' => true,
            'hide_empty' => true,
        ));
    };
}

add_filter('parse_query', 'featured_products_sorting_query');
function featured_products_sorting_query($query)
{
    global $pagenow;
    $post_type = 'product'; // change to your post type
    $taxonomy = 'product_visibility'; // change to your taxonomy
    $q_vars = &$query->query_vars;
    if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}