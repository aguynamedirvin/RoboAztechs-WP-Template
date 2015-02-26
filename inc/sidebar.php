<?php
/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 *
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @link http://roots.io/the-roots-sidebar/
 *
 * @param array list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 */
class roboaztechs_Sidebar {
	private $conditionals;
	private $templates;

	public $display = true;

	function __construct($conditionals = array(), $templates = array()) {
		$this->conditionals = $conditionals;
		$this->templates    = $templates;

		$conditionals = array_map(array($this, 'check_conditional_tag'), $this->conditionals);
		$templates    = array_map(array($this, 'check_page_template'), $this->templates);

		if (in_array(true, $conditionals) || in_array(true, $templates)) {
		  $this->display = false;
		}
	}

	private function check_conditional_tag($conditional_tag) {
	$conditional_arg = is_array($conditional_tag) ? $conditional_tag[1] : false;
	$conditional_tag = $conditional_arg ? $conditional_tag[0] : $conditional_tag;

	if (function_exists($conditional_tag)) {
			return $conditional_arg ? $conditional_tag($conditional_arg) : $conditional_tag();
		} else {
			return false;
		}
	}

	private function check_page_template($page_template) {
		return is_page_template($page_template) || roboaztechs_Wrapping::$base . '.php' === $page_template;
	}
}

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
			 * Any of these conditional tags that return true won't show the sidebar.
			 * You can also specify your own custom function as long as it returns a boolean.
			 *
			 * To use a function that accepts arguments, use the following format:
			 *
			 * ['function_name', ['arg1', 'arg2']]
			 *
			 * Note: The second element must be an array even if there's only 1 argument.
			 *
			 * Examples:
			 *
			 * 'is_single'
			 * 'is_archive'
			 * ['is_page', ['about-me']]
			 * ['is_tax', ['flavor', 'mild']]
			 * ['is_page_template', ['about.php']]
			 * ['is_post_type_archive', [['foo', 'bar', 'baz']]]
			 *
			 */
			[
		  		'is_404',
		  		[ 'is_page_template', [ 'full-width', 'full-width-no-title' ]]
			]
		);
		$display = apply_filters('roots/display_sidebar', $sidebar_config->result);
	}  

	return $display;
}