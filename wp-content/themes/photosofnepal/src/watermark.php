<?php

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

function get_text_watermarked_image( $imageId, $text ) {
	$imageFileName = basename( get_attached_file( $imageId ) );

//	if ( file_exists( ABSPATH . "watermark/${imageFileName}" ) ) {
//		return site_url( "watermark/{$imageFileName}" );
//	}


	$imageSource = wp_get_attachment_image_url( $imageId, 'photography_preview' );

	$imageSize   = getimagesize( $imageSource );
	$imageWidth  = $imageSize[0];
	$imageHeight = $imageSize[1];

	//$manager = new ImageManager( [ 'driver' => 'imagick' ] );
	$manager = new ImageManager();

	$image     = $manager->make( $imageSource );
	$watermark = $manager->make( get_template_directory() . '/assets/images/water-mark.png' );

	$id_watermark = $manager->canvas( 200, 50, '#000000' )->opacity( 10 );

	$id_watermark->text( $text, 10, 35, function ( $font ) {
		$font->file( get_template_directory() . '/assets/fonts/Montserrat-Regular.ttf' );
		$font->size( 28 );
		$font->color( '#ffffff' );
	} );


//	$id_watermark->save( "id_watermark.jpg" );

	if ( $imageWidth > $imageHeight ) {
		$watermark->resize( round( $imageWidth * 0.30 ), null, function ( $constraint ) {
			$constraint->aspectRatio();
			$constraint->upsize();
		} );

		$id_watermark->resize( round( $imageWidth * 0.10 ), null, function ( $constraint ) {
			$constraint->aspectRatio();
			$constraint->upsize();
		} );
	} else {
		$watermark->resize( round( $imageWidth * 0.50 ), null, function ( $constraint ) {
			$constraint->aspectRatio();
			$constraint->upsize();
		} );

		$id_watermark->resize( round( $imageWidth * 0.15 ), null, function ( $constraint ) {
			$constraint->aspectRatio();
			$constraint->upsize();
		} );
	}


	$image->insert( $id_watermark, 'bottom-right', 0, 0 );

	$image->insert( $watermark, 'bottom-left', 0, round( $imageHeight * 0.2 ) );

	$image->save( "watermark/{$imageFileName}", 100 );

	return site_url( "watermark/{$imageFileName}" );
}