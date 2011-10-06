<?php
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
  add_options_page('My Plugin Options', 'ShowBox Explorer', 'manage_options', 'ShowBox-Explorer', 'my_plugin_options');
}





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
