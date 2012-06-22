<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

<div id="feature" class="row feature-row">
	<div id="slideshow">
		<?php $slides = new WP_Query(array( 'post_type' => 'slide')); ?>


	   		<?php if ($slides->have_posts() ): while ($slides->have_posts() ) : $slides->the_post(); ?>

				<div class="slide clearfix">
					<div class="slide-text five columns">
						<div class="container float-left">
							<h1><?php the_title();?></h1>
							<?php the_content();?>
						</div>
					</div>
				</div><!--/ .slide -->

			<?php endwhile; endif; wp_reset_query(); ?>


	</div><!--/ #slideshow -->
</div><!-- / #feature -->


<?php get_sidebar(); ?>
				
<?php get_footer(); ?>