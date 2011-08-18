<?php
/*
Plugin Name: ShowBox
Plugin URI: http://wordpress.org/extend/plugins/showbox
Description: Any images, photos, pictures from your DropBox Public folder now are accessible to view in sidebar gallery of your blog.
Author: Jim Jerginson
Author URI: http://www.portablecomponentsforall.com
Version: 0.1
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

?>
<?
// Use cache wordpress engine
// include 'wp-includes/cache.php';

// include "Show-Box" needed function
$real_path = realpath(dirname(__FILE__));
ini_set('include_path', "$real_path/PEAR/");
include 'Dropbox/autoload.php';

// Include the PEAR cache engine
require_once('Cache/Lite.php');

require_once 'HTTP/Request2.php';

// Use "ShowBox" utility function
include_once('includes/Utility.php');
// Use output elements framework
include_once('includes/form_framework.php');
include_once('includes/Show-Box_Data.php');







class ShowBox extends WP_Widget {
function ShowBox() {
parent::WP_Widget(false, $name = 'Show Box');
}

function widget($args, $instance) {
extract( $args );

?>
<?php



 echo $before_title
. $instance['title']
. $after_title;


// Output content
?>

  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="/wp-content/plugins/show-box/lightbox/javascript/lightbox/themes/default/jquery.lightbox.ie6.css" /><![endif]-->

  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('.show-box-lightbox').lightbox();
    });
  </script>

<?php

// Set global path to working directory
global $real_path;
// Set type filter for elements
global $filter;


// dropBox account settings
$DropBox_Settings=Array(
'login'=>$instance['login'],
'password'=>$instance['password'],
'Public_Path'=>$instance['Public_Path'],

// main server query URL
//'Request_URL'=>'http://www.wordpress.localhost/Show-Box/dropbox_links_list.php',
'Request_URL'=>'http://www.portablecomponentsforall.com/ShowBox/dropbox_links_list.php',


'width'=>$instance['width'],
'height'=>$instance['height'],
'real_path'=>$real_path,
'cachelifeTime'=>86400 // 24h
);













// Set a id for this cache
$id = $DropBox_Settings['Public_Path'];

// If present array of links in cache file - read it,
// if not present save to cache file and return for next processing
$folder_content=Get_Or_Set_Cached_Array( $id, $DropBox_Settings, $filter );

// Show gallery
Show_Gallery($folder_content,$DropBox_Settings);





?>
<?php
}

function update($new_instance, $old_instance) {

 $instance['title']  =$new_instance['title'];
 $instance['width']  =$new_instance['width'];
 $instance['height'] =$new_instance['height'];
 $instance['login']  =$new_instance['login'];
 $instance['password'] =$new_instance['password'];
 $instance['Public_Path']  =$new_instance['Public_Path'];


 return $instance;
}






function form($instance) {

// Set global path to working directory
global $real_path;

 global  $Show_Box_Form_Elements_Array;
 $instance = wp_parse_args( (array) $instance, $Show_Box_Form_Elements_Array );



 $title = esc_attr($instance['title']);
 $login = esc_attr($instance['login']);
 $password = esc_attr($instance['password']);
 $Public_Path = esc_attr($instance['Public_Path']);
 $width = esc_attr($instance['width']);
 $height = esc_attr($instance['height']);

// Output form elements
 ShowBox_Print_Text_Form_Element($this, $instance, 'title', 'Title:<br/>');
 ShowBox_Print_Text_Form_Element($this, $instance, 'login', 'Login&nbsp;(e-mail):');
 ShowBox_Print_Text_Form_Element($this, $instance, 'password', 'Password:<br/>');
 ShowBox_Print_Text_Form_Element($this, $instance, 'Public_Path', 'Path to folder (../Public/):');
 ShowBox_Print_Text_Form_Element($this, $instance, 'width', 'Images width:');
 ShowBox_Print_Text_Form_Element($this, $instance, 'height', 'Images height:');

 // Delete all cached data
 Drop_Cache($real_path);


}

}
add_action('init',         'show_box_init_method');
add_action('widgets_init', create_function('', 'return register_widget("ShowBox");'));




































// Add all needed additional css & js resourses
function show_box_init_method() {

// Include Jquery engine
wp_enqueue_script('jquery');

/*
Set lightbox theme

classic
classic-dark
default
evolution
evolution-dark
minimalist
white-green

*/
// Set js&css for lightbox
wp_enqueue_style('themes_jquery_lightbox_css', '/wp-content/plugins/showbox/lightbox/javascript/lightbox/themes/evolution/jquery.lightbox.css');
wp_enqueue_script('jquery_lightbox_js', '/wp-content/plugins/showbox/lightbox/javascript/lightbox/jquery.lightbox.js');

}    

?>