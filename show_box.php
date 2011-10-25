<?php
/*
Plugin Name: ShowBox
Plugin URI: http://wordpress.org/extend/plugins/showbox
Description: Any images, photos, pictures from your DropBox Public folder now are accessible to view in sidebar gallery of your blog.
Author: Jim Jerginson
Author URI: http://www.portablecomponentsforall.com
Version: 1.6
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

?>
<?

// Add ShowBox items to sidebar admin menu
include('admin-menu.php');


// Set ShowBox Explorer path
define('ShowBox_Explorer_URL', plugins_url() .'/showbox/ShowBox%20Explorer' );

// Use "ShowBox" utility function
// Use output elements framework
include_once('includes/form_framework.php');
include_once('includes/Show-Box_Data.php');
include_once('includes/Utility.php');

// use settings file
include('ShowBox Explorer/includes/Configure.php');

// Use functions for login
include('ShowBox Explorer/includes/DropBox_Login_Utility.php');






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

  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="/wp-content/plugins/showbox/lightbox/javascript/lightbox/themes/default/jquery.lightbox.ie6.css" /><![endif]-->

  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('.show-box-lightbox').lightbox();
    });
  </script>

<?php
// Show images (include image list)
include("ShowBox Explorer/files/image_list.php");
}


function update($new_instance, $old_instance) {

 $instance['title']  =$new_instance['title'];
 $instance['width']  =$new_instance['width'];
 $instance['height'] =$new_instance['height'];
 $instance['Public_Path']  =$new_instance['Public_Path'];

 return $instance;
}



















function form($instance) {


print $page;

// Set global path to working directory
 global $dropbox_workflow_login_path;
 global $Show_Box_Form_Elements_Array;
 global $options;







 $instance = wp_parse_args( (array) $instance, $Show_Box_Form_Elements_Array );

 $title = esc_attr($instance['title']);
 $Public_Path = esc_attr($instance['Public_Path']);
 $width = esc_attr($instance['width']);
 $height = esc_attr($instance['height']);


 
// Output link to ShowBox Explorer
print '<a href="'.admin_url().'options-general.php?page=ShowBox-Explorer">ShowBox Explorer</a>';

}
}


























add_action('init', 'show_box_init_method');
add_action('widgets_init', create_function('', 'return register_widget("ShowBox");'));


















// Add all needed additional css & js resourses
function show_box_init_method() {





// Load CSS
// For IE6
wp_enqueue_style('showbox_jquery_lightbox_ie6' ,ShowBox_Explorer_URL.'/js/lightbox/javascript/lightbox/themes/default/jquery.lightbox.ie6.css');

wp_enqueue_style('showbox_jquery_lightbox', ShowBox_Explorer_URL.'/js/lightbox/javascript/lightbox/themes/evolution/jquery.lightbox.css');
wp_enqueue_style('showbox_ui_dynatree_DropBox', ShowBox_Explorer_URL.'/css/skin/ui.dynatree_DropBox.css');
wp_enqueue_style('showbox_custom', ShowBox_Explorer_URL.'/css/custom/custom.css');


// Load Js
wp_enqueue_script('showbox_jquery', ShowBox_Explorer_URL.'/js/jquery/jquery.min.js');
wp_enqueue_script('showbox_jquery-base64', ShowBox_Explorer_URL.'/js/jquery/base64/jquery.base64.min.js');


wp_enqueue_script('showbox_jquery-ui_custom', ShowBox_Explorer_URL.'/js/jquery/jquery-ui.custom.min.js');
wp_enqueue_script('showbox_jquery_cookie', ShowBox_Explorer_URL.'/js/jquery/jquery.cookie.js');
wp_enqueue_script('showbox_jquery_dynatree', ShowBox_Explorer_URL.'/css/jquery.dynatree.min.js');
wp_enqueue_script('showbox_jquery_lightbox', ShowBox_Explorer_URL.'/js/lightbox/javascript/lightbox/jquery.lightbox.min.js');
wp_enqueue_script('showbox_utils', ShowBox_Explorer_URL.'/js/custom/utils.js');


// Load this script only on 'ShowBox-Explorer' page
if (isset($_GET['page'])) { 
    if ($_GET['page'] == "ShowBox-Explorer") {
        /*load your scripts here */
wp_enqueue_script('showbox_load_dropbox_public_tree', ShowBox_Explorer_URL.'/js/custom/load_dropbox_public_tree.php?ShowBox_Explorer_URL='.base64_encode(ShowBox_Explorer_URL));
    }
}

}    

?>