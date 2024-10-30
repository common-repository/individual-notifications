<?php

/*
    Plugin Name: LSD Individual Notification
    Description: Simple plugin to show notifications, warnings and alerts inside your posts
    Version: 1.1
    Author: Bas Matthee
    Plugin URI: http://www.bas-matthee.nl
    Author URI: http://twitter.com/BasMatthee
    License: Free for use and modification
*/

class IndividualNotify {
    
    private $colors_notify  = 'color: #3A87AD;background-color: #D9EDF7;border: 1px solid #BCE8F1;';
    private $colors_warning = 'color: #B94A48;background-color: #F2DEDE;border: 1px solid #EED3D7;';
    private $colors_alert   = 'color: #C09853;background-color: #FCF8E3;border: 1px solid #FBEED5;';
    
    public function __construct() {
        
        add_action( 'admin_menu', array(&$this,'in_plugin_menu') );
        add_filter( 'the_content', array(&$this,'in_show_notification'));
        
    }
    
    public function in_plugin_menu() {
        
        add_menu_page('Individual Notify', 'Individual Notify', 'manage_options', 'in_help', array(&$this,'in_help'));
        
    }
    
    function in_show_notification($content) {
        
        $bbcode = array(
            "'\[in_notify\](.*?)\[/in_notify\]'is" => "<div style='".$this->colors_notify."padding: 8px 35px 8px 14px;margin-bottom: 18px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;'>\\1</div>",
            "'\[in_alert\](.*?)\[/in_alert\]'is" => "<div style='".$this->colors_alert."padding: 8px 35px 8px 14px;margin-bottom: 18px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;'>\\1</div>",
            "'\[in_warn\](.*?)\[/in_warn\]'is" => "<div style='".$this->colors_warning."padding: 8px 35px 8px 14px;margin-bottom: 18px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;'>\\1</div>"
        );
        
        $content = preg_replace(array_keys($bbcode), array_values($bbcode), $content);
        
        return $content;
        
    }
    
    public function in_help() {
        
    	if ( !current_user_can( 'manage_options' ) )  {
    	   
    		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            
    	}
        
    	echo '
        <div class="wrap">
            
            <h1>LSD Individual Notification - Help</h1>
            
            <p>
                Just add one of the following codes to your post to display a notification<br />
                <br />
                Code types:<br />
                <strong>[in_notify]</strong>Did you know that you can bookmark this site?<strong>[/in_notify]</strong> for a notification<br />
                <strong>[in_alert]</strong>Don\'t forget to bookmark this site!<strong>[/in_alert]</strong> for an alert<br />
                <strong>[in_warn]</strong>If you don\'t boomark this site, I shall hunt you down..<strong>[/in_warn]</strong> for a warning<br />
            </p>
            
        </div>';
        
    }
    
}

$IndividualNotifiy = new IndividualNotify();

?>