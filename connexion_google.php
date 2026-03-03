<?php

include("include.php");
	
require_once "config_google_facebook.php";
	
require_once "User.class.php";

// Start session
if(!session_id()){
    session_start();
}
// Include Google API client library
require_once  'google-plus-api-client/src/Google_Client.php';
require_once  'google-plus-api-client/src/contrib/Google_Oauth2Service.php';
// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Technoplus');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);
//$gClient->addScope("email");
//$gClient->addScope("profile");

$google_oauthV2 = new Google_Oauth2Service($gClient);

if(isset($_GET['code'])){ 
    $accessToken = $gClient->authenticate($_GET['code']); 
    $_SESSION['token'] = $gClient->getAccessToken(); 
    
    if(isset($accessToken) ){
    header('Location: '.lienCompte()); 
    }else{
    header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
    }
    
} 
 
if(isset($_SESSION['token'])){ 
    $gClient->setAccessToken($_SESSION['token']); 
}

echo $_SESSION['token'];
  
if($gClient->getAccessToken()){ 
    
    //print_r($_GET['token']);
    // Get user profile data from google 
    $gpUserProfile = $google_oauthV2->userinfo->get(); 
     
    // Initialize User class 
    $user = new User(); 
     
    // Getting user profile info 
    $gpUserData = array(); 
    $gpUserData['oauth_uid']    = !empty($gpUserProfile['id'])?$gpUserProfile['id']:''; 
    $gpUserData['prenom']       = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:''; 
    $gpUserData['nom']          = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:''; 
    $gpUserData['email']        = !empty($gpUserProfile['email'])?$gpUserProfile['email']:''; 
     
    // Insert or update user data to the database 
    $gpUserData['oauth_provider'] = 'google'; 
    $userData = $user->checkUser($gpUserData); 
    
    // Storing user data in the session 
    $_SESSION['userData'] = $userData; 
}

?>