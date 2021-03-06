<?php 
/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * roboaztechs_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 *
 *	Walker by Roots (http://roots.com/)
 */
class roboaztechs_Nav_Walker extends Walker_Nav_Menu {
	function check_current($classes) {
		return preg_match('/(current[-_])|active|dropdown/', $classes);
	}

	// If has dropdown
	/*function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_html = '';
		parent::start_el($item_html, $item, $depth, $args);

		if ($item->is_dropdown && ($depth === 0)) {
			$item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html);
			$item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
		}
		elseif (stristr($item_html, 'li class="divider')) {
			$item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
		}
		elseif (stristr($item_html, 'li class="dropdown-header')) {
			$item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
		}

		$item_html = apply_filters('roboaztechs/wp_nav_menu_item', $item_html);
		$output .= $item_html;
	} */
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

		if ($element->is_dropdown) {
			$element->classes[] = 'dropdown';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

	}

}

/**
 * Return 'menu-slug' for nav menu classes
 * Remove the id="" on nav menu items
 */
function roboaztechs_nav_menu_css_class($classes, $item) {
	$slug = sanitize_title($item->title);
	$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
	$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

	$classes[] = 'menu-' . $slug;

	$classes = array_unique($classes);

	return array_filter($classes);
}
add_filter('nav_menu_css_class', 'roboaztechs_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');
