<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1);
/*
Plugin name:Wp  Plugin
Plugin URL:http://pythonhacisi.com
Description:wp yazılarını begeni ekleme yazılımı
Version:1.0.1
Author:Sami Dönmez
Author URL:http://samidonmez.pythonhacisi.com
*/
require_once('languages/'.get_option('plugin_lang').'.php');
require_once( ABSPATH . 'wp-includes/pluggable.php' );
register_activation_hook( __FILE__, 'add_default_option' );
register_activation_hook( __FILE__, 'add_liker_tag_page' );

function add_default_option()
{
    $check=get_option( 'like_icon' );
    if (empty($check)) {
        add_option('like_icon','like.png');
    }
    $check=get_option( 'dislike_icon' );
    if (empty($check)) {
        add_option('dislike_icon','dislike.png');
    }
    $check=get_option( 'button_location' );
    if (empty($check)) {
        add_option('button_location','TOP');
    }
    $check=get_option( 'plugin_lang' );
    if (empty($check)) {
        add_option('plugin_lang','EN');
    }
    $check=get_option( 'widget_limit' );
    if (empty($check)) {
        add_option('widget_limit','10');
    }
    $check=get_option( 'page_limit' );
    if (empty($check)) {
        add_option('page_limit','10');
    }
}
// register shortcode
function add_liker_tag_page() {
    // Create post object
    $my_post = array(
      'post_title'    => 'tag list',
      'post_content'  => '<!-- wp:shortcode -->
      [likertag][/likertag]
      <!-- /wp:shortcode -->',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );
    wp_insert_post( $my_post );

}

require_once('function.php');
require_once('page.php');
require_once('plugin.php');
require_once('addadminmenu.php');
require_once('widget.php');
