<?php get_header(); ?>

<?php get_template_part('parts/subpage-top'); ?>
	
	<h1>Archives<?php 
			if ( is_day() ) {
				echo ': '. get_the_time('F j, Y');
			}
			elseif ( is_month() ) {
				echo ': '. get_the_time('F j, Y');
			}
			elseif ( is_year() ) {
				echo ': '. get_the_time('F j, Y');
			} ?>
	</h1>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
					<?php get_template_part('parts/post'); ?>

				<?php endwhile; endif; ?>

<?php get_template_part('parts/subpage-bottom'); ?>

<?php get_footer(); ?>