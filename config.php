<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'monsite_db');
define('DB_USER_TBL', 'clients');

$config = array(
	"base_url" => "http://localhost/technoplus/login-with.php",
	"providers" => array(

		"Google" => array(
			"enabled" => true,
			"keys"    => array("id" => "YOUR_GOOGLE_CLIENT_ID", "secret" => "YOUR_GOOGLE_CLIENT_SECRET"),
			"redirect_uri" => "http://localhost/shop/login-with.php?hauth.done=Google",
		),

		"Facebook" => array(
			"enabled" => true,
			"keys"    => array("id" => "YOUR_FACEBOOK_APP_ID", "secret" => "YOUR_FACEBOOK_APP_SECRET"),
			"redirect_uri" => "http://localhost/technoplus/login-with.php?hauth.done=Facebook",
		),

		/*"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "XXXXXXXX", "secret" => "XXXXXXX" ) 
			),*/
	),
	// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
	"debug_mode" => false,
	"debug_file" => "",
);
