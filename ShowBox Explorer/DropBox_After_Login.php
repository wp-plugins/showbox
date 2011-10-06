<?php

// use settings file
include('includes/Configure.php');
// Use functions for login
include('includes/DropBox_Login_Utility.php');

// Use wordpress functions
include($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');


// Get before login tokens encoded in 'data' variable
$data=$_GET['data'];

// Get user UID
$UID=$_GET['uid'];


// Get request token from remote host (will be decoded before use)
$encoded_tokens=file_get_contents(REMOTE_REQUEST_PATH."?data=$data");
$request_tokens=unserialize(base64_decode($encoded_tokens));



// Save credentials to file
Save_Credentials($request_tokens,$UID);



// Redirect to DropBox Explorer
Do_Redirect_To(home_url().DROPBOX_EXPLORER_LINK);


?>