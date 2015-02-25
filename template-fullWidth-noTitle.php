<?php
/**
 * Template Name: Full Width with No Title
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="full-width">
		<?php get_template_part('templates/content', 'page'); ?>
	</div>
<?php endwhile; ?>