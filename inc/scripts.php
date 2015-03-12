<?php
/**
 * Scripts and stylesheets
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */


/**
 * REGISTER GOOGLE FONTS
 */
function roboaztechs_fonts() {
	$font_url = '';
	if ( wp_is_mobile() ) {
		$query_args = array(
			'family' => urlencode( 'Oswald:400' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
	} else {
		$query_args = array(
			'family' => urlencode( 'Open+Sans:400|Crimson+Text:400italic|Oswald:400' ),
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
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', array(), '1.11.2');
	add_filter('script_loader_src', 'roboaztechs_jquery_local_fallback', 10, 2);

	// Load FontAwesome icons.
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), null, 'screen'  );

	// Load our script for the navigation menu
	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.min.js', array('jquery'), null, true );
	
	// Load our Google fonts.
	wp_enqueue_style( 'google-fonts', roboaztechs_fonts(), array(), null );
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
 * Google Analytics snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 */
function roboaztechs_google_analytics() { ?>
	<script>
		<?php if (WP_ENV === 'production') : ?>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	<?php else : ?>
		function ga() {
		  console.log('GoogleAnalytics: ' + [].slice.call(arguments));
		}
	<?php endif; ?>
		ga('create','<?php echo GOOGLE_ANALYTICS_ID; ?>','auto');ga('send','pageview');
	</script>

<?php }
if (GOOGLE_ANALYTICS_ID && (WP_ENV !== 'production' || !current_user_can('manage_options'))) {
	add_action('wp_footer', 'roboaztechs_google_analytics', 20);
}