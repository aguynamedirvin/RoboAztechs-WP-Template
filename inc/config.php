<?php


/**
 * ADD SUPPORT FOR SOIL
 */
add_theme_support('soil-clean-up');			// Enable clean up from Soil
add_theme_support('soil-relative-urls');	// Enable relative URLs from Soil
add_theme_support('soil-nice-search');		// Enable nice search from Soil

/**
 * Configuration values
 */
define('GOOGLE_ANALYTICS_ID', ''); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)

/**
 * Define which pages shouldn't have the sidebar
 *
 * See top for more details
 */
function roboaztechs_display_sidebar() {
	static $display;

	if (!isset($display)) {
		$sidebar_config = new roboaztechs_Sidebar(
			/**
			 * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
			 * Any of these conditional tags that return true won't show the sidebar
			 *
			 * To use a function that accepts arguments, use the following format:
			 *
			 * array('function_name', array('arg1', 'arg2'))
			 *
			 * The second element must be an array even if there's only 1 argument.
			 */
			array (
				'is_404'
			),
			/**
			 * Page template checks (via is_page_template())
			 * Any of these page templates that return true won't show the sidebar
			 */
			array(
				'template-full-width.php',
				'template-full-width-no-title.php'
			)
		);
		$display = apply_filters('roboaztechs/display_sidebar', $sidebar_config->display);
	}  

	return $display;
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1120;
}