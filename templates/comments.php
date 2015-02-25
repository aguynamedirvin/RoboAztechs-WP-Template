<div id="comments">
	
	<?php if ( have_comments() ) : ?>

		<h2 id="comments-title"><?php comments_number( 'No Comments', 'One Comment', '% Comments' );?></h2>
		<div class="comment-list">
			<?php wp_list_comments('type=comment&callback=roboaztechs_comments'); ?>
		</div>

	<?php endif; // have_comments() ?>




	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	
		<p class="no-comments"><?php _e( 'Comments are closed.', 'roboaztechs' ); ?></p>
	
	<?php endif; 



	// The comments form
	$commenter 	= wp_get_current_commenter();
	$req 		= (get_option( 'require_name_email' ) ? '*' : '');
	$aria_req	= ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author'		=> '<input class="u-full-width" type="text" id="author" name="author" placeholder="Name' . $req . '" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . '>',
		'email'			=> '<input class="u-full-width" type="email" id="email" name="email" placeholder="Email' . $req . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . '>',
	); 
	$comments_args = array(
	    'fields' 				=>  $fields,
	    'title_reply'			=> 'Leave us comment',
	    'class_submit'			=> 'button-primary',
	    'label_submit'			=> 'Send My Comment',
	    'comment_notes_after'	=> '',
	    'comment_field'			=> '<textarea class="u-full-width" id="comment" name="comment" placeholder="Comment' . $req . '" ' . $aria_req . '></textarea>',
	);

	comment_form($comments_args);

?>

</div><!-- /Comments -->