<?php get_template_part('templates/header'); ?>

	<?php
		/**
		 * Display content class if page has sidebar. If it doesn't have a sidebar then add full-width class
		 */
	?>
	<div class="<?php ( roboaztechs_display_sidebar() ? print 'content' : print 'full-width' ); ?>" />
	
		<?php include roboaztechs_template_path(); ?>

	</div>

	<?php 
	/**
	 * Display sidebar is it's not on functions.php
	 */
	if (roboaztechs_display_sidebar()) : ?>
	
		<?php include roboaztechs_sidebar_path(); ?>
	
	<?php endif; ?>

<?php get_template_part('templates/footer'); ?>