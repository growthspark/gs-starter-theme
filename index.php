<?php get_header(); ?>

			<div class="row">
				<div id="main-col" class="eight columns">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article>
						<h1><?php the_title(); ?></h1>
						<p class="article-info">by <?php the_author();?> on <?php the_date(); ?> <?php gs_comment_count(); ?></p>
						
						<?php the_content(); ?>

					</article>

					<div id="comments">
						<?php comments_template(); ?>
					</div>

				<?php endwhile; endif; ?>

				</div><!--/ #main-col -->

				<?php get_sidebar(); ?>

			</div><!--/ .row -->

<?php get_footer(); ?>