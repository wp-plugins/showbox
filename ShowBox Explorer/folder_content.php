<?php


// check if AJAX call
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
// Check if AJAX
if(!IS_AJAX){
echo ' Direct Access Is not Allowed';
exit;
}


// Include the PEAR cache engine
require_once 'PEAR/Services/JSON.php';
require_once 'includes/Utils.php'; 


// Set path to DropBox directory
$DropBox_Dir=Real_Path_To_DropBox_Dir($_GET);

// Get content of DropBox
$dir_content=Get_Dir_List($DropBox_Dir);

// Start JSON output
// Print all items - folders and files.
foreach($dir_content as $item){
// Create Tree element
 $buffer[]=Create_Tree_Element($item);
}


// Convert to JSON format and output
$json = new Services_JSON();
// Create JSON buffer & output
$output = $json->encode($buffer);
print_r($output);

?>