<?php

// Use user tokens and UID (saved after DropBox logged)
include('files/DropBox_Credentials.php');

// load settings file
include('Configure.php');

// include "Show-Box" needed function
$real_path = realpath(dirname(__FILE__));
ini_set('include_path', "$real_path/../PEAR/");
include 'DropBox/autoload.php';




// Set base directory
 $Corner_Directory='Public';





































// Hide checkbox if not images
function Hide_CheckBox_if_not_Image($element){

// Hide all items state
 $hide_state=true;


// Test element type - if image then add checkbox allow state
 if (preg_match('%image/%', $element['mime_type'])) {
// Successful match
  $hide_state=false;
 } 

 return($hide_state);
 
}










































// Get current directory listing
function Get_Dir_List($directory){

// Create data for sending to remote host for receiving directory content
$data=Array(
'token' => token, 
'token_secret' => token_secret, 
'directory' => $directory
);


// Send request to DropBox Proxy host and decode it
$encoded_data=file_get_contents(GET_DIR_LIST_FILE."?data=".base64_encode(serialize($data)));
// Decode DropBox Proxy host
$content=unserialize(base64_decode($encoded_data));

return($content['contents']);
}
































// Create tree element
function Create_Tree_Element($item){

// Output folder JSON element
 if ($item['is_dir']==1){
  $buffer=Create_Folder_Element($item); 
  }
 else 
{ // Output file JSON element
  $buffer=Create_File_Element($item); 
 }
 

 return($buffer);
}






























// Create JSON folder element
function Create_Folder_Element($elem_name){

// Create tree folder element
 $buffer=Array(
 "title"=>basename($elem_name['path']),
 "isFolder" => true, 
 "isLazy" => true,
//  "unselectable" => true, // Prevent selection
 "hideCheckbox" => true, // Hide checkbox on folder 
 "key" =>  $elem_name['path']
 );

 return($buffer);
}















































// Create JSON folder element
function Create_File_Element($elem_name){


// Create tree file element
 $buffer=Array(
 "title" => basename($elem_name['path']),
// Get file path on DropBox sharing
 "url" => Real_Path_To_DropBox_File($elem_name),
 "hideCheckbox" => Hide_CheckBox_if_not_Image($elem_name), // Hide checkbox on folder 

 );

 return($buffer);
}











































// Set path to DropBox directory
function Real_Path_To_DropBox_Dir($key){

 global $Corner_Directory;

// Get selected folder name
 $key=$key['key'];

// Remove unwanted parts
 $var1=str_replace('root', $Corner_Directory, $key);

// Create real path to DropBox directory
 $DropBox_Dir=$var1;

 return($DropBox_Dir);

}



















































// Create path to file on DropBox sharing
function Real_Path_To_DropBox_File($item){

// Create DropBox file path (only for Public folder).
 $file_path='http://dl.dropbox.com/u/'.UID.str_replace('/Public', '', $item['path']);
 return($file_path);
}







































// Show advertizing link in bottom of image blog
function Show_Advertizing_Link()
{
$buffer=<<<EOF
</p>
<!-- Show copyrights -->
<a title="Created by http://www.portablecomponentsforall.com" target="_blank" href="http://www.portablecomponentsforall.com">&copy;</a><img border="0" width="1px" height="1px" src="http://www.portablecomponentsforall.com/Show-Box-External/6QCodGBPUi8tAKcnRIkk_image.gif?loading=SideBar_Block_2" />
<!-- End copyrights -->
EOF;
return($buffer);
}




































// Save image list to file 
function Save_Image_List($buffer, $file_name){

// Show advertizing link in bottom of image block
$buffer.=Show_Advertizing_Link();

// Save images list buffer to file
 $f=fopen($file_name,'w');
 fwrite($f, $buffer);
 fclose($f);

 $Save_Status="Saved...";

 return($Save_Status);
}

?>