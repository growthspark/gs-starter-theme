<?php
/**************************************************************

Recent Posts ++ :: Growth Spark Theme Version

An Enhanced Recent Posts Widget

v1.0

Created by Sean Butze for Growth Spark

***************************************************************/

/* ----------------------------------------------------------
Register the plugin stylesheets
------------------------------------------------------------- */
function queue_gsrp_admin_scripts() {
    wp_register_style( 'gsrp-admin-styles', get_template_directory_uri() .'/includes/widget.gs-recent-posts/css/gsrp-admin.css', array(), '1', 'all' );
    wp_enqueue_style( 'gsrp-admin-styles' );

}
	add_action('admin_enqueue_scripts', 'queue_gsrp_admin_scripts', 1);

function queue_gsrp_scripts() {
	if ( !is_admin() ) {
	    wp_register_style( 'gsrp-styles', get_template_directory_uri() .'/includes/widget.gs-recent-posts/css/gs-recent-posts.css', array(), '1', 'all' );
	    wp_enqueue_style( 'gsrp-styles' );
	}

}
	add_action('wp_enqueue_scripts', 'queue_gsrp_scripts', 1);

/* ----------------------------------------------------------
Set Thumbnail Size
------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
	add_image_size('gsrp_thumb', 75, 75, true);
}	


/* ----------------------------------------------------------
Excerpt Length Function
------------------------------------------------------------- */
function gsrp_excerpt_length($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "</p>";
   }
   else {
      echo "<p>";
      echo $content;
      echo "</p>";
   }
}

/* ----------------------------------------------------------
Create the Widget
------------------------------------------------------------- */
class Widget_GS_Recent_Posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'recent_posts_plus_plus', // Base ID
			'Recent Posts', // Name
			array( 'description' => __( 'Displays a list of your most recent posts.', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$numposts = $instance['num_posts'];
		$post_type = $instance['post_type'];
		$date_format = $instance['date_format'];
		$excerpt = $instance['excerpt_length'];
		$thumbnail = $instance['thumbnail'];

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		$recentquery = new WP_Query(array ('post_type' => $post_type, 'posts_per_page' => $numposts)); 
		$ctr = 0;
			while ($recentquery->have_posts() ) : $recentquery->the_post();
			$ctr += 1;
			?>

			<div class="gsrp-post gsrp-post-<?php echo $ctr; ?>">

				<?php if ( $thumbnail != 'none' && $thumbnail != '' ) { ?>

					<div class="gsrp-thumb <?php echo $thumbnail; ?>"><?php the_post_thumbnail('rpp_thumb'); ?></div>

				<?php } ?>



				<?php if ( $date_format != 'none' && $date_format != '' ) { ?>

					<div class="gsrp-date"><?php the_time($date_format); ?></div>

				<?php } ?>

					<h4 class="gsrp-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

				<?php
				if ( $excerpt > 0 ) { ?>
					<div class="gsrp-excerpt">
						<?php gsrp_excerpt_length($excerpt); ?>
					</div>
					<div class="gsrp-more">
						<a href=
						"<?php the_permalink(); ?>" class="gsrp-more-link">Read More</a>
					</div>

				<?php }  ?>
			</div>
			<?php endwhile; ?>
			<?php wp_reset_query();



		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( );
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['num_posts'] = intval($new_instance['num_posts']);
		$instance['excerpt_length'] = intval($new_instance['excerpt_length']);
		$instance['date_format'] = strip_tags($new_instance['date_format']);
		$instance['thumbnail'] = strip_tags($new_instance['thumbnail']);

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( ) );
		$title = esc_attr( $instance['title'] );
		$excerpt_length = esc_attr( $instance['excerpt_length'] );


		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Select Post Type:'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
			<option value="post">Posts (default)</option>

			<?php

			$args=array(
				  '_builtin' => false
			); 
			$post_types = get_post_types( $args ); // get all CPTs
			//print_r($post_types);

			foreach ( $post_types as $post_type ) {
				$obj = get_post_type_object($post_type);
				$post_type_id = $obj->name;
				$post_type_name = $obj->labels->name;
				echo '<option value="' . $post_type_id . '"'
					. (  $post_type_id == $instance['post_type'] ? ' selected="selected"' : '' )
					. '>' . $post_type_name . "</option>\n";
			}
			?>
			</select>
		</p>  


		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('# of Posts:'); ?></label>
			<select class="widefat" id="gsrp-num-posts" name="<?php echo $this->get_field_name('num_posts'); ?>">

			<?php
			for ($i = 1; $i <= 10; $i++) {

				echo '<option value="' . intval($i) . '"'
					. ( $i == $instance['num_posts'] ? ' selected="selected"' : '' )
					. '>' . $i . "</option>\n";
			}
			?>
			</select>
		</p> 


		<p>
			<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt Length:'); ?></label> 
			<input class="widefat" id="gsrp-excerpt-length" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" />
			[ 0 = No Excerpt ]
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('date_format'); ?>"><?php _e('Date Format:'); ?></label>

			<select class="widefat" id="gsrp-date-format" name="<?php echo $this->get_field_name('date_format'); ?>">
			
				<option value="none">(no date)</option>

				<?php
				$dates = array(
					'F j, Y' => 'May 1, 2012', 
					'F j' => 'May 1', 
					'm/d/Y' => '5/1/2012', 
					'm/d/y' => '5/1/12'
					);
				
				foreach ($dates as $k => $v) {
					echo '<option value="' . $k . '"'
						. ( $k == $instance['date_format'] ? ' selected="selected"' : '' )
						. '>' . $v . "</option>\n";
				}
				
				?>
			</select>
		</p> 

		<p>
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Thumbnails:'); ?></label>

			<select class="widefat" id="gsrp-thumbnail-field" name="<?php echo $this->get_field_name('thumbnail'); ?>">
			
				<option value="none">(no thumbnails)</option>

				<?php
				$thumbs = array(
					'gsrp-thumb-left' => 'Left Aligned', 
					'gsrp-thumb-right' => 'Right Aligned', 
					'gsrp-thumb-noalign' => 'No Alignment'
					);
				
				foreach ($thumbs as $a => $b) {
					echo '<option value="' . $a . '"'
						. ( $a == $instance['thumbnail'] ? ' selected="selected"' : '' )
						. '>' . $b . "</option>\n";
				}
				
				?>
			</select>
		</p> 


	<?php
	}

}

// register the widget
add_action( 'widgets_init', create_function( '', "register_widget( Widget_GS_Recent_Posts );" ) );

?>