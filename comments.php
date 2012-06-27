<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
			<h2><?php _e('Password Protected'); ?></h2>
			<p><?php _e('Enter the password to view comments.'); ?></p>
<?php 		return;
	}
}
	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>
<!-- You can start editing here. -->
<?php 

/* ----------------------------------------------------------
DISPLAY  COMMENTS
------------------------------------------------------------- */

if ($comments) : ?>
	<h3><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>
	<?php foreach ($comments as $comment) : ?>
	<div class="comment clearfix">
		<div style="float:left;">
			<?php 
			echo get_avatar( $comment , '64' ); ?>
		</div>
		<div class="comment-para" >
			<div class="comment-meta"><strong><?php comment_author_link() ?></strong> &nbsp;<span class="comment-date"><?php comment_date('M d Y \a\t g:i A') ?></a> <?php edit_comment_link('[Edit]','',''); ?></div> 
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


<?php 

/* ----------------------------------------------------------
COMMENT FORM
------------------------------------------------------------- */

if ('open' == $post->comment_status) : ?>
		<h3 id="comment">Leave a Comment</h3>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

		<?php else : ?>

		<?php
			// Set defaults for form fields 
			$name = 'your name';
			$email = 'email';
			$url = 'website url';
			$message = 'your message...';
		?>

			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<div class="row no-pad">
						<div class="four columns comments-right">
							<?php if ( $user_ID ) : ?>
								<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
								<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
								</p>
							<?php else : ?>
								<input type="text" name="author" id="author" value="<?php echo $name; ?>" tabindex="1"  onfocus="if (this.value == '<?php echo $name; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $name; ?>';}" />

								<input type="text" name="email" id="email" value="<?php echo $email; ?>" tabindex="2" onfocus="if (this.value == '<?php echo $email; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $email; ?>';}" />

								<input type="text" name="url" id="url" value="<?php echo $url; ?>" tabindex="3" onfocus="if (this.value == '<?php echo $url; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $url; ?>';}" />
							<?php endif; ?>
						</div>

						<div class="eight columns msg-box comments-left">
							<textarea name="comment" id="comment" value="<?php echo $message; ?>" cols="50" rows="5" tabindex="4" onfocus="if (this.value == '<?php echo $message; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $message; ?>';}"><?php echo $message; ?></textarea>
							<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
						</div>

					</div><!--/row -->

				<div class="row no-pad no-top-margin">
					<span id="comment_submit" class="twelve columns">
						<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="Submit" placeholder="Comments" />
					</span>
				</div><!--/row -->


			</form>
				<?php do_action('comment_form', $post->ID); ?>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>