<?php

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'manage_options',
//		'redirect'		=> false
	) );
}


add_filter( 'acf/fields/post_object/query/name=gallery', 'my_acf_fields_post_object_query', 10, 3 );
function my_acf_fields_post_object_query( $args, $field, $post_id ) {

	$args['author'] = get_current_user_id();

	return $args;
}

add_filter( 'acf/fields/post_object/query/name=gallery_photographs', 'my_acf_fields_photographs_query', 10, 3 );
function my_acf_fields_photographs_query( $args, $field, $post_id ) {

//	$args['author'] = get_current_user_id();

	$args['meta_key']     = 'photography_product_id';
	$args['meta_compare'] = 'EXISTS';

	var_dump( $args );


	return $args;
}

add_action( 'acf/save_post', 'my_acf_save_post', 5 );
function my_acf_save_post( $post_id ) {
	if ( get_post_type( $post_id ) !== "gallery" ) {
		return;
	}

	// Get previous values.
	$old_gallery_photos = get_field( "photographs", $post_id );

	if ( isset( $_POST['acf']['field_5fa8ce7d8504b'] ) ) {

		$new_gallery_photos = $_POST['acf']['field_5fa8ce7d8504b'];

		if ( count( $old_gallery_photos ) === count( $new_gallery_photos ) ) {
			return;
		} elseif ( count( $old_gallery_photos ) > count( $new_gallery_photos ) ) {
			var_dump( 'removed photos' );
			var_dump( array_diff( $old_gallery_photos, $new_gallery_photos ) );

			$removed_photos = array_diff( $old_gallery_photos, $new_gallery_photos );

			foreach ( $removed_photos as $photo_id ) {

				$photography_product_id = (int) get_post_meta( $photo_id, 'photography_product_id', true );

				if ( $photography_product_id ) {
					$photography_product_galleries = get_field( 'gallery', $photography_product_id );

					$gallery_key = array_search( $post_id, $photography_product_galleries );
					if ( $gallery_key ) {
						array_splice( $photography_product_galleries, $gallery_key, 1 );
						var_dump( 'new gallery posts' );
						var_dump( $photography_product_galleries );
						update_field( "field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id );

					}
				}

//				get_post
			}
		} else {
			var_dump( 'added photos' );
			var_dump( array_diff( $new_gallery_photos, $old_gallery_photos ) );

			$added_photos = array_diff( $new_gallery_photos, $old_gallery_photos );

			foreach ( $added_photos as $photo_id ) {
				$photography_product_id = (int) get_post_meta( $photo_id, 'photography_product_id', true );

				if ( $photography_product_id ) {
					$photography_product_galleries = get_field( 'gallery', $photography_product_id );

					if ( $photography_product_galleries ) {
						if ( ! array_search( $post_id, $photography_product_galleries ) ) {
							array_push( $photography_product_galleries, $post_id );

							var_dump( 'new gallery' );
							var_dump( $photography_product_galleries );

							update_field( "field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id );

						}
					} else {
						var_dump( update_field( "field_5ffe9c9438f97", [ $post_id ], $photography_product_id ) );
					}

				}
			}
		}
	}


	if ( isset( $_POST['acf']['field_5fa8f9dc28644'] ) ) {

		$new_gallery_photos = $_POST['acf']['field_5fa8f9dc28644'];

		if ( count( $old_gallery_photos ) === count( $new_gallery_photos ) ) {
			return;
		} elseif ( count( $old_gallery_photos ) > count( $new_gallery_photos ) ) {
			var_dump( array_diff( $old_gallery_photos, $new_gallery_photos ) );

			$removed_photos = array_diff( $old_gallery_photos, $new_gallery_photos );

			foreach ( $removed_photos as $photo_id ) {

				$photography_product_id = (int) get_post_meta( $photo_id, 'photography_product_id', true );

				if ( $photography_product_id ) {
					$photography_product_galleries = get_field( 'gallery', $photography_product_id );

					$gallery_key = array_search( $post_id, $photography_product_galleries );
					if ( $gallery_key ) {
						array_splice( $photography_product_galleries, $gallery_key, 1 );
						var_dump( $photography_product_galleries );
						update_field( "field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id );

					}
				}

//				get_post
			}
		} else {
			var_dump( array_diff( $new_gallery_photos, $old_gallery_photos ) );

			$added_photos = array_diff( $new_gallery_photos, $old_gallery_photos );

			foreach ( $added_photos as $photo_id ) {
				$photography_product_id = (int) get_post_meta( $photo_id, 'photography_product_id', true );

				if ( $photography_product_id ) {
					$photography_product_galleries = get_field( 'gallery', $photography_product_id );
					if ( ! array_search( $post_id, $photography_product_galleries ) ) {
						array_push( $photography_product_galleries, $post_id );

						var_dump( $photography_product_galleries );

						update_field( "field_5ffe9c9438f97", $photography_product_galleries, $photography_product_id );

					}
				}
			}
		}
	}
//	exit;
}