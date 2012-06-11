<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

<div id="feature" class="row">
	<div id="slideshow">
		<?php $slides = new WP_Query(array( 'post_type' => 'slide')); ?>

		<?php if ($slides->have_posts() ): ?>

	   		<?php while ($slides->have_posts() ) : $slides->the_post(); ?>

				<div class="slide clearfix">
					<div class="slide-text five columns">
						<div class="container float-left">
							<h1><?php the_title();?></h1>
							<?php the_content();?>
						</div>
					</div>
				</div><!--/ .slide -->

			<?php endwhile; wp_reset_query(); ?>
		<?php else: ?>

				<div class="slide clearfix">
					<div class="slide-text five columns">
						<div class="container float-left">
							<h1>Lorem ipsum dolor sit amet</h1>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
					</div>
				</div><!--/ .slide -->
				<div class="slide clearfix">
					<div class="slide-text five columns">
						<div class="container float-left">
							<h1>Dolore magna aliquam erat volutpat.</h1>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
						</div>
					</div>
				</div><!--/ .slide -->

		<?php endif; ?>

	</div><!--/ #slideshow -->
</div><!-- / #feature -->


<?php get_sidebar(); ?>
				
<?php get_footer(); ?>