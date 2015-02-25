<?php while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" class="hentry" <?php post_class( 'cf' ); ?> role="article">

		<header class="entry-header">
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
			
			<p class="byline entry-meta vcard">
				<?php /* the author of the post */ ?>
				By 
				<span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">
					<?php the_author_posts_link(); ?>
				</span>
				<?php /* the time the post was published */ ?>
				<time class="updated published entry-time" datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished"> &#8212; <?php the_time(get_option('date_format')); ?></time>
			</p>
		</header>

		<div class="entry-content cf">
			<?php the_content(); ?>
		</div>

		<div class="author-info">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
			</div>
			<div class="author-meta">
				<h3 class="author-name"><?php the_author_posts_link(); ?></h3>
				<p><?php the_author_meta('description'); ?></p>
			</div>
		</div>

	</article>

	<?php comments_template('/templates/comments.php'); ?>

<?php endwhile; ?>