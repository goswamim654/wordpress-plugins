<?php
/*
Plugin Name: Social Share
Plugin URI: http://www.mukeshg.com/
Description: Its a plugin from which you can share your post to social media such as Facebook, Twitter, Google Plus.
Author: Mukesh Goswami
Version: 1.0
Author URI: http://www.mukeshg.com
Text Domain: SOCIAL_SHARE
Domain Path: /languages
License: none
*/
// Plugin version
if ( ! defined( 'SOCIAL_SHARE' ) ) {
	define( 'SOCIAL_SHARE', '1.0' );
}
// global $pagenow, $typenow;
// echo $typenow;
// die();

// Creating a Admin Menu Item
function social_share_menu_item()
{
  add_submenu_page("options-general.php", "Social Share", "Social Share", "manage_options", "social-share", "social_share_page"); 
}
add_action("admin_menu", "social_share_menu_item");

// Creating an Options Page

function social_share_page()
{
   ?>
      <div class="wrap">
         <h1>Social Sharing Options</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("social_share_config_section");
 
               do_settings_sections("social-share");
                
               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

// display the section and its option fields

function social_share_settings()
{
    add_settings_section("social_share_config_section", "", null, "social-share");
 
    add_settings_field("social-share-facebook", "Do you want to display Facebook share button?", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-twitter", "Do you want to display Twitter share button?", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-linkedin", "Do you want to display LinkedIn share button?", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-reddit", "Do you want to display Reddit share button?", "social_share_reddit_checkbox", "social-share", "social_share_config_section");
 
    register_setting("social_share_config_section", "social-share-facebook");
    register_setting("social_share_config_section", "social-share-twitter");
    register_setting("social_share_config_section", "social-share-linkedin");
    register_setting("social_share_config_section", "social-share-reddit");
}
 
function social_share_facebook_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-facebook" value="1" <?php checked(1, get_option('social-share-facebook'), true); ?> /> Check for Yes
   <?php
}

function social_share_twitter_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-twitter" value="1" <?php checked(1, get_option('social-share-twitter'), true); ?> /> Check for Yes
   <?php
}

function social_share_linkedin_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-linkedin" value="1" <?php checked(1, get_option('social-share-linkedin'), true); ?> /> Check for Yes
   <?php
}

function social_share_reddit_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-reddit" value="1" <?php checked(1, get_option('social-share-reddit'), true); ?> /> Check for Yes
   <?php
}
 
add_action("admin_init", "social_share_settings");

//Display the social share button to the frontend

function add_social_share_icons($content)
{
	if( is_single() || is_home() ) {
    $html = "<div class='social-share-wrapper'><div class='share-on'>Share on: </div>";

    global $post;

    $url = get_permalink($post->ID);
    $url = esc_url($url);

    if(get_option("social-share-facebook") == 1)
    {
        $html = $html . "<div class='facebook'><a style='text-decoration:none' target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "'><i class='fa fa-facebook'></i> Facebook</a></div>";
    }

    if(get_option("social-share-twitter") == 1)
    {
        $html = $html . "<div class='twitter'><a style='text-decoration:none' target='_blank' href='https://twitter.com/share?url=" . $url . "'><i class='fa fa-twitter'></i>  Twitter</a></div>";
    }

    if(get_option("social-share-linkedin") == 1)
    {
        $html = $html . "<div class='linkedin'><a style='text-decoration:none' target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $url . "'><i class='fa fa-linkedin'></i> LinkedIn</a></div>";
    }

    if(get_option("social-share-reddit") == 1)
    {
        $html = $html . "<div class='reddit'><a style='text-decoration:none' target='_blank' href='http://reddit.com/submit?url=" . $url . "'><i class='fa fa-reddit'></i> Reddit</a></div>";
    }

    $html = $html . "<div class='clear'></div></div>";

    return $content = $content . $html;
	} else {
		return $content;
	}
}

add_filter("the_content", "add_social_share_icons");

// enqueue styling file

function social_share_style() 
{
    wp_register_style("social-share-style-file", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_style("social-share-style-file");

    wp_enqueue_style( 'font-awesome-cdn', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

add_action("wp_enqueue_scripts", "social_share_style");