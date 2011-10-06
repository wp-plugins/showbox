<?

// check if AJAX call
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
// Check if AJAX
if(!IS_AJAX){
echo ' Direct Access Is not Allowed';
exit;
}



// Do AJAX call
// Include the PEAR cache engine
require_once 'includes/Utils.php'; 

// Get image list and decode (base64) it before saving
$list=base64_decode($_GET['image_block']);

// Save image list to file and return image block
$Save_Status=Save_Image_List($list,'files/image_list.php');

// Output image block
print $Save_Status;


?>