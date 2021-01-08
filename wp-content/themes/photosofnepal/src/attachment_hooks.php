<?php
// load only current users media files
function segregateUserMedia( $query ) {
	$current_userID = get_current_user_id();

	if ( $current_userID && ! current_user_can( 'edit_others_posts' ) ) {
		$query['author'] = $current_userID;
	}

	return $query;
}

add_filter( 'ajax_query_attachments_args', 'segregateUserMedia' );

function photography_edit_attachment( $post_id ) {
//	var_dump( 'add gallery photograph' );

	//if attachment is not an image, do nothing
	if ( ! wp_attachment_is_image( $post_id ) ) {
		return;
	}

	$attachment_post = get_post( $post_id );

	$new_post_title        = $attachment_post->post_title;
	$new_post_description  = $attachment_post->post_content;
	$new_post_product_cats = get_field( 'categories', $post_id );
	$new_post_product_tags = get_field( 'tags', $post_id );

	//get product id associated with the image
	$photography_product_id = (int) get_post_meta( $post_id, 'photography_product_id', true );

	if ( $photography_product_id ) {
		wp_update_post( [
			'ID'           => $photography_product_id,
			'post_title'   => $new_post_title,
			'post_content' => $new_post_description,
			'tax_input'    => [
				'product_cat' => $new_post_product_cats,
				'product_tag' => $new_post_product_tags,
			]
		] );


//		if ( get_field( 'delete_request', $post_id ) && get_field( 'delete_request_message', $post_id ) ) {
//			photography_create_delete_request( $post_id );
//		}
	}
}


//if ( wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) ) {
//	add_action( 'edit_attachment', 'photography_edit_attachment' );
//	add_action( 'add_attachment', 'photography_add_attachment' );
//}

function photography_add_attachment( $post_id ) {
//if attachment is not an image, do nothing
	if ( ! wp_attachment_is_image( $post_id ) ) {
		return;
	}

	$attachment_post = get_post( $post_id );

	$new_post_title        = $attachment_post->post_title;
	$new_post_description  = $attachment_post->post_content;
	$new_post_product_cats = get_field( 'categories', $post_id );
	$new_post_product_tags = get_field( 'tags', $post_id );

	$new_post_id = wp_insert_post( [
		'post_title'   => $new_post_title,
		'post_content' => $new_post_description,
		'post_author'  => get_current_user_id(),
		'post_type'    => 'product',
		'post_status'  => 'publish',
		'tax_input'    => [
			'product_cat' => $new_post_product_cats,
			'product_tag' => $new_post_product_tags
		]
	] );

	update_post_meta( $new_post_id, '_thumbnail_id', $post_id );

	// Update the original image (attachment) to reflect new status.
	wp_update_post( [
		'ID'          => $post_id,
		'post_parent' => $new_post_id,
		'post_status' => 'inherit'
	] );

	add_post_meta( $post_id, 'photography_product_id', $new_post_id );

	create_photography_variations( $new_post_id );
}


function photography_cleanup( $post_id ) {

	//if attachment is not an image, do nothing
	if ( ! wp_attachment_is_image( $post_id ) ) {
		return;
	}

//check if given image is already associated with a product, if so delete product before deleting image
	$args = [
		'post_type'   => 'product',
		'post_status' => 'publish',
		'meta_key'    => '_thumbnail_id',
		'meta_value'  => $post_id
	];

	$product_query = new WP_Query( $args );

	if ( ! $product_query->have_posts() ) {
		return;
	}

	while ( $product_query->have_posts() ) {
		$product_query->the_post();

		wp_delete_post( get_the_ID(), true );
	}

	wp_reset_postdata();
}

//add_action( 'delete_attachment', 'photography_cleanup' );