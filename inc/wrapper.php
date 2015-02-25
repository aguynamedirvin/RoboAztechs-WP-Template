<?php

/*# License: Public Domain
# I recommend replacing 'roboaztechs_' with your own prefix.

function roboaztechs_template_path() {
	return roboaztechs_Wrapping::$main_template;
}

function roboaztechs_template_base() {
	return roboaztechs_Wrapping::$base;
}


class roboaztechs_Wrapping {

	/**
	 * Stores the full path to the main template file
	 */
/*	static $main_template;

	/**
	 * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	 */
/*	static $base;

	static function wrap( $template ) {
		self::$main_template = $template;

		self::$base = substr( basename( self::$main_template ), 0, -4 );

		if ( 'index' == self::$base )
			self::$base = false;

		$templates = array( 'wrapper.php' );

		if ( self::$base )
			array_unshift( $templates, sprintf( 'wrapper-%s.php', self::$base ) );

		return locate_template( $templates );
	}
}

add_filter( 'template_include', array( 'roboaztechs_Wrapping', 'wrap' ), 99 );*/




/**
* Theme wrapper
*
* @link http://roots.io/an-introduction-to-the-roots-theme-wrapper/
* @link http://scribu.net/wordpress/theme-wrappers.html
*/
function roboaztechs_template_path() {
	return roboaztechs_Wrapping::$main_template;
}
function roboaztechs_sidebar_path() {
	return new roboaztechs_Wrapping('templates/sidebar.php');
}
class roboaztechs_Wrapping {
	// Stores the full path to the main template file
	public static $main_template;
	// basename of template file
	public $slug;
	// array of templates
	public $templates;
	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	static $base;
	public function __construct($template = 'base.php') {
	$this->slug = basename($template, '.php');
		$this->templates = array($template);
		if (self::$base) {
			$str = substr($template, 0, -4);
				array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
			}
	}
	public function __toString() {
		$this->templates = apply_filters('roots/wrap_' . $this->slug, $this->templates);
		return locate_template($this->templates);
	}
	static function wrap($main) {
		// Check for other filters returning null
		if (!is_string($main)) {
			return $main;
		}
		self::$main_template = $main;
		self::$base = basename(self::$main_template, '.php');
		if (self::$base === 'index') {
			self::$base = false;
		}
		return new roboaztechs_Wrapping();
	}
}
add_filter('template_include', array('roboaztechs_Wrapping', 'wrap'), 99);