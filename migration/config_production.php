<?php
/*
 * Configuration PRODUCTION pour technoplus.io
 * Remplace config.php après upload sur le serveur
 */

// Database configuration - PRODUCTION
define('DB_HOST', 'localhost'); // Ne pas changer pour cPanel
define('DB_USERNAME', 'VOTRE_USER_CPANEL'); // ⚠️ À REMPLACER
define('DB_PASSWORD', 'VOTRE_PASSWORD_CPANEL'); // ⚠️ À REMPLACER
define('DB_NAME', 'VOTRE_DBNAME_CPANEL'); // ⚠️ À REMPLACER (format: username_monsite_db)
define('DB_USER_TBL', 'clients');

// OAuth Configuration - PRODUCTION
$config = array(
	"base_url" => "https://technoplus.io/login-with.php",
	"providers" => array(

		"Google" => array(
			"enabled" => true,
			"keys"    => array(
				"id" => "YOUR_GOOGLE_CLIENT_ID", 
				"secret" => "YOUR_GOOGLE_CLIENT_SECRET"
			),
			"redirect_uri" => "https://technoplus.io/login-with.php?hauth.done=Google",
		),

		"Facebook" => array(
			"enabled" => true,
			"keys"    => array(
				"id" => "YOUR_FACEBOOK_APP_ID", 
				"secret" => "YOUR_FACEBOOK_APP_SECRET"
			),
			"redirect_uri" => "https://technoplus.io/login-with.php?hauth.done=Facebook",
		),
	),
	// Désactiver le debug en production
	"debug_mode" => false,
	"debug_file" => "",
);

/*
 * INSTRUCTIONS :
 * 1. Créer la base de données dans cPanel → MySQL Databases
 * 2. Noter le nom d'utilisateur, mot de passe et nom de la BDD
 * 3. Remplacer les valeurs marquées ⚠️ ci-dessus
 * 4. Renommer ce fichier en 'config.php' après upload
 * 5. Mettre à jour les redirect_uri dans Google Cloud Console et Facebook Developers
 */
?>
