<?php get_template_part('templates/header'); ?>


	<?php include roboaztechs_template_path(); ?>

	<?php 
	/**
	 * Display sidebar is it's not on functions.php
	 */
	if (roboaztechs_display_sidebar()) : ?>
	
		<?php get_template_part('templates/sidebar'); ?>
	
	<?php endif; ?>

<?php get_template_part('templates/footer'); ?>