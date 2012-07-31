<article <?php post_class(); ?>>

<?php if ( is_single() || is_singular() ) : ?>
	<h1 class="page-title blog-title"><?php the_title(); ?></h1>
<?php else: ?>
	<h2 class="page-title blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php endif; ?>

<p class="article-info">Posted by <span><?php the_author();?></span> on <?php echo get_the_date() . gs_show_categories(); gs_comment_count(); ?></p>


<?php
if ( is_single() || is_singular() ) {
	the_content();
} else {
	gs_content_limit(350);
	?><p><a class="more" href="<?php the_permalink(); ?>">Read more >></a></p><?php
}
?>

</article>