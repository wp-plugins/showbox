<?php
add_action('admin_menu', 'my_plugin_menu');
add_action( 'admin_head', 'DropBox_Login_Message' ); 










// Show DropBox Login Message if needed
function DropBox_Login_Message() {

// Show login part...
// Test user state - logged or not
$DropBox_user_state=is_Logged(dirname(__FILE__).'/ShowBox Explorer'.CREDENTIALS_FILE);

// if logged - show logged banner
if (!$DropBox_user_state)
{
// Show welcome message
 Show_Welcome_Message();
}
}







































// Add menu items to administration menu sidebar
function my_plugin_menu() {
//             Page title          Menu item title
add_menu_page('ShowBox Explorer', 'ShowBox', 6, 'ShowBox-Explorer', 'my_plugin_options');
}































// Do menu function
function my_plugin_options() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

echo '<div class="wrap">';
?>
<style type='text/css'>
/*
correct ajax DynaTree by native style.
*/
  #tree li {
line-height:100%;
}
</style>
<?php
include('ShowBox Explorer/index.php');

echo '</div>';
}


?>
