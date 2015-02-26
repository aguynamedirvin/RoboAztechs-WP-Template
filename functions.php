<?php 


/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 */
if ( ! isset( $content_width ) ) {
	$content_width = 733;
}


/**
 * SET UP THEME DEFAULTS AND REGISTER SUPPORT FOR VARIOUS WORDPRESS FEATURES
 */
if ( ! function_exists( 'roboaztechs_setup' ) ) :

	function roboaztechs_setup() {

		/**
		 * LET WORDPRESS HANDLE THE TITLE TAG
		 */
		add_theme_support( 'title-tag' );

		/**
		 * REGISTER NAVIGATION MENUS
		 */
		register_nav_menus(
			array(
				'header-nav' =>  'Header Menu',
				'footer-nav' =>  'Footer Menu'
			)
		);

		/**
		 * SUPPORT FOR THUMMNAILS & CUSTOM IMAGES
		 */
		add_theme_support( 'post-thumbnails' ); 
		add_image_size( 'article-thumb', 100, 75, true );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 *	to output valid HTML5.
		 */
		add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption'] );

		// ----not sure what this shit function is for but it's needed
		add_editor_style();

	}

endif; // roboaztechs_setup
add_action( 'after_setup_theme', 'roboaztechs_setup' );

/**
 * REGISTER SIDEBARS / WIDGETIZED AREAS
 */
function roboaztechs_widgets() {
	register_sidebar( array(
		'name'			=> 'Primary Sidebar',
		'id'			=> 'right-sidebar',
		'description'	=> 'Main sidebar that appears on the right.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4 class="widget-title">',
		'after_title'	=> '</h4>',
	) );

	register_sidebar( array(
		'name'			=> 'Footer Widget Area',
		'id'			=> 'footer_widgets',
		'description'	=> 'Appears in the footer section of the site.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4 class="widget-title">',
		'after_title'	=> '</h4>',
	) );

}
add_action( 'widgets_init', 'roboaztechs_widgets' );


/**
 * IMPORT NECESSARY FILES
 */
$roboaztechs_includes = array (
	'inc/wrapper.php',		// Theme wrapper
	'inc/widgets.php',		// Custom theme widgets
	'inc/sidebar.php',		// Choose where sidebar is displayed
	'inc/comments.php'		// Comment template
);


/**
 * ADD SUPPORT FOR SOIL
 */
add_theme_support('soil-clean-up');			// Enable clean up from Soil
add_theme_support('soil-relative-urls');	// Enable relative URLs from Soil
add_theme_support('soil-nice-search');		// Enable nice search from Soil


foreach ($roboaztechs_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'roboaztechs'), $file), E_USER_ERROR);
	}
	require_once $filepath;
}
unset($file, $filepath);



/**
 * REGISTER GOOGLE FONTS
 */
function roboaztechs_fonts() {
	$font_url = '';
	if (wp_is_mobile() === true) {
		$query_args = array(
			'family' => urlencode( 'Oswald:400' ),
		);
	} else {
		$query_args = array(
			'family' => urlencode( 'Open+Sans:400|Raleway:300,600|Crimson+Text:400italic|Oswald:400' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
	}
	$font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	return $font_url;
}

/**
 * ENQUECE SCRIPTS AND STYLES FOR FRONT END 
 */
function roboaztechs_scripts() {

	// Load our main stylesheet.
	wp_enqueue_style( 'roboaztechs-style', get_stylesheet_uri(), array(), null );

	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', array(), '1.11.2');
	add_filter('script_loader_src', 'roboaztechs_jquery_local_fallback', 10, 2);

	// Load our Google fonts.
	wp_enqueue_style( 'google-fonts', roboaztechs_fonts(), array(), null );

	// Load FontAwesome icons.
	wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), null, 'screen'  );

	// Load our script for the navigation menu
	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), null, true );
}
add_action('wp_enqueue_scripts', 'roboaztechs_scripts', 100);
//add_action('template_redirect', 'roboaztechs_scripts');

// http://wordpress.stackexchange.com/a/12450
function roboaztechs_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;
  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="/wp-includes/js/jquery/jquery.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }
  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }
  return $src;
}
add_action('wp_head', 'roboaztechs_jquery_local_fallback');

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