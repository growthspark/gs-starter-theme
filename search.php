<?php get_header(); ?>

<?php get_template_part('templates/subpage-top'); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="article-info">by <?php the_author();?> on <?php the_date(); ?> <?php gs_comment_count(); ?></p>
						
						<?php the_excerpt(); ?>

					</article>

				<?php endwhile; endif; ?>

<?php get_template_part('templates/subpage-bottom'); ?>

<?php get_footer(); ?>