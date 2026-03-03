
 <?php

  session_start();

include("include.php");
	
require_once "config_google.php";
	
require_once "User.class.php";
/*--------------------------------------- Facebook ------------------------------------------*/

if(isset($accessTokenFb)){
    //print_r($accessTokenFb);
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessTokenFb;
        
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
        $graphResponse = $fb->get('/me?fields=name,first_name,last_name,email');
        $fbUser = $graphResponse->getGraphUser();
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location:".lienConnexion());
        exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    // Initialize User class
    $userFb = new UserFb();
    
    $fbUserData = array(); 
    $fbUserData['oauth_uid']  = !empty($fbUser['id'])?$fbUser['id']:''; 
    $fbUserData['prenom'] = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
    $fbUserData['nom']  = !empty($fbUser['last_name'])?$fbUser['last_name']:''; 
    $fbUserData['email']       = !empty($fbUser['email'])?$fbUser['email']:''; 
    
    // Insert or update user data to the database
    $fbUserData['oauth_provider'] = 'facebook';
    $userDataFb = $userFb->checkUserFb($fbUserData);
    
    // Storing user data in the session
    $_SESSION['userData'] = $userDataFb;
    
    // Get logout url
    $logoutURL = $helper->getLogoutUrl($accessTokenFb, FB_REDIRECT_URL.lienDeconnexion());
} 

?>