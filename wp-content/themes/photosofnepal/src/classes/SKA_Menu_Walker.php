<?php


class SKA_Menu_Walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= "</span><ul class='dropdown-menu-item'>";
	}

	function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;

		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
			if ( $depth == 0 ) {
				$classes[] = 'active';
			}
		}

		$output .= "<li class='" . implode( $classes, ' ' ) . "'>";

		if ( $args->walker->has_children ) {
			$output .= "<a href='" . $item->url . "'>";
		} else {
			$output .= "<a href='" . $item->url . "'>";
		}

		$output .= $item->title;

		$output .= "</a>";
	}
}
