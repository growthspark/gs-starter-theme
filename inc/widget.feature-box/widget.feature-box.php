<?php
/**
 * Custom text widget with support for "Read More" links and featured images.
 * 
 * @author Sean Butze
 */

/**
 * Creates the widget
 */
class GS_Feature_Box extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'gs_feature_box', // Base ID
			'Feature Box', // Name
			array( 'description' => __( 'Adds a Feature Box widget, an enhanced text widget with support for "Read More" links and featured images.', 'text_domain' ), ) // Args
		);

		add_action( 'admin_print_styles-widgets.php', array($this, 'uploader_enqueue_scripts') );
		add_action('admin_head-media-upload-popup', array($this, 'upload_window_stlyes'));
	}

	/**
	 * Load scripts & styles
	 */
	public function uploader_enqueue_scripts( $hook_suffix ) {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script( 'feature-box-uploader', get_template_directory_uri() . '/inc/widget.feature-box/js/feature-box-uploader.js', array('media-upload', 'thickbox'), '1', false );
		wp_enqueue_style( 'feature-box-styles', get_template_directory_uri() . '/inc/widget.feature-box/css/gs-feature-box.css');
	}

	/**
	 * Load styles for image upload window
	 */
	public function upload_window_stlyes( $hook_suffix ) {
		wp_enqueue_style( 'feature-box-styles', get_template_directory_uri() . '/inc/widget.feature-box/css/feature-box-uploader.css');
	}


	/**
	 * Tests for presence of http in URL to determine output.
	 *
	 * @param $url  URL to be tested.
	 */

	public function url_test($url) {

		$urltest = substr($url, 0, 7);  // Grab first 7 characters of the link URL

		if ( $urltest == 'http://') {   // If link URL starts with http://, use as-is

			$newurl = $url;

		} else {  // Otherwise, build an absolute URL

			$newurl = get_bloginfo('url');
			$newurl .= '/';
			$newurl .= $url;
		}

		return $newurl;

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
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$linktext = $instance['linktext'];
		$url = $instance['url'];
		$url = $this->url_test($url);
		if ( isset($instance['image'] ) && ($instance['image'] != '') ) {
			$image = $instance['image'];
		} 
		// Un-comment to  display a default image when no image is set
		/*else {
			$image = get_template_directory_uri() . '/img/feature-box-default.jpg';
		}*/  

		echo $before_widget; ?>
		<div class="feature-box">

		<?php 
		if (isset($image)) : ?>
			<img class="feature-box-image" src="<?php echo $image; ?>">
		<?php endif; ?>

		<?php
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>

	
		<div class="feature-box-content">
			<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
		</div>
		
		<?php
		if ( $linktext != '' ) { 
			?>
			<div class="feature-box-btn">
				<a class="feature-box-link" href="<?php echo $url; ?>"><?php echo $linktext; ?> >></a>
			</div>
			<?php
		} 
		?>
		</div>

		<?php
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
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image'] = esc_url($new_instance['image']);
		$instance['linktext'] = strip_tags( $new_instance['linktext'] );
		$instance['url'] = strip_tags( $new_instance['url'] );

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);

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
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'text_domain' );
		}
		if ( isset( $instance[ 'text' ] ) ) {
			$text = esc_textarea($instance['text']);
		} else {
			$text = '';
		}
		if ( isset( $instance[ 'linktext' ] ) ) {
			$linktext = $instance[ 'linktext' ];
		} else {
			$linktext = __( 'Read More', 'text_domain' );
		}
		if ( isset( $instance[ 'url' ] ) ) {
			$url = $instance[ 'url' ];
		} else {
			$url = __( '#', 'text_domain' );
		}
		if ( isset( $instance[ 'image' ] ) ) {
			$image = esc_url($instance[ 'image' ]);
		} else {
			$image = __( '', 'text_domain' );
		}
		
		$siteurl = get_bloginfo('url');
		$image = $image;

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>

		<!--<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image URL:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
		<small>Relative to site root.</small>
		</p>-->

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image:' ); ?></label> 
			<input class="widefat feature-box-img-url-field" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="hidden" value="<?php echo esc_attr( $image ); ?>" />
			<input type="button" id="feature-box-upload-button" class="button-secondary media-library-upload" rel="<?php echo $this->get_field_name( 'image' ); ?>" alt="Add Image" value="Add Image" <?php if ( $image != '' ) { echo 'style="display:none;"';} ?> />
			<input type="button" class="button-secondary media-library-remove" rel="<?php echo $this->get_field_name( 'image' ); ?>-del" value="Remove Image" <?php if ( $image == '' ) { echo 'style="display:none;"';} ?> />'
			<img class="fbox-upload-widget-image-preview" name="<?php echo $this->get_field_name( 'image' ); ?>" src="<?php echo esc_attr( $image ); ?>">

		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'linktext' ); ?>"><?php _e( 'Link Text:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'linktext' ); ?>" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?php echo esc_attr( $linktext ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Link URL:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		<small>For external links, http:// is required.</small>
		</p>

		<?php 
	}

} // class GS_Feature_Box

// register GS_Feature_Box widget
add_action( 'widgets_init', create_function( '', "register_widget( 'GS_Feature_Box' );" ) );