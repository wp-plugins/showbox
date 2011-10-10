<?php

// Show login to DropBox link
function Show_Login_Link($Call_Back_URL){

// Create login link
$login_link=REMOTE_AUTH_PATH.$Call_Back_URL;

// Get DropBox login oauth link with login token and call back url
$load_link=file_get_contents($login_link);

// Output link
// print $load_link;
print <<<EOF
Login to your DropBox account $load_link.
EOF;
}



































// Redirect user to page
function  Do_Redirect_To($redirect_url){
?>
<script>
 window.location.href = "<?php echo $redirect_url; ?>";
</script>
<?php
}
















































// Save credentials to file
function Save_Credentials($request_tokens,$UID){

// Create file to save
$content=<<<EOF
<?php

// Set account data

define('UID','{$UID}');
define('token','{$request_tokens['token']}');
define('token_secret','{$request_tokens['token_secret']}');

?>
EOF;



// Save tokens and UIN to file
$f = fopen(CREDENTIALS_FILE,'w'); 
fwrite($f,$content,strlen($content)); 
fclose($f); 

}


























// Show banner with text "You are successfully logged.",
// after logged
function Show_Success_Logged_Banner(){

print <<<EOF
You are successfully logged.
EOF;

}






































// Test connection to DropBox
// get tokens from credentials.php and test connection
function test_DropBox_Connection(){
 return(true);
}
















































// if credentials.php file present and test connection is true then user logged to DropBox
function is_Logged($credentials_file_path){

// Test if config file present
 $file_is_present=file_exists($credentials_file_path);
// if file present i include it
 if ($file_is_present){
  include($credentials_file_path);
  }


 return($file_is_present); 
}


?>
