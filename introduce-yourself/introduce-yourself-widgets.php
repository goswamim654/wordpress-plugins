<?php
/*
Plugin Name: Introduce yourself
Plugin URI: http://www.mukeshg.com/
Description: Add an image, a description about yourself and link to your homepage.
Author: Mukesh Gosswami
Version: 1.0
Author URI: http://www.mukeshg.com
Text Domain: introduce-yourself-widget
Domain Path: /languages
License: none
*/
// Plugin version
if ( ! defined( 'INTRODUCE_YOURSELF' ) ) {
	define( 'INTRODUCE_YOURSELF', '1.0' );
}
class introduce_yourself_widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'introduce_yourself_widget', // Base ID
			esc_html__( 'About Me', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Give a brief description of yourself', 'text_domain' ), ) // Args
		);
		add_action('admin_enqueue_scripts', array($this,'author_upload_enqueue'));
	}
	/* Add script function */
	public function author_upload_enqueue() {
        wp_enqueue_media();
        wp_enqueue_script( 'intro_custom_jquery', plugin_dir_url(__FILE__).'/js/intro-custom.js', '',INTRODUCE_YOURSELF, true );
         wp_enqueue_style( 'intro_custom_css', plugin_dir_url( __FILE__).'/css/intro-custom.css', '', INTRODUCE_YOURSELF );
        wp_enqueue_style( 'media_upload_css', plugin_dir_url( __FILE__).'/css/upload-media.css', '', INTRODUCE_YOURSELF );
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
		wp_enqueue_style( 'intro_custom_css', plugin_dir_url( __FILE__).'/css/intro-custom.css', '', INTRODUCE_YOURSELF );
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if( ! empty($instance['img_uri'])) {

			 echo '<div class="author_photo"><img src="'.$instance['img_uri'].'" alt="Author Photo" /></div>';
		}
		if ( ! empty( $instance['name'] ) ) {
			echo '<div class="name">Name: ' . $instance['name'] . '</div>';
		}
		if( ! empty($instance['textarea'])) {
			 echo '<div class="desc widget-textarea">' . $instance['textarea'] . '</div>';
		}
		echo $args['after_widget'];
	}
	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$name = ! empty( $instance['name'] ) ? $instance['name'] : '';
		$img_uri = ! empty( $instance['img_uri'] ) ? $instance['img_uri'] : '';
		$textarea = ! empty( $instance['textarea'] ) ? $instance['textarea'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_attr_e( 'Name:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
            <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Write about yourself:'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo esc_attr($textarea); ?></textarea>
		</p>
		<p>
            <input type="hidden" class="author_photo" name="<?php echo $this->get_field_name('img_uri'); ?>" id="<?php echo $this->get_field_id('img_uri'); ?>" value="<?php echo esc_attr($img_uri); ?>" />
            
            <div id="img_container"><img src="<?php echo esc_attr($img_uri); ?>" alt=""/></div>
            
            <div id="upload_btn"><input type="button" value="Upload Image" class="upload_image_button button button-success" /></div>
		</p>

		<?php 
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		$instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags( $new_instance['textarea'] ) : '';
		$instance['img_uri'] = ( ! empty( $new_instance['img_uri'] ) ) ? strip_tags( $new_instance['img_uri'] ) : '';
		return $instance;
	}
}

// register introduce_yourself_widget 
function register_introduce_yourself_widget() {
    register_widget( 'introduce_yourself_widget' );
}
add_action( 'widgets_init', 'register_introduce_yourself_widget' );