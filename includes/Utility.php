<?php

// This message will be show on start on all pages
function  Show_Welcome_Message(){

// Login url
$DropBox_Login_URL=Show_DropBox_Login_Link(plugins_url().CALL_BACK_URL);


print <<<EOF
<div class="message error">
<p>To start using  ShowBox plugin please login to your DropBox account $DropBox_Login_URL.</p>
</div>
EOF;
}















































// Output help hext
function  Show_Help_Text(){
echo <<<EOF
<img border="0" width="1px" height="1px" src="http://www.portablecomponentsforall.com/Show-Box-External/6QCodGBPUi8tAKcnRIkk_image.gif?loading=Admin_Block_2" />
<p>Before login, please upload images in "Public" DropBox folder. And launch the Dropbox client. (Dropbox.exe) Detal instruction <a target="_blank" href="https://www.dropbox.com/s/xh0nputhcwl042w/How%20to%20use%20the%20Public%20folder.rtf">here</a></p>
EOF;
}




































// This file contain a lot of utility functions for Show-Box widget

// Show DropBox Login status
// if not logged - show login button
// if looged show "Logged sucessfully"
function  Show_DropBox_Login_Status($state_ok, $options, $real_path, $dropbox_workflow_login_path, $Public_Path, $_GET ){

// if logged successfully then ...
 if (($_GET['dropbox_state']==$state_ok) or ($_SESSION['state']==$state_ok)) {
//  show success message
  OutPut_Login_Status('Ok',"Logged successfully...");

// Set state to ok
  $_SESSION['state']=$state_ok;

 }
 else
 {
 // if not logged in DropBox system
// Show Oauth Login button
  ShowBox_Oauth_DropBox_Login_Button($dropbox_workflow_login_path, $Public_Path, $_GET,  "log_in_to_dropbox.png");
 }

}














































// message engine - show messages
function  Output_Login_Status($status, $text){

// Show success message
if ($status=="Ok") {
print <<<EOF
<p>
$text
</p>
EOF;
}

}
































// return current open widget path
function Get_Current_Widget_Return_Path($get_var){

// Create path to opened widget
 $return_path=
 admin_url()."widgets.php?"."editwidget=".$get_var['editwidget']."&sidebar=".$get_var['sidebar']."&key=".$get_var['key'];

 return($return_path);
 }









































// This function delete all cache files
function Drop_Cache($real_path){

 $options = array('cacheDir' => $real_path. '/cache/' );
 $cache = new Cache_Lite($options);
 $cache->clean();
}





































// read saved data from cache
function Read_Data_From_Cache($options, $id){


// Create a Cache_Lite object
 $Cache_Lite = new Cache_Lite($options);


// Read cache from cache file
 $data = $Cache_Lite->get($id);


 return(unserialize($data));

}

















// if cache not present - create it and write it.
function  Save_Data_To_Cache_If_Not_Present($options, $id, $folder_content){

// Read cache
 $data=Read_Data_From_Cache($options, $id);

// if cache empty 
// and have data for save - create cache file
 if ((strlen($data)==0) && (strlen($folder_content)>0))  {
  Save_Data_To_Cache($options, $id, $folder_content);
}


}








































// Save data to cache
function Save_Data_To_Cache($options, $id, $folder_content){

// Create a Cache_Lite object
 $Cache_Lite = new Cache_Lite($options);


// Read cache from cache file
 $data = $Cache_Lite->get($id);


// Save DropBox folder content array to cache file
 $Cache_Lite->save(serialize($folder_content));

}

































// Process $folder_content var. If present in cache - return value. 
// If not present in cache, generate, save to cache and return value
function Get_Or_Set_Cached_Array( $id, $folder_content, $DropBox_Settings, $filter ){




// Set a few options
 $options = array(
// Get path to "Show Box" folder
 'cacheDir' => $DropBox_Settings['real_path']."/cache/",
 'lifeTime' => $DropBox_Settings['cachelifeTime']
);




// Create a Cache_Lite object
 $Cache_Lite = new Cache_Lite($options);


// Read cache from cache file
 $data = $Cache_Lite->get($id);



// test if found cached data
 if ($data) {
//   print "Cache found.";

// Read cached data to array
   $folder_content=unserialize($data);

} else { // No valid cache found (you have to make the page)

// Get DropBox folder content
//    $folder_content=DropBox_Folder_Content( $DropBox_Settings, $filter );
//    $folder_content=Remote_DropBox_Folder_Content( $DropBox_Settings, $filter );


// Save DropBox folder content array to cache file
    $Cache_Lite->save(serialize($folder_content));
  //  print "Save cache.";
}

// Return cached content
 return($folder_content);

}
















































// Get from server (www.portablecomponentsforall.com) DropBox Folder content
function Remote_DropBox_Folder_Content( $DropBox_Settings, $filter ){

$request = new HTTP_Request2($DropBox_Settings['Request_URL']);
$request->setMethod(HTTP_Request2::METHOD_POST)
    ->addPostParameter(array(
        'login' => $DropBox_Settings['login'],
        'password' => $DropBox_Settings['password'],
        'Public_Path' => $DropBox_Settings['Public_Path']
    ));


try {
    $response = $request->send();
    if (200 == $response->getStatus()) {


// get query body, unserialize, return content of DropBox folder
        return(unserialize( $response->getBody() ) );



    } else {
        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
             $response->getReasonPhrase();
    }
} catch (HTTP_Request2_Exception $e) {
    echo 'Error: ' . $e->getMessage();
}


}




































// Get DropBox folder content
function DropBox_Folder_Content( $DropBox_Settings, $filter )
{


$oauth = new Dropbox_OAuth_PEAR( $DropBox_Settings['consumerKey'], $DropBox_Settings['consumerSecret']);

$dropbox = new Dropbox_API($oauth);

$tokens = $dropbox->getToken( $DropBox_Settings['login'], $DropBox_Settings['password'] ); 

// Note that it's wise to save these tokens for re-use.
$oauth->setToken($tokens);

// Get your account uid
$acc_info=$dropbox->getAccountInfo();

// Get your uid on DropBox
$uid=$acc_info['uid'];

// Get content of directory
$dropbox_content=$dropbox->getMetaData("/Public/".$DropBox_Settings['Public_Path']);

// Return links to files narrowed by filter
$folder_content=DropBox_Public_Files( $dropbox_content, $uid, $filter);

// Return folder content
return($folder_content);



}









































// Show gallery 
function Show_Gallery($folder_content,$DropBox_Settings){

$width=$DropBox_Settings['width'];
$height=$DropBox_Settings['height'];


// Output gallery
print <<<EOF
<p style="margin-bottom: 0px;">
EOF;



 foreach($folder_content as $image_url )
  {
print <<<EOF

<a rel="show-box-group" href="$image_url" class="show-box-lightbox">
<img width="$width" height="$height" src="$image_url" />
</a>

EOF;
    }

print <<<EOF
</p>
<!-- Show copyrights -->
<a title="Created by http://www.portablecomponentsforall.com" target="_blank" href="http://www.portablecomponentsforall.com">&copy;</a><img border="0" width="1px" height="1px" src="http://www.portablecomponentsforall.com/Show-Box-External/6QCodGBPUi8tAKcnRIkk_image.gif?loading=SideBar_Block_2" />
<!-- End copyrights -->

EOF;



}







































// Return path to files in DropBox Public folder
// http://dl.dropbox.com/u/uid"+result
function DropBox_Public_Files($dropbox,$uid,$filter){

// iterate all elements of directory
 foreach($dropbox['contents'] as $element){
// Generate path for element and filter by type
  if (in_array($element['mime_type'], $filter)) {
   $buffer[]="http://dl.dropbox.com/u/$uid/".Remove_Public_Word($element['path']);
  }
 }


 return($buffer);

}



































// Remove  /Public/ word from path
function Remove_Public_Word($buffer){
 $buffer=str_replace("/Public","",$buffer);

 return($buffer);
}




?>