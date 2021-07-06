<?php


class SKA_Responsive_Menu_Walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= "<span class='menu-plus-icon'></span><ul class='side-sub-menu'>";
	}

	function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;

		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
			if ( $depth == 0 ) {
				$classes[] = 'active';
			}
		}

		$classes[] = 'sidenav__item';
		$output    .= "<li class='" . implode( $classes, ' ' ) . "'>";

		if ( $args->walker->has_children ) {
			$output .= "<a href='" . $item->url . "'>";
		} else {
			$output .= "<a href='" . $item->url . "'>";
		}

		$output .= $item->title;

		$output .= "</a>";
	}
}