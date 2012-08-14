<?php get_header(); ?>

<div id="feature" class="row feature-row">
	<div id="slideshow">

	   		<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

	   			<?php get_template_part('parts/slider'); ?>

			<?php endwhile; endif; wp_reset_query(); ?>


	</div><!--/ #slideshow -->
</div><!-- / #feature -->


<?php get_sidebar(); ?>
				
<?php get_footer(); ?>