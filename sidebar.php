<!--BEGIN SIDEBARS -->

<?php if( is_front_page() ):?>

	<aside id="home-widgets" class="row">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Widgets') ) ;?>
	</aside>
	
<?php elseif ( is_singular('post') ):?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ) ;?>
	</aside>	

<?php else:?>

	<aside id="sidebar" class="four columns">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Default Page Sidebar') ) ;?>	
	</aside>

<?php endif;?>

<!--END SIDEBAR-->