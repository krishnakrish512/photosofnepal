<?php

function photography_add_product_tag_callback() {
	$new_tag = wp_insert_term( $_POST["new_tag"], 'product_tag', [] );

	wp_send_json( get_term( $new_tag['term_id'] ) );

	die();
}

add_action( 'wp_ajax_nopriv_photography_add_product_tag', 'photography_add_product_tag_callback' );
add_action( 'wp_ajax_photography_add_product_tag', 'photography_add_product_tag_callback' );

function photography_get_all_product_tags_callback() {
	$tags = get_terms( 'product_tag', array(
		'hide_empty' => false,
	) );

	$tag_names = array_map( function ( $tag ) {
		return $tag->name;
	}, $tags );

	wp_send_json( $tag_names );
	die();
}

add_action( 'wp_ajax_nopriv_photography_get_all_product_tags', 'photography_get_all_product_tags_callback' );
add_action( 'wp_ajax_photography_get_all_product_tags', 'photography_get_all_product_tags_callback' );

function photography_upload_attachment_callback() {
// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	var_dump( $_POST );

	die();
}

add_action( 'wp_ajax_nopriv_photography_upload_attachment', 'photography_upload_attachment_callback' );
add_action( 'wp_ajax_photography_upload_attachment', 'photography_upload_attachment_callback' );

function add_new_photograph_callback() {

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$title       = filter_var( $_POST['title'], FILTER_SANITIZE_STRING );
	$description = filter_var( $_POST['description'], FILTER_SANITIZE_STRING );

	$categories = isset( $_POST['categories'] ) ? (array) $_POST['categories'] : [];
	$categories = array_map( 'esc_attr', $categories );

	$tags = isset( $_POST['tags'] ) ? (array) $_POST['tags'] : [];
	$tags = array_map( 'esc_attr', $tags );
//	$tags = array_map( 'intval', $tags );

//	foreach ( $tags as &$tag ) {
//		if ( (int) $tag == 0 ) {
//			$new_tag = wp_insert_term( $tag, 'product_tag', [] );
//			$tag     = $new_tag['term_id'];
//		} else {
//			$tag = (int) $tag;
//		}
//	}

//	wp_set_object_terms( $product_id, $tags, 'product_tag' );


	$galleries = isset( $_POST['galleries'] ) ? (array) $_POST['galleries'] : [];
	$galleries = array_map( 'esc_attr', $galleries );
	$galleries = array_map( 'intval', $galleries );

	$price = [];

	foreach ( [ 'small', 'medium', 'large' ] as $term_name ) {
		$price[ $term_name ] = $_POST["{$term_name}_price"];
	}

	// Let WordPress handle the upload.
	$attachment_id = media_handle_upload( 'photograph', 0 );

	if ( is_wp_error( $attachment_id ) ) {
		// There was an error uploading the image.
		echo "error uploading image";
	} else {
		// The image was uploaded successfully!
		$new_post_id = wp_insert_post( [
			'post_title'   => $title,
			'post_content' => $description,
			'post_author'  => get_current_user_id(),
			'post_type'    => 'product',
			'post_status'  => 'publish',
			'tax_input'    => [
				'product_cat' => $categories,
				'product_tag' => $tags
			]
		] );

		wp_set_object_terms( $new_post_id, $tags, 'product_tag' );


		update_post_meta( $new_post_id, '_thumbnail_id', $attachment_id );

		// Update the original image (attachment) to reflect new status.
		wp_update_post( [
			'ID'           => $attachment_id,
			'post_parent'  => $new_post_id,
			'post_status'  => 'inherit',
			'post_title'   => $title,
			'post_content' => $description
		] );

		add_post_meta( $attachment_id, 'photography_product_id', $new_post_id );

		update_field( 'categories', $categories, $attachment_id );
		update_field( 'tags', $tags, $attachment_id );

		//add photograph to gallery posts
		if ( ! empty( $galleries ) ) {
			foreach ( $galleries as $gallery_id ) {
				$gallery_photographs = get_field( 'photographs', $gallery_id );

				array_push( $gallery_photographs, $attachment_id );

				update_field( 'photographs', $gallery_photographs, $gallery_id );
			}
		}

		create_photography_variations( $new_post_id, $price );
	}

	die();
}

add_action( 'wp_ajax_nopriv_add_new_photograph', 'add_new_photograph_callback' );
add_action( 'wp_ajax_add_new_photograph', 'add_new_photograph_callback' );

function photography_search_autocomplete_callback() {
	$search = $_GET['term'];


	$matched_posts = [];

	$search_query = new WP_Query( [ 's' => $search, 'post_type' => 'product', 'posts_per_page' => - 1 ] );
	if ( $search_query->have_posts() ) {
		while ( $search_query->have_posts() ) {
			$search_query->the_post();
			array_push( $matched_posts, get_the_title() );
		}
		wp_reset_postdata();
	}

	$all_product_tags = get_terms( array( 'taxonomy' => 'product_tag', 'hide_empty' => true ) );

	foreach ( $all_product_tags as $all ) {
		$par = $all->name;
		if ( stripos( $par, $search ) !== false ) {
			array_push( $matched_posts, $all->name );
		}
	}

	$matched_posts = array_unique( $matched_posts );
	$matched_posts = array_values( array_filter( $matched_posts ) );

	$results_json = array_map( function ( $post_title ) {
		return [
			'id'    => $post_title,
			'label' => $post_title,
			'value' => $post_title
		];
	}, $matched_posts );

	/*	echo "<pre>";
		print_r( $results_json );
		echo "</pre>";
		exit;*/

	wp_send_json( $results_json );

	die();
}

add_action( 'wp_ajax_nopriv_photography_search_autocomplete', 'photography_search_autocomplete_callback' );
add_action( 'wp_ajax_photography_search_autocomplete', 'photography_search_autocomplete_callback' );