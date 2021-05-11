<?php

use function NextGenImage\getImageInWebp;
use function NextGenImage\resizeImage;

/**
 * Function to get resized image in webp and original format
 *
 * @param $url string
 * @param array $size =[with x height]
 *
 * @return array
 */
function getResizedImage( $url, $size = array() ) {
	$webpImage = getImageInWebp( ABSPATH . str_replace( site_url(), "", $url ), $size );
	$fileType  = wp_check_filetype( $url );
	$image     = resizeImage( ABSPATH . str_replace( site_url(), "", $url ), $fileType['ext'], $size );

	return array(
		'webp' => $webpImage,
		'orig' => $image
	);
}

function get_youtube_id( $url ) {
	preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match );

	return $match[1];
}

function get_photography_tags( $product ) {
	$terms = get_the_terms( $product->get_id(), 'product_tag' );

	if ( ! $terms ) {
		return "";
	}

	$tags = [];

	foreach ( $terms as $term ) {


		$tags[] = str_replace( ' ', '', $term->name );
	}

	return implode( ',', $tags );
}

function photography_myaccount_page_title() {
	if ( is_wc_endpoint_url( 'orders' ) ) {
		echo "My Orders";
	} else if ( is_wc_endpoint_url( 'downloads' ) ) {
		echo "My Downloads";
	} else if ( is_wc_endpoint_url( 'edit-account' ) ) {
		echo "Edit Pofile";
	} else if ( is_wc_endpoint_url( 'edit-address' ) ) {
		echo "Edit Address";
	} else {
		echo "Dashboard";
	}
}

function photography_single_product_sharing() {
	global $product;

	$facebook_url  = "https://www.facebook.com/sharer.php?u=" . $product->get_permalink();
	$pinterest_url = add_query_arg(
		[
			'url'         => urlencode( $product->get_permalink() ),
			'media'       => urlencode( wp_get_attachment_image_url( get_post_thumbnail_id( $product->get_id() ), 'photography_preview' ) ),
			'description' => urlencode( $product->get_title() )
		],

		"http://pinterest.com/pin/create/button/"
	);

	$twitter_url = add_query_arg(
		[
			'text'     => urlencode( $product->get_title() ),
			'url'      => $product->get_permalink(),
			'hashtags' => get_photography_tags( $product )
		],
		"https://www.twitter.com/intent/tweet?"
	);

	$mail_body = $product->get_description() . " For details, link here : " . $product->get_permalink();

	$gmail_url = add_query_arg(
		[
			'view' => 'cm',
			'fs'   => 1,
			'to'   => '',
			'su'   => urlencode( $product->get_title() ),
			'body' => urlencode( $mail_body ),
			'bcc'  => ''
		],
		"https://mail.google.com/mail/"
	);
	?>
    <ul class="profile__share-icon inline-list share-icons">
        <li><a href="<?= $facebook_url ?>" target="_blank" rel="noreferrer noopener"
               class="facebook"><i class="fab fa-facebook-f"></i></a></li>
        <li><a href="<?= $twitter_url ?>" target="_blank" rel="noreferrer noopener"
               class="twitter"><i class="fab fa-twitter"></i></a></li>
        <li><a href="<?= $gmail_url ?>" target="_blank" rel="noreferrer noopener"><i class="fas fa-envelope"></i></a>
        </li>
        <li><a href="<?= $pinterest_url ?>" target="_blank" rel="noreferrer noopener"
               class="pinterest"><i class="fab fa-pinterest"></i></a></li>
    </ul>
	<?php
}

function get_photogtaphy_buy_url( $photograph ) {
	if ( is_user_logged_in() ) {
		return $photograph->get_permalink();
	}

	return wc_get_page_permalink( 'myaccount' );
}

function photography_insert_post_callback( $post_id ) {
	$post = get_post( $post_id );

	if ( $post->post_type == 'gallery' ) {
		$gallery_images = get_field( 'photographs', $post_id );

		if ( $gallery_images ) {
			foreach ( $gallery_images as $image_id ) {
				$new_post_title = get_the_title( $image_id );

				$attachment = get_post( $image_id );

				$tags       = get_field( 'tags', $post_id );
				$categories = get_field( 'categories', $post_id );

				//get product id associated with the image
				$photography_product_id = (int) get_post_meta( $image_id, 'photography_product_id', true );
//				var_dump( $photography_product_id );
//				exit;

//				if ( $photography_product_id ) {
//					wp_update_post( [
//						'ID'           => $photography_product_id,
//						'post_title'   => $attachment->post_title,
//						'post_content' => $attachment->post_content,
//						'tax_input'    => [
//							'product_cat' => $categories,
//							'product_tag' => $tags,
//						]
//					] );
//				} else {
				if ( ! $photography_product_id ) {
					$price = [
						'small'  => 1000,
						'medium' => 5000,
						'large'  => 15000
					];

					$new_post_id = wp_insert_post( [
						'post_title'   => $attachment->post_title,
						'post_author'  => get_current_user_id(),
						'post_content' => $attachment->post_content,
						'post_type'    => 'product',
						'post_status'  => 'publish',
						'tax_input'    => [
							'product_cat' => $categories,
							'product_tag' => $tags,
						]
					] );

					update_post_meta( $new_post_id, '_thumbnail_id', $image_id );

					// Update the original image (attachment) to reflect new status.
					wp_update_post( [
						'ID'          => $image_id,
						'post_title'  => $new_post_title,
						'post_parent' => $new_post_id,
						'post_status' => 'inherit'
					] );

					add_post_meta( $image_id, 'photography_product_id', $new_post_id );

					photography_create_variations( $new_post_id, $price );
				}
			}
		}

		return;
	}

	if ( ! ( $post->post_type == 'product' && $post->post_status == 'publish' ) ) {
		return;
	}

	if ( ! get_post_thumbnail_id( $post_id ) ) {
		return;
	}

	$price = get_field( 'price', $post_id );

	$galleries = get_field( 'gallery', $post_id );

	$post_thumbnail_id = get_post_thumbnail_id( $post_id );

	if ( $galleries ) {
		foreach ( $galleries as $gallery_id ) {
			$photographs = get_field( 'photographs', $gallery_id );

			if ( ! $photographs ) {
				$photographs = [];
			}

			array_push( $photographs, $post_id );

			update_field( 'field_5fa8ce7d8504b', $photographs, $gallery_id );
		}
	}

	if ( ! empty( get_post_meta( $post_id, 'check_if_run_once' ) ) ) {
		global $wpdb;
		$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'small' AND products.post_parent = {$post_id}";

		$variation_id = $wpdb->get_col( $query );

		$small_product = new WC_Product_Variation( $variation_id[0] );

		$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'medium' AND products.post_parent = {$post_id}";

		$variation_id = $wpdb->get_col( $query );

		$medium_product = new WC_Product_Variation( $variation_id[0] );

		$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'large' AND products.post_parent = {$post_id}";

		$variation_id = $wpdb->get_col( $query );

		$large_product = new WC_Product_Variation( $variation_id[0] );

		$small_product->set_regular_price( $price['small'] );
		$small_product->save();

		$medium_product->set_regular_price( $price['medium'] );
		$medium_product->save();

		$large_product->set_regular_price( $price['large'] );
		$large_product->save();


		return;
	}
	add_post_meta( $post_thumbnail_id, 'photography_product_id', $post_id );

	$product_id = $post_id;

	photography_create_variations( $product_id, $price );
}

add_action( 'wp_insert_post', 'photography_insert_post_callback', 10, 1 );

function photography_create_variations( $post_id, $price = [] ) {
//	var_dump( 'photography_create_variations' );
//	exit;

	$product = wc_get_product( $post_id );

	$product_id = $post_id;

	$attributes = get_terms( [
		'taxonomy'   => 'pa_resolution',
		'hide_empty' => false
	] );

//	$post_thumbnail_id = get_post_thumbnail_id( $post_id );

	//make product type be variable:
	wp_set_object_terms( $product_id, 'variable', 'product_type' );

	// Iterating through the variations attributes
	foreach ( $attributes as $attribute ) {
		//add attribute to product
		$term_taxonomy_ids = wp_set_object_terms( $post_id, $attribute->name, 'pa_resolution', true );
		$thedata           = array(
			'pa_resolution' => array(
				'name'         => 'pa_resolution',
				'value'        => $attribute->name,
				'is_visible'   => '1',
				'is_variation' => '1',
				'is_taxonomy'  => '1'
			)
		);
		update_post_meta( $post_id, '_product_attributes', $thedata );

		$variation_post = array(
			'post_title'  => $product->get_title(),
			'post_name'   => 'product-' . $product_id . '-variation',
			'post_status' => 'publish',
			'post_parent' => $product_id,
			'post_type'   => 'product_variation',
			'guid'        => $product->get_permalink()
		);

		// Creating the product variation
		$variation_id = wp_insert_post( $variation_post );

		// Get an instance of the WC_Product_Variation object
		$variation = new WC_Product_Variation( $variation_id );

		$taxonomy = 'pa_resolution'; // The attribute taxonomy

		$term_name = $attribute->name;

		$term = get_term_by( 'name', $term_name, $taxonomy );

		$term_slug = $term->slug; // Get the term slug

		// Set/save the attribute data in the product variation
		update_post_meta( $variation_id, 'attribute_' . $taxonomy, $term_slug );

		$variation->set_virtual( true );
		$variation->set_downloadable( true );

		// Creating an empty instance of a WC_Product_Download object
		$pd_object   = new WC_Product_Download();
		$download_id = wp_generate_uuid4();
		$file_name   = $filename = basename( get_attached_file( $product->get_image_id() ) );
		// Set the data in the WC_Product_Download object
		$pd_object->set_id( $download_id );
		$pd_object->set_name( $file_name );
		if ( $term_slug == "large" ) {
			$pd_object->set_file( wp_get_attachment_image_url( $product->get_image_id(), 'full' ) );
		} else {
			$pd_object->set_file( wp_get_attachment_image_url( $product->get_image_id(), 'photography_' . $term_slug ) );
		}

		// Get existing downloads (if they exist)
		$downloads = $product->get_downloads();

		// Add the new WC_Product_Download object to the array
		$downloads[ $download_id ] = $pd_object;

		$variation->set_downloads( $downloads );

		if ( isset( $price[ $term->name ] ) ) {
			$variation->set_regular_price( $price[ $term->name ] );
		} else {
			$variation->set_regular_price( get_field( 'price', $term ) );
		}

		$variation->save(); // Save the data
	}

//	add_post_meta( $post_thumbnail_id, 'photography_product_id', $post_id );

	# And update the meta so it won't run again
	update_post_meta( $post_id, 'check_if_run_once', true );
}

function photography_create_delete_request( $image_id ) {
	$delete_request_title = "Delete Request for " . get_the_title( $image_id );
	$delete_request_id    = wp_insert_post( [
		'post_title'  => $delete_request_title,
		'post_author' => get_current_user_id(),
		'post_type'   => 'delete_request',
		'post_status' => 'publish'
	] );

	update_field( 'photograph', $image_id, $delete_request_id );
	update_field( 'remarks', get_field( 'delete_request_message', $image_id ), $delete_request_id );
}

// set download files of product variations if not set
function action_woocommerce_loaded( $array ) {
	// make action magic happen here...
	$products_ids = get_posts( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => - 1
	) );

	// Loop through product Ids
	foreach ( $products_ids as $product_id ) {

		// Get the WC_Product object
		$product = wc_get_product( $product_id );

		$children_ids = $product->get_children();

		foreach ( $children_ids as $children_id ) {
			$child_product = wc_get_product( $children_id );

			if ( $child_product->is_downloadable() ) {
				$resolution_attribute = $child_product->get_attribute( 'pa_resolution' );

				// Creating an empty instance of a WC_Product_Download object
				$pd_object = new WC_Product_Download();

				$download_id = wp_generate_uuid4();
				$file_name   = $filename = basename( get_attached_file( $product->get_image_id() ) );

				// Set the data in the WC_Product_Download object
				$pd_object->set_id( $download_id );
				$pd_object->set_name( $file_name );
				if ( $resolution_attribute == "large" ) {
					$pd_object->set_file( wp_get_attachment_image_url( $product->get_image_id(), 'full' ) );
				} else {
					$pd_object->set_file( wp_get_attachment_image_url( $product->get_image_id(), 'photography_' . $resolution_attribute ) );
				}

				// Get existing downloads (if they exist)
				$downloads = $product->get_downloads();

				$downloads = [];

				// Add the new WC_Product_Download object to the array
				$downloads[ $download_id ] = $pd_object;

				$child_product->set_downloads( $downloads );

				$child_product->save();
			}
		}
	};
}

//add_action( 'admin_init', 'action_woocommerce_loaded', 10, 1 );


//get size ko photograph set as downloadable file on photograph variations
function get_downloadable_photograph_size( $product_id ) {
	$product = wc_get_product( $product_id );

	$downloads = $product->get_downloads();

	if ( empty( $downloads ) ) {
		return false;
	}

	$download_photograph = array_pop( $downloads );

	$photograph_size = getimagesize( $download_photograph['file'] );

	return "{$photograph_size[0]} x {$photograph_size[1]} px";
}

function get_photography_image_sizes() {
	$images_sizes = wp_get_registered_image_subsizes();

	return [
		'small'  => [ $images_sizes['photography_small']['width'], $images_sizes['photography_small']['height'] ],
		'medium' => [ $images_sizes['photography_medium']['width'], $images_sizes['photography_medium']['height'] ],
	];
}

function get_all_product_tags() {
	$tags = get_terms( 'product_tag', array(
		'hide_empty' => false,
	) );

	return array_map( function ( $tag ) {
		return $tag->name;
	}, $tags );
}