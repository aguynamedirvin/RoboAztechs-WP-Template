<article id="post-<?php the_ID(); ?>" class="hentry" <?php post_class( 'cf' ); ?> role="article">
	<div class="entry-content cf">
		<?php the_content(); ?>
	</div>

	<?php comments_template('/templates/comments.php'); ?>

</article>