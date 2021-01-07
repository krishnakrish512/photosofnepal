<?php

$include_files = [
	"src/setup.php",
	"src/helper.php",
	"src/filter.php",
	"src/admin.php",
	"src/woocommerce_filter.php",
	"src/woocommerce_custom_checkout.php",
	"src/attachment_hooks.php",
	"src/acf_hooks.php",
//	"src/photography_loadmore_ajax.php",
	"vendor/autoload.php",
	"src/watermark.php",
	"src/wcfm.php",
	"src/photography_ajax.php",
//    "src/classes/SKA_Menu_Walker.php",
//    "src/classes/SKA_Responsive_Menu_Walker.php"
];

array_walk( $include_files, function ( $file ) {
	if ( ! locate_template( $file, true, true ) ) {
		trigger_error( sprintf( "Could not find %s", $file ), E_USER_ERROR );
	}
} );

unset( $include_files );