<?php
/**
 * Adds a custom Recent Drafts widget to the WP Dashboard
 *
 * Supports all default & custom post types.  Desired post
 * types can be configured in the $types array below.
 *
 *
 */

class GS_Recent_Drafts_Widget {

	/**
	 * Determines which post types to feature in the widget.
	 *
	 * Requires that the post type slug be used.  For instace,
	 * to add Posts you would add "post", and NOT "Post" or 
	 * "Posts".
	 *
	 */
	public $types = array('page', 'post');


	/**
	 * Hooks necessary functions into WP actions
	 *
	 */
	public function __construct()  {  
		add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget') );
		add_action('wp_dashboard_setup', array($this, 'remove_default_recent_drafts_widget') );
	}  

	/**
	 * Creates a list of drafts for a given post type.
	 *
	 */
	public function recent_drafts_loop( $drafts = false, $type ) {

		$post_type = get_post_type_object($type);
		$type_label = $post_type->labels->name; 
		$numposts = 3;

		if ( !$drafts ) {

			// Gets all drafts
			$all_drafts_query = new WP_Query( array(
				'post_type' => $type,
				'post_status' => 'draft',
				'author' => $GLOBALS['current_user']->ID,
				'orderby' => 'modified',
				'order' => 'DESC'
			) );

			// Gets only the drafts to display
			$drafts_query = new WP_Query( array(
				'post_type' => $type,
				'post_status' => 'draft',
				'author' => $GLOBALS['current_user']->ID,
				'posts_per_page' => $numposts,
				'orderby' => 'modified',
				'order' => 'DESC'
			) );
			$drafts =& $drafts_query->posts;
			$total_drafts =& $all_drafts_query->posts;
		}

		if ( $drafts && is_array( $drafts ) ) {
			$list = array();
			foreach ( $drafts as $draft ) {
				$url = get_edit_post_link( $draft->ID );
				$title = _draft_or_post_title( $draft->ID );
				$item = "<h4><a href='$url' title='" . sprintf( __( 'Edit &#8220;%s&#8221;' ), esc_attr( $title ) ) . "'>" . esc_html($title) . "</a></h4> <abbr title='" . get_the_time(__('Y/m/d g:i:s A'), $draft) . "'><small>" . get_the_time( get_option( 'date_format' ), $draft ) . '</small></abbr>';
				if ( $the_content = preg_split( '#\s#', strip_tags( $draft->post_content ), 11, PREG_SPLIT_NO_EMPTY ) )
					$item .= '<p>' . join( ' ', array_slice( $the_content, 0, 10 ) ) . ( 10 < count( $the_content ) ? '&hellip;' : '' ) . '</p>';
				$list[] = $item;
			}
	?>
		<div class="table table_content">
			<p class="sub"><?php echo $type_label; ?></p>
			<ul>
				<li><?php echo join( "</li>\n<li>", $list ); ?></li>
			</ul>
			<?php if ( count($total_drafts) > $numposts ) : ?>
				<p><a href="edit.php?post_status=draft&post_type=<?php echo $type; ?>" ><?php _e('View all'); ?> &rarr;</a></p>
			<?php endif; ?>
		</div>
		<?php
		}
	}

	/**
	 * Generates the widget content
	 *
	 */
	public function recent_drafts( $drafts = false ) {
		?>
		<div class="wrapper clearfix">

			<?php

			$types = $this->types;

			$all_drafts_query = new WP_Query( array(
				'post_type' => $types,
				'post_status' => 'draft',
				'author' => $GLOBALS['current_user']->ID,
				'posts_per_page' => 5,
				'orderby' => 'modified',
				'order' => 'DESC'
			) );

			$are_drafts =& $all_drafts_query->posts;

			if ( $are_drafts and is_array($are_drafts) ) {

				foreach ($types as $type) {
					$this->recent_drafts_loop($drafts, $type);
				}

			} else {
				?><div class="table table_content"><p class="no-drafts"><?php
				_e('There are no drafts at the moment');
				?></p></div><?php
			}

			?>
		</div>
		<?php

	}

	/**
	 * Adds the dashboard widget
	 *
	 */
	public function add_dashboard_widget() {

		if ( is_blog_admin() && current_user_can('edit_posts') ) {
			//wp_add_dashboard_widget( 'gs_dashboard_recent_drafts', __('Recent Drafts'), array($this, 'recent_drafts') );
			add_meta_box( 'gs_dashboard_recent_drafts', __('Recent Drafts'), array($this, 'recent_drafts'), 'dashboard', 'side', 'high' );
		}

   


	}
	/**
	 * Removes the default Recent Drafts widget
	 *
	 */
	public function remove_default_recent_drafts_widget() {
		global $wp_meta_boxes;

		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);

	}


} // class
$GS_Recent_Drafts_Widget = new GS_Recent_Drafts_Widget;