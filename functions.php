<?php 

if ( ! isset( $content_width ) ) {
	$content_width = 1120;
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
		 * SUPPORT FOR THUMMNAILS & CUSTOM IMAGES
		 */
		add_theme_support( 'post-thumbnails' ); 
		add_image_size( 'article-thumb', 100, 75, true );


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
		 * Switch default core markup for search form, comment form, and comments
		 *	to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

	}

endif; // roboaztechs_setup
add_action( 'after_setup_theme', 'roboaztechs_setup' );


/**
 * REGISTER SIDEBARS AND WIDGETIZED AREAS
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

	// Load our Google fonts.
	wp_enqueue_style( 'google-fonts', roboaztechs_fonts(), array(), null );

	// Load FontAwesome icons.
	wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), null, 'screen'  );

	// Load our script for the navigation menu
	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), null, true );
}
add_action('template_redirect', 'roboaztechs_scripts');

/**
 * CUSTOM COMMENTS
 */
function roboaztechs_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	?>
	<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<a class="avatar" href="">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</a>
		
		<article id="comment-<?php comment_ID(); ?>" class="comment-content">

			<a href="" class="author"><?php comment_author(); ?></a>

			<div class="metadata">
				<span class="date"><?php comment_date('F j, Y \a\t g:i a '); ?></span>
			</div>

			<div class="text"><?php comment_text(); ?></div>

			<div class="actions">
					<a class="reply" href="#"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'roboaztechs' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></a>
			</div>
		</article>
	</div>
<?php
} //roboaztechs_comments


/**
 * IMPORT FILES
 */
$roboaztechs_includes = array (
	'inc/widgets.php',		// Custom theme widgets
	'inc/wrapper.php',		// Theme wrapper
	'inc/sidebar.php',		// Chosee where sidebar is displayed
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