<?php

  session_start();

include("include.php");
	
require_once "config_google_facebook.php";
	
require_once "User.class.php";

if(!session_id()){
    session_start();
}

// Include the autoloader provided in the SDK
require_once(__DIR__.'/Facebook/autoload.php');

// Call Facebook API
$fb = new Facebook\Facebook([
 'app_id' => APP_ID,
 'app_secret' => APP_SECRET,
 'default_graph_version' => API_VERSION,
]);


// Get redirect login helper
$fb_helper = $fb->getRedirectLoginHelper();


// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token']))
		{ $accessTokenFB = $_SESSION['facebook_access_token']; }
	else
		{ $accessTokenFB = $fb_helper->getAccessToken(); }
} catch(FacebookResponseException $e) {
     echo 'Facebook API Error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK Error: ' . $e->getMessage();
      exit;
}

$permissions = ['email']; // Optional permissions

/*--------------------------------------- Facebook ------------------------------------------*/

if(isset($accessTokenFB)){
    //print_r($accessTokenFB);
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessTokenFB;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location:'.lienCompte());
    }
    
    // Getting user's profile info from Facebook
    try {
        $graphResponse = $fb->get('/me?fields=id,first_name,last_name,email,link');
        $fbUser = $graphResponse->getGraphUser();
    }  catch(FacebookResponseException $e) {
         echo 'Facebook API Error: ' . $e->getMessage();
          exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK Error: ' . $e->getMessage();
          exit;
    }
    
    // Initialize User class
    $userFb = new UserFb();
    
    $fbUserData = array(); 
    $fbUserData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:''; 
    $fbUserData['prenom']       = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
    $fbUserData['nom']          = !empty($fbUser['last_name'])?$fbUser['last_name']:''; 
    $fbUserData['email']        = !empty($fbUser['email'])?$fbUser['email']:''; 
    $fbUserData['link']         = !empty($fbUser['link'])?$fbUser['link']:'';
    
    // Insert or update user data to the database
    $fbUserData['oauth_provider'] = 'facebook';
    $userDataFb = $userFb->checkUserFb($fbUserData);
    
    // Storing user data in the session
    $_SESSION['userData'] = $userDataFb;
    
    // Get logout url
    //$logoutURL = $fb_helper->getLogoutUrl($accessTokenFB, '/'.lienDeconnexion());
}else{
    
// Get login url
$loginURL = $fb_helper->getLoginUrl(FB_BASE_URL, $permissions);

}

?>