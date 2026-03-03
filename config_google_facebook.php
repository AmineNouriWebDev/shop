<?php

// Database configuration
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'monsite_db');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'technoplus_user');
    define('DB_PASSWORD', 'g=6+4eS_=k)W');
    define('DB_NAME', 'technoplus_bd');
}
define('DB_USER_TBL', 'clients');


$connexion = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion,$req);
$data = mysqli_fetch_array($res);
$GOOGLE_CLIENT_ID = $data['GOOGLE_CLIENT_ID'];
$GOOGLE_CLIENT_SECRET = $data['GOOGLE_CLIENT_SECRET'];


/*-------------------------------- Facebook -----------------------------------


define('APP_ID', '1088373559184938');
define('APP_SECRET', '31298d7b34bb9e34371e675849031ce0');
define('API_VERSION', 'v18.0');
define('FB_BASE_URL', 'https://technoplus.tn/connexion.php?facebook'); 



/*-------------------------------- Google -----------------------------------*/

// Google API configuration
define('GOOGLE_CLIENT_ID', $GOOGLE_CLIENT_ID);
define('GOOGLE_CLIENT_SECRET', $GOOGLE_CLIENT_SECRET);
define('GOOGLE_REDIRECT_URL', 'https://technoplus.tn/connexion/');
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


?>