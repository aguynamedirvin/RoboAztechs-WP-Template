<?php
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