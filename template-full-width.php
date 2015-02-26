<?php
/**
 * Template Name: Full Width
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="full-width">
		<?php get_template_part('templates/page', 'header'); ?>
		<?php get_template_part('templates/content', 'page'); ?>
	</div>
<?php endwhile; ?>