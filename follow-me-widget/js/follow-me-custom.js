jQuery(document).ready(function() {
	
	jQuery(document).on("click", ".add_more_btn", function(e) {
		var div_id = 1;
	    jQuery('.follow-me-dynamic-fields').append('<p id="'+ div_id +'"><label>Social Type:</label><input type="text" class="widefat" name="widget-wp_follow_me_widget[2][repeat][]" /><label>Social Icon:</label><input type="text" class="widefat" name="widget-wp_follow_me_widget[2][repeat][]" /><label>Social Link:</label><input type="text" class="widefat" name="widget-wp_follow_me_widget[2][repeat][]" /><a class="remove_follow_me_link">Remove</a></p>');
		
	});
	jQuery(document).on("click", ".remove_follow_me_link", function(e) {
		jQuery( '#widget-wp_follow_me_widget-2-savewidget' ).removeAttr('disabled');
		jQuery( '#widget-wp_follow_me_widget-2-savewidget' ).val('Save');
	  	jQuery(this).parent().remove();
	});
	jQuery(document).on("click", ".icon-pop-up-window", function(e) {
		var URL = "https://developer.wordpress.org/resource/dashicons/";
		window.open(URL,"RecoverPassword","width=700,height=450");
	});
	
});
