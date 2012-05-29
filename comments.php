<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
			<h2><?php _e('Password Protected'); ?></h2>
			<p><?php _e('Enter the password to view comments.'); ?></p>
<?php return;
	}
}
	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>
<!-- You can start editing here. -->
		<?php if ($comments) : ?>
			<h2><?php comments_number('No Comments', '1 Comment', '% Comments' );?></h2>
			<?php foreach ($comments as $comment) : ?>
			<div class="comment">
				<div style="float:left;">
					<?php echo get_avatar( $id_or_email, $size = '64', $default = '' ); ?>
				</div>
				<div class="comment-para" >
					<p><?php comment_author_link() ?>, <?php comment_date('M d, Y') ?> </p> <?php edit_comment_link('Edit Comment','',''); ?>
						<?php if ($comment->comment_approved == '0') : ?>
						<em><?php _e('Your comment is awaiting moderation.'); ?></em>
		<?php endif; ?>
							<?php comment_text() ?>
				</div>
			</div>
		<?php /* Changes every other comment to a different class */
							if ('alt' == $oddcomment) $oddcomment = '';
								else $oddcomment = 'alt';
		?>
		<?php endforeach; /* end for each comment */ ?>
		<?php else : // this is displayed if there are no comments so far ?>
				<?php if ('open' == $post->comment_status) : ?><!-- If comments are open, but there are no comments. -->
				
				<?php else : // comments are closed ?><!-- If comments are closed. -->
					<p class="nocomments">Comments are closed.</p>
				<?php endif; ?>
		<?php endif; ?>
				<?php if ('open' == $post->comment_status) : ?>
						<h3 id="comment">Leave a Comment</h3>
						<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
							<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
						<?php else : ?>
							<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<?php if ( $user_ID ) : ?>
									<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
									<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
									</p>
										<?php else : ?>
							<form id="commentform">
								<div style="width:450px;">
									<p id="comment_form">
										<label for="author">YOUR NAME: </label>
										<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
									</p>
									<p id="comment_form">
										<label for="email">YOUR EMAIL ADDRESS: </label>
										<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
									</p>
									<p id="comment_form">
										<label for="url">YOUR WEBSITE: </label>
										<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
									</p>
								</div>
						<?php endif; ?>
						<!--
							<p><small><strong>XHTML:</strong> 
							<?php// _e('You can use these tags&#58;'); ?> 
							<?php// echo allowed_tags(); ?></small></p>
						-->
								<div class="msg-box" style="width:450px; float:left;">
									<label>YOUR Message: </label>
									<p><textarea name="comment" id="comment" cols="50" rows="5" tabindex="4"></textarea></p>
									<span id="comment_submit">
										<input name="submit" type="submit" id="submit" tabindex="5" value="Submit" placeholder="Comments" />
									</span>
									<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
								</div>
							</form>
								<?php do_action('comment_form', $post->ID); ?>
							</form>
	<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>