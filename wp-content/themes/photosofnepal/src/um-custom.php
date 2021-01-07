<?php

/* add new tab called "mytab" */

add_filter( 'um_account_page_default_tabs_hook', 'my_custom_tab_in_um', 100 );
function my_custom_tab_in_um( $tabs ) {
	$tabs[800]['photograph']['icon']        = 'fas fa-camera';
	$tabs[800]['photograph']['title']       = 'Photography';
	$tabs[800]['photograph']['custom']      = true;
	$tabs[800]['photograph']['show_button'] = false;


	return $tabs;
}


/* make our new tab hookable */

add_action( 'um_account_tab__photograph', 'um_account_tab__photograph' );
function um_account_tab__photograph( $info ) {
	global $ultimatemember;
	extract( $info );

	$output = $ultimatemember->account->get_tab_output( 'photograph' );
	if ( $output ) {
		echo $output;
	}
}

/* Finally we add some content in the tab */

add_filter( 'um_account_content_hook_photograph', 'um_account_content_hook_photograph' );
function um_account_content_hook_photograph( $output ) {
	$upload_page = get_page_by_title( 'Upload' );

	ob_start();
	?>
    <a href="<?= get_permalink( $upload_page->ID ) ?>" class="btn btn-primary">Add new photograph</a>
	<?php

	$output .= ob_get_contents();
	ob_end_clean();

	return $output;
}
