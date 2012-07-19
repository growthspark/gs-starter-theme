<?php get_header(); ?>

<?php get_template_part('templates/subpage-top'); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
					<?php get_template_part('templates/post'); ?>

				<?php endwhile; endif; ?>

<?php get_template_part('templates/subpage-bottom'); ?>

<?php get_footer(); ?>