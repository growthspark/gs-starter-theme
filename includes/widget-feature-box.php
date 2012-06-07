<?php
/* ----------------------------------------------------------

Feature Box Widget :: Growth Spark Theme Version

v1.0

Created by Sean Butze for Growth Spark

Available as a stand-alone plugin at: 
https://github.com/bootsz/wp-feature-box

------------------------------------------------------------- */


class GS_Feature_Box extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		//global $wid, $wname;
		parent::__construct(
	 		'gs_feature_box', // Base ID
			'Feature Box', // Name
			array( 'description' => __( 'Adds a Feature Box widget, an enhanced text widget with support for "Read More" links.', 'text_domain' ), ) // Args
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
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$linktext = apply_filters( 'widget_title', $instance['linktext'] );
		$url = apply_filters( 'widget_title', $instance['url'] );

		$urltest = substr($url, 0, 7);  // Grab first 7 characters of the link URL

		if ( $urltest == 'http://') {   // If link URL starts with http://, use as-is

			$linkurl = $url;

		} else {  // Otherwise, build an absolute URL

			$linkurl = get_bloginfo('url');
			$linkurl .= '/';
			$linkurl .= apply_filters( 'widget_title', $instance['url'] );
		}


		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>

		<div class="feature-box">

			<?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?><?php 

		if ( $linktext != '' ) { 
			?>
			<div class="feature-box-btn">
				<a class="feature-box-link" href="<?php echo $linkurl; ?>"><?php echo $linktext; ?></a>
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

		$text = esc_textarea($instance['text']);
		$siteurl = get_bloginfo('url');

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>

		<label for="<?php echo $this->get_field_id( 'linktext' ); ?>"><?php _e( 'Link Text:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'linktext' ); ?>" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?php echo esc_attr( $linktext ); ?>" />
		</p>

		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Link URL:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		<small>For external links, http:// is required.</small>
		</p>

		<?php 
	}

} // class GS_Feature_Box

// register GS_Feature_Box widget
add_action( 'widgets_init', create_function( '', 'register_widget( GS_Feature_Box );' ) );