<?php
/**
	*
	*	RECENT POSTS WIDGET
	*
**/
class roboaztechs_recent_posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "RoboAztechs widget for displaying your site&#8217;s most recent posts with a thumbnail.") );
		parent::__construct(false, __('Recent Posts', 'roboaztechs'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'roboaztechs' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;
		if ( ! $number )
			$number = 3;
		$show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<div class="widget_recent-posts">
			<ul>
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<li>
					<div class="article-img">
						<a href="<?php echo get_post_permalink( get_the_ID() ); ?>">
							<?php echo get_the_post_thumbnail( get_the_ID(), 'article-thumb' ); ?>
						</a>
					</div>
					<div class="article-meta">
						<h2><a href="<?php echo get_post_permalink( get_the_ID() ); ?>">
							<?php get_the_title() ? the_title() : the_ID(); ?>
						</a></h2>
						<?php if ( $show_author ) : ?>
							<p class="entry-meta">
								By
								<span class="byline author vcard">
									<?php the_author_posts_link(); ?>
								</span>
							</p>
						<?php endif; ?>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_author'] = isset( $new_instance['show_author'] ) ? (bool) $new_instance['show_author'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	public function form( $instance ) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		$show_author 	= isset( $instance['show_author'] ) ? (bool) $instance['show_author'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'roboaztechs' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'roboaztechs' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_author ); ?> id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Display post author?', 'roboaztechs' ); ?></label></p>
<?php
	}
}



/**
	*
	*	FOOTER SOCIAL MEDIA LINKS
	*
**/
class roboaztechs_footer_social extends WP_Widget {

	

	// constructor
	function __construct() {
		$widget_ops = array('classname' => 'footer_social_widget', 'description' => __( "Display social icons that link to your social media sites.", 'roboaztechs' ) );
		parent::__construct(false, __('Footer Social Links', 'roboaztechs'), $widget_ops);
	}

	// widget form creation
	function form($instance) {

		// Check values
		if( $instance) {
			$title 		= esc_attr($instance['title']);
			$textarea 	= esc_textarea($instance['textarea']);

			$facebook	= 	esc_attr($instance['facebook']);
			$twitter	= 	esc_attr($instance['twitter']);
			$instagram	= 	esc_attr($instance['instagram']);
			$youtube	= 	esc_attr($instance['youtube']);

		} else {
			$title 		= '';
			$textarea 	= '';

			$facebook 	= '';
			$twitter 	= '';
			$instagram 	= '';
			$youtube 	= '';
		}
?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'roboaztechs'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'roboaztechs'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
		</p>

		<!-- Facebook -->
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:', 'roboaztechs'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" />
		</p>
		<!-- Twitter -->
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:', 'roboaztechs'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" />
		</p>
		<!-- Instagram -->
		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram:', 'roboaztechs'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instagram; ?>" />
		</p>
		<!-- YouTube -->
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube:', 'roboaztechs'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo $youtube; ?>" />
		</p>

<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title']		= strip_tags($new_instance['title']);
		$instance['textarea'] 	= strip_tags($new_instance['textarea']);

		$instance['facebook']	= strip_tags($new_instance['facebook']);
		$instance['twitter']	= strip_tags($new_instance['twitter']);
		$instance['instagram']	= strip_tags($new_instance['instagram']);
		$instance['youtube']	= strip_tags($new_instance['youtube']);

		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$title 		= apply_filters('widget_title', $instance['title']);
		$textarea 	= $instance['textarea'];

		$facebook 	= $instance['facebook'];
		$twitter 	= $instance['twitter'];
		$instagram 	= $instance['instagram'];
		$youtube 	= $instance['youtube'];


		echo $before_widget;
		// Display the widget
		echo '<div class="widget-content">';

		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// Check if they are set

		// Check if textarea is set
		if( $textarea ) {
			echo '<p>' . $textarea . '</p>';
		}

		if( $facebook ) {
			echo '<a class="ftr-scl-icon" href="' . $facebook . '"><i class="fa fa-facebook"></i></a>';
		}
		if( $twitter ) {
			echo '<a class="ftr-scl-icon" href="' . $twitter . '"><i class="fa fa-twitter"></i></a>';
		}
		if( $instagram ) {
			echo '<a class="ftr-scl-icon" href="' . $instagram . '"><i class="fa fa-instagram"></i></a>';
		}
		if( $youtube ) {
			echo '<a class="ftr-scl-icon" href="' . $youtube . '"><i class="fa fa-youtube"></i></a>';
		}

		echo '</div>';
		echo $after_widget;
	}
}


/**
	*
	*	REGISTER ALL THE WIDGETS
	*
**/
function roboaztechs_register_widgets() {
	register_widget( 'roboaztechs_recent_posts' );
	register_widget( 'roboaztechs_footer_social' );
}

add_action( 'widgets_init', 'roboaztechs_register_widgets' );