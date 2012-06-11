<!--BEGIN SIDEBARS -->

<?php if( is_front_page() ):?>

	<aside id="home-widgets" class="row">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Widgets') ): 

				gs_default_home_widgets();

		endif; ?>

	</aside>
	
<?php elseif ( is_singular('post') ):?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ) :

				gs_default_sidebar_widgets();

		endif; ?>
	</aside>	

<?php else:?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Sidebar') ) :

				gs_default_sidebar_widgets();

		endif; ?>	
	</aside>

<?php endif;?>

<!--END SIDEBAR-->