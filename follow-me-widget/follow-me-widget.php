<?php
/*
Plugin Name: Follow Me
Plugin URI: http://www.mukeshg.com/
Description: Its a widget which contain the social link to follow the user/admin.
Author: Mukesh Gosswami
Version: 1.0
Author URI: http://www.mukeshg.com
Text Domain: FOLLOW_ME
Domain Path: /languages
License: none
*/
 
// Creating the widget 
class wp_follow_me_widget extends WP_Widget {
	 
	function __construct() {
		parent::__construct(
		 
		// Base ID of your widget
		'wp_follow_me_widget', 
		 
		// Widget name will appear in UI
		__('Follow Me', 'FOLLOW_ME'), 
		 
		// Widget description
		array( 'description' => __( 'Its a widget which contain the social link to follow the user/admin', 'FOLLOW_ME.' ), ) 
		);
		add_action( 'admin_enqueue_scripts', array($this,'load_follow_me_custom_scripts_style' ) );
	}
	// function include style and scripts 
	public function load_follow_me_custom_scripts_style() {
		// enqueue style and scripts
		wp_enqueue_style( 'follow_me_custom_css', plugin_dir_url( __FILE__).'/css/follow-me-custom.css', '', 'FOLLOW_ME' );
		
		wp_enqueue_script( 'follow_me_custom_js', plugin_dir_url( __FILE__).'/js/follow-me-custom.js', '', 'FOLLOW_ME' );
	}
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
		// enqueue style and scripts
		wp_enqueue_style( 'follow_me_custom_css', plugin_dir_url( __FILE__).'/css/follow-me-custom.css', '', 'FOLLOW_ME' );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		$list_follow_me = '<ul class="follow-me-list">';
		foreach ($instance['repeat'] as $k=>$field) {
			$array_info_follow_me_link[] =  $field;
		}
		$arr = array_chunk($array_info_follow_me_link, 3);
		foreach($arr as $k => $v) {
            $list_follow_me .= '<li><a target="_blank" href=' . esc_url( $v[2], 'FOLLOW_ME' ) . '>
			<span class="dashicons '. $v[1] .'"></span>' . $v[0] . '</a></li>';
        }
		$list_follow_me .= '</ul>'; 
		echo $list_follow_me;
		echo $args['after_widget'];
	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'FOLLOW_ME' );
		}
		// Widget admin form
		//title
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<!-- Dynamic fields -->
		<?php 
		 $repeatable_fields = isset ( $instance['repeat'] ) ? $instance['repeat'] : array();
		 if ($repeatable_fields) :
			foreach ($repeatable_fields as $k=>$field) { 
				$array_info_follow_me_link[] =  $field;
			}
			$arr = array_chunk($array_info_follow_me_link, 3);
			foreach($arr as $k => $v) {
			?>
			<p id="<?php _e( 'remove_follow_me_links' .$k )?>">
				<label><?php _e( 'Social Type:' ); ?></label> 
				<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'repeat' )?>[]" value="<?php echo $v[0]; ?>" />
				<label><?php _e(  'Social Icon:' ); ?></label> 
				<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'repeat' )?>[]" value="<?php echo $v[1]; ?>" />
				<label><?php _e( 'Social Link:' ); ?></label> 
				<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'repeat' )?>[]" value="<?php echo $v[2]; ?>" />
				<a data-id="<?php _e( 'remove_follow_me_links' .$k )?>" class="remove_follow_me_link">Remove</a>
			</p>

		<?php		
			}
		endif;
		?>
		<div class="follow-me-dynamic-fields">
			
		</div>
		<p>
			<a class="add_more_btn">Add More</a> <a style="margin-left:20px;" class="icon-pop-up-window" href="#">Find Social Icon</a>
		</p>
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['repeat'] = array();
		if ( isset ( $new_instance['repeat'] ) )
	    {
	        foreach ( $new_instance['repeat'] as $k =>$value )
	        {
	                $instance['repeat'][$k] = $value;
	        }
	    }
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['facebook_follow_link'] = ( ! empty( $new_instance['facebook_follow_link'] ) ) ? strip_tags( $new_instance['facebook_follow_link'] ) : '';
		$instance['twitter_follow_link'] = ( ! empty( $new_instance['twitter_follow_link'] ) ) ? strip_tags( $new_instance['twitter_follow_link'] ) : '';
		return $instance;
	}
} // Class wp_follow_me_widget ends here

// Register and load the widget
function wp_follow_me_load_widget() {
    register_widget( 'wp_follow_me_widget' );
}
add_action( 'widgets_init', 'wp_follow_me_load_widget' );