<!--BEGIN SIDEBARS -->


<?php if( is_front_page() ):?>

	<aside id="home-widgets" class="row">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Widgets') ); ?>

	</aside>
	
<?php elseif ( is_home() || is_archive() || is_singular('post') ):?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ): ?>
		<?php endif; ?>	

	</aside>	

<?php else:?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Sidebar') ): ?>
		<?php endif; ?>	
	</aside>

<?php endif;?>

<!--END SIDEBAR-->