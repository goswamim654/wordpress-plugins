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
		$title = apply_filters( 'widget_title', $instance['title'] );
		$facebook_follow_link = $instance['facebook_follow_link'];
		$twitter_follow_link = $instance['twitter_follow_link'];
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		$list_follow_me = '<ul class="follow-me-list">';
		if( ! empty( $facebook_follow_link ) ) {
			$list_follow_me .= '<li><a target="_blank" href=' . esc_url( $facebook_follow_link, 'FOLLOW_ME' ) . '>
			<span class="dashicons dashicons-facebook-alt"></span> Facebook</a></li>';
		}
		if( ! empty( $twitter_follow_link ) ) {
			$list_follow_me .= '<li><a target="_blank" href=' . esc_url( $twitter_follow_link, 'FOLLOW_ME' ) . '>
			<span class="dashicons dashicons-twitter"></span> Twitter</a></li>';
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
		<?php 
		// facebook link
		if ( isset( $instance[ 'facebook_follow_link' ] ) ) {
			$facebook_follow_link = $instance[ 'facebook_follow_link' ];
		}
		else {
			$facebook_follow_link = __( '', 'FOLLOW_ME' );
		}
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_follow_link' ); ?>"><?php _e( 'Facebook Link:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_follow_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_follow_link' ); ?>" type="text" value="<?php echo esc_url( $facebook_follow_link ); ?>" />
		</p>
		<?php 
		// twitter link
		if ( isset( $instance[ 'twitter_follow_link' ] ) ) {
			$twitter_follow_link = $instance[ 'twitter_follow_link' ];
		}
		else {
			$twitter_follow_link = __( '', 'FOLLOW_ME' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_follow_link' ); ?>"><?php _e( 'Twitter Link:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_follow_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_follow_link' ); ?>" type="text" value="<?php echo esc_url( $twitter_follow_link ); ?>" />
		</p>
		<div class="follow-me-dynamic-fields"></div>
		<p>
			<a class="add_more_btn">Add More</a>
		</p>
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
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