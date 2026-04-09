<?php
/**
 * oauth-config.php
 * Charge les paramètres OAuth depuis la base de données (site_configuration).
 * Ce fichier est inclus par oauth-callback.php.
 * 
 * Variables exposées :
 *   $GOOGLE_CLIENT_ID, $GOOGLE_CLIENT_SECRET, $google_login_enabled
 *   $FACEBOOK_APP_ID, $FACEBOOK_APP_SECRET, $facebook_login_enabled
 *   $oauth_base_url  (URL de base du site pour les redirections)
 */

if (!isset($connexion)) {
    require_once __DIR__ . '/include.php';
}

// Lire la config depuis la BDD (déjà chargée par connec.php via $$key)
$GOOGLE_CLIENT_ID      = !empty($GOOGLE_CLIENT_ID)      ? $GOOGLE_CLIENT_ID      : '';
$GOOGLE_CLIENT_SECRET  = !empty($GOOGLE_CLIENT_SECRET)  ? $GOOGLE_CLIENT_SECRET  : '';
$FACEBOOK_APP_ID       = !empty($FACEBOOK_APP_ID)       ? $FACEBOOK_APP_ID       : '';
$FACEBOOK_APP_SECRET   = !empty($FACEBOOK_APP_SECRET)   ? $FACEBOOK_APP_SECRET   : '';
$google_login_enabled   = isset($google_login_enabled)   ? (int)$google_login_enabled  : 0;
$facebook_login_enabled = isset($facebook_login_enabled) ? (int)$facebook_login_enabled : 0;

// URL de base dynamique (locale ou production)
$is_local = ($_SERVER['SERVER_NAME'] === 'localhost' ||
             $_SERVER['REMOTE_ADDR'] === '127.0.0.1'  ||
             $_SERVER['REMOTE_ADDR'] === '::1');

$oauth_base_url = $is_local
    ? 'http://localhost/shop'
    : rtrim($chemin_absolu, '/');

// URIs de redirection (à enregistrer dans Google Console / Facebook Dev Portal)
define('GOOGLE_REDIRECT_URI',   $oauth_base_url . '/oauth-callback.php?provider=google');
define('FACEBOOK_REDIRECT_URI', $oauth_base_url . '/oauth-callback.php?provider=facebook');

// Scopes
define('GOOGLE_SCOPES',   'openid email profile');
define('FACEBOOK_SCOPES', 'public_profile');

// Endpoints OAuth
define('GOOGLE_AUTH_URL',    'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL',   'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL','https://www.googleapis.com/oauth2/v3/userinfo');

define('FACEBOOK_AUTH_URL',    'https://www.facebook.com/v19.0/dialog/oauth');
define('FACEBOOK_TOKEN_URL',   'https://graph.facebook.com/v19.0/oauth/access_token');
define('FACEBOOK_USERINFO_URL','https://graph.facebook.com/me?fields=id,first_name,last_name,email');
