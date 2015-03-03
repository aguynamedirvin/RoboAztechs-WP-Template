<?php

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
			$title		= 	esc_attr($instance['title']);
			$textarea	=	esc_textarea($instance['textarea']);

			$facebook	=	esc_attr($instance['facebook']);
			$twitter	=	esc_attr($instance['twitter']);
			$instagram	=	esc_attr($instance['instagram']);
			$youtube	=	esc_attr($instance['youtube']);

		} else {
			$title		= '';
			$textarea	= '';

			$facebook	= '';
			$twitter	= '';
			$instagram 	= '';
			$youtube	= '';
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
 * Add Recent Posts Widget.
 */


/* ----------------------------------------------------------------------------------
	Recent Posts
---------------------------------------------------------------------------------- */

class roboaztechs_widget_recentposts extends WP_Widget {

	/* Register widget description. */
	function roboaztechs_widget_recentposts() {
		$widget_ops = array('classname' => 'roboaztechs_widget_recentposts', 'description' => 'Display your recent posts.' );
		$this->WP_Widget('roboaztechs_widget_recentposts', 'RoboAztechs: Recent Posts', $widget_ops);
	}

	/* Add widget structure to Admin area. */
	function form($instance) {
		$default_entries = array( 
			'title'			=> '', 
			'postcount'		=> '3',
			'postauthor'	=> 'on', 
			'postDate'		=> '', 
		);
		$instance = wp_parse_args( (array) $instance, $default_entries );

		$title		= $instance['title'];
		$postcount	= $instance['postcount'];
		$postauthor	= $instance['postauthor'];
		$postDate	= $instance['postDate'];

	?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'roboaztechs' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e( 'Number of posts to show:', 'roboaztechs' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" type="text" value="<?php echo $postcount; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $postauthor, "on" ); ?> id="<?php echo $this->get_field_id( 'postauthor' ); ?>" name="<?php echo $this->get_field_name( 'postauthor' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'postauthor' ); ?>"><?php _e( 'Show post author?', 'roboaztechs' ); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $postDate, "on" ); ?> id="<?php echo $this->get_field_id( 'postDate' ); ?>" name="<?php echo $this->get_field_name( 'postDate' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'postDate' ); ?>"><?php _e( 'Show publish date?', 'roboaztechs' ); ?></label></p>

	<?php
	}

	/* Assign variable values. */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title']		= $new_instance['title'];
		$instance['postcount']	= $new_instance['postcount'];
		$instance['postauthor']	= $new_instance['postauthor'];
		$instance['postDate']	= $new_instance['postDate'];

		return $instance;
	}

	/* Output widget to front-end. */
	function widget($args, $instance) {
	global $post;

		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? __( 'Recent Posts', 'roboaztechs' ) : apply_filters('widget_title', $instance['title']);
		if (!empty($title))
			echo $before_title . $title . $after_title;


		$posts = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'		=> $instance['postcount'],
			'no_found_rows'			=> true,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> true,
		) ));

		//$posts = new WP_Query('orderby=date&posts_per_page=' . $instance['postcount'] . '');

		if ($posts->have_posts()) :
			echo '<div class="widget_recent-posts"><ul>';
				while ($posts->have_posts()) : $posts->the_post();
?>

					<li>
						<div class="article-img">
							<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
								<?php echo get_the_post_thumbnail( $post->ID, array(100, 75) ); ?>
							</a>
						</div>
						<div class="article-meta">
							<h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
							
							<?php if ( $instance['postauthor'] ||  $instance['postDate'] ) : ?>
							<p class="entry-meta">
								<?php if ( $instance['postauthor'] ) : ?>
									By
									<span class="byline author vcard">
										<?php the_author_posts_link(); ?>
									</span>
								<?php endif; ?>
								<?php if ( $instance['postDate'] ) : ?>
									<time class="updated published entry-time" datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished"> &#8212; <?php the_time(get_option('date_format')); ?></time>
								<?php endif; ?>
							</p>
							<?php endif; ?>
						</div>
					</li>

<?php
				endwhile;
			echo '<ul></div>', $after_widget;
		endif;
	}
	 
}	//roboaztechs_widget_recentposts end





/**
	*
	*	REGISTER ALL THE WIDGETS
	*
**/
function roboaztechs_register_widgets() {
	register_widget( 'roboaztechs_widget_recentposts' );
	register_widget( 'roboaztechs_footer_social' );
}
add_action( 'widgets_init', 'roboaztechs_register_widgets' );