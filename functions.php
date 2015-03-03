<?php 

/**
 * Template has many new additions (since version 0.3) from the Roots starter tamplate. Credits go to them for the
 * awesome tool they offer to simplyfy the creation of this template.
 * http://roots.io/
 */


/**
 * IMPORT NECESSARY FILES
 */
$roboaztechs_includes = array (
	'inc/init.php',			// Initial theme setup
	'inc/wrapper.php',		// Theme wrapper
	'inc/sidebar.php',		// Sidebar class
	'inc/config.php',		// Configuration
	'inc/widgets.php',		// Custom theme widgets
	'inc/nav.php',			// Custom navigation
	'inc/scripts.php',		// Scripts and stylesheets
	'inc/comments.php',		// Comment template
);

foreach ($roboaztechs_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'roboaztechs'), $file), E_USER_ERROR);
	}
	require_once $filepath;
}
unset($file, $filepath);


/**
 * CLEAN UP WORDPRESS HEAD
 */
function roboaztechs_head_cleanup() {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

	add_filter('use_default_gallery_style', '__return_null');
}
add_action('init', 'roboaztechs_head_cleanup');


/**
 * CLEAN UP SHORTCODES
 */
function roboaztechs_clean_shortcodes($content){   
	$array = array (
		'<pre><code>[' => '[', 
		']</code></pre>' => ']',  
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'roboaztechs_clean_shortcodes');