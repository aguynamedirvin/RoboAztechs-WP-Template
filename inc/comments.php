<?php
/**
 * CUSTOM COMMENT
 */
function roboaztechs_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	?>
	<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<a class="avatar" href="">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</a>
		
		<article id="comment-<?php comment_ID(); ?>" class="comment-content">

			<a href="" class="author"><?php comment_author(); ?></a>

			<div class="metadata">
				<span class="date"><?php comment_date('F j, Y \a\t g:i a '); ?></span>
			</div>

			<div class="text"><?php comment_text(); ?></div>

			<div class="actions">
					<a class="reply" href="#"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'roboaztechs' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></a>
			</div>
		</article>
	</div>
<?php
} //roboaztechs_comments