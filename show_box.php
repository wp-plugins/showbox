<?php
/*
Plugin Name: ShowBox
Plugin URI: http://wordpress.org/extend/plugins/showbox
Description: Any images, photos, pictures from your DropBox Public folder now are accessible to view in sidebar gallery of your blog.
Author: Jim Jerginson
Author URI: http://www.portablecomponentsforall.com
Version: 0.4
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

?>
<?

// include "ShowBox" needed function
$real_path = realpath(dirname(__FILE__));
ini_set('include_path', "$real_path/PEAR/");



include 'DropBox/autoload.php';

// Include the PEAR cache engine
require_once('Cache/Lite.php');

// Use "ShowBox" utility function
include_once('includes/Utility.php');
// Use output elements framework
include_once('includes/form_framework.php');
include_once('includes/Show-Box_Data.php');



 // Set a few options
 $options = array(
// Get path to "Show Box" folder
 'cacheDir' => $real_path."/cache/",
 'lifeTime' => 86400
);










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

// Set global path to working directory
global $real_path;
// Set type filter for elements
global $filter;
global $options;


// dropBox account settings
$DropBox_Settings=Array(
'login'=>$instance['login'],
'password'=>$instance['password'],
'Public_Path'=>$instance['Public_Path'],


'width'=>$instance['width'],
'height'=>$instance['height'],
'real_path'=>$real_path,
'cachelifeTime'=>86400 // 24h
);



// Set a id for this cache
$id = $DropBox_Settings['Public_Path'];

// Get data from cache (previously saved folder content)
$folder_content=Read_Data_From_Cache($options, $id);

// Show gallery
Show_Gallery($folder_content,$DropBox_Settings);





?>
<?php
}


function update($new_instance, $old_instance) {

 $instance['title']  =$new_instance['title'];
 $instance['width']  =$new_instance['width'];
 $instance['height'] =$new_instance['height'];
 $instance['Public_Path']  =$new_instance['Public_Path'];

 return $instance;
}



















function form($instance) {



// Set global path to working directory
 global $real_path;
 global $dropbox_workflow_login_path;
 global $Show_Box_Form_Elements_Array;
 global $options;







 $instance = wp_parse_args( (array) $instance, $Show_Box_Form_Elements_Array );

 $title = esc_attr($instance['title']);
 $Public_Path = esc_attr($instance['Public_Path']);
 $width = esc_attr($instance['width']);
 $height = esc_attr($instance['height']);


// init public path
 $Public_Path='';

 // Get DropBox account data
 $Data=unserialize(base64_decode($_GET['data']));

// Show help text
 Show_Help_Text();

// Output form elements
 ShowBox_Print_Text_Form_Element($this, $instance, 'title', 'Title:<br/>');

// Show if logged status (Login button or "Logged sucessfully" text)
 Show_DropBox_Login_Status(2, $options, $real_path, $dropbox_workflow_login_path, $Public_Path, $_GET );






// Save data when returned from DropBox Login page
 $Data=unserialize(base64_decode($_GET['data']));
 if ( strlen($_GET['data'])>10 ){

 Save_Data_To_Cache($options, $Public_Path, $Data['folder_content']);
 }




// Input Public folder, images size (w,h)
 ShowBox_Print_Text_Form_Element($this, $instance, 'width', 'Images width:');
 ShowBox_Print_Text_Form_Element($this, $instance, 'height', 'Images height:');


// Get folder content
 $folder_content=$Data['Folder_Content'];

// Save data to cache
// Save_Data_To_Cache($options, $Public_Path, $folder_content);
 Save_Data_To_Cache_If_Not_Present($options, $Public_Path, $folder_content);

}


}











add_action('init', 'show_box_init_method');
add_action('widgets_init', create_function('', 'return register_widget("ShowBox");'));



















// Add all needed additional css & js resourses
function show_box_init_method() {

// Include Jquery engine
 wp_enqueue_script('jquery');

/*
Set lightbox theme
classic,classic-dark,default,evolution,evolution-dark,minimalist,white-green
*/
// Set js&css for lightbox
 wp_enqueue_style('themes_jquery_lightbox_css', '/wp-content/plugins/showbox/lightbox/javascript/lightbox/themes/evolution/jquery.lightbox.css');
 wp_enqueue_script('jquery_lightbox_js', '/wp-content/plugins/showbox/lightbox/javascript/lightbox/jquery.lightbox.js');

}    

?>