<?php
include("include.php");// Include configuration file 
//require_once 'config_google_facebook.php'; 
 
// Remove token and user data from the session 
//unset($_SESSION['token']); 

// Remove access token from session
//unset($_SESSION['facebook_access_token']);

/*
if($_GET['google']){
    require_once  'google-plus-api-client/src/Google_Client.php';	
	$client = new Google_Client();
	$client->revokeToken();	
}
*/

unset($_SESSION['userData']); 
 
// Destroy entire session data 
   if(session_destroy()) {
      header("Location: ".lienConnexion());
   }
?>