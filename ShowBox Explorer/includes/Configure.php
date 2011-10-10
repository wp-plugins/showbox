<?php

// link to DropBox Explorer
define('DROPBOX_EXPLORER_LINK','/wp-admin/options-general.php?page=ShowBox-Explorer');

// Set path to DropBox credentials file
define('CREDENTIALS_FILE','/files/DropBox_Credentials.php');

//  call back path - will used after DropBox authentification
define('CALL_BACK_URL', '/showbox/ShowBox%20Explorer/DropBox_After_Login.php');


























// Remote Oauth authentification section
// Set path to remote DropBox authentification site
// define('REMOTE_AUTH_PATH','http://www.wordpress.localhost/Remote-DropBox-Auth/get_DropBox_Oauth_Link.php?callback_url=');
define('REMOTE_AUTH_PATH','http://www.portablecomponentsforall.com/Remote-DropBox-Auth/get_DropBox_Oauth_Link.php?callback_url=');

// Set path to DropBox post login request tokens
//define('REMOTE_REQUEST_PATH','http://www.wordpress.localhost/Remote-DropBox-Auth/get_request_tokens.php');
define('REMOTE_REQUEST_PATH','http://www.portablecomponentsforall.com/Remote-DropBox-Auth/get_request_tokens.php');

// Get dir list file path 
//define('GET_DIR_LIST_FILE','http://www.wordpress.localhost/Remote-DropBox-Auth/Get_Dir_List.php');
define('GET_DIR_LIST_FILE','http://www.portablecomponentsforall.com/Remote-DropBox-Auth/Get_Dir_List.php');

?>