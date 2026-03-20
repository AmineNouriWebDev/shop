<?php
/**
 * oauth-callback.php
 * Callback OAuth unifié pour Google et Facebook.
 * Utilise directement $connexion (chargé par include.php) — pas de User.class.php.
 */

session_start();
require_once __DIR__ . '/include.php';    // charge connec.php → $connexion, lien.php, etc.
require_once __DIR__ . '/oauth-config.php'; // charge les clés depuis site_configuration

$provider = strtolower($_GET['provider'] ?? '');

// ─────────────────────────────────────────────────────────────
// Helpers HTTP (cURL natif)
// ─────────────────────────────────────────────────────────────

function oauth_post(string $url, array $params): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($params),
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
    ]);
    $body = curl_exec($ch);
    curl_close($ch);
    return json_decode($body ?: '{}', true) ?? [];
}

function oauth_get(string $url, string $access_token): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ["Authorization: Bearer $access_token"],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT        => 15,
    ]);
    $body = curl_exec($ch);
    curl_close($ch);
    return json_decode($body ?: '{}', true) ?? [];
}

// ─────────────────────────────────────────────────────────────
// Gestion BDD — INSERT ou UPDATE le client OAuth
// Utilise directement $connexion global (pas de User.class.php)
// ─────────────────────────────────────────────────────────────

function oauthUpsertClient(array $data): ?array {
    global $connexion;

    $provider = mysqli_real_escape_string($connexion, $data['oauth_provider']);
    $uid      = mysqli_real_escape_string($connexion, $data['oauth_uid']);
    $nom      = mysqli_real_escape_string($connexion, $data['nom']);
    $prenom   = mysqli_real_escape_string($connexion, $data['prenom']);
    $email    = mysqli_real_escape_string($connexion, $data['email']);
    $now      = time();

    // Chercher le client existant (par oauth_provider + oauth_uid)
    $res = mysqli_query($connexion,
        "SELECT * FROM `clients` WHERE `oauth_provider`='$provider' AND `oauth_uid`='$uid' LIMIT 1"
    );
    $existing = $res ? mysqli_fetch_assoc($res) : null;

    if ($existing) {
        // Mettre à jour nom/prenom/email si changés
        mysqli_query($connexion,
            "UPDATE `clients` SET
                `nom`='$nom', `prenom`='$prenom', `email`='$email',
                `date_modif`='$now'
             WHERE `oauth_provider`='$provider' AND `oauth_uid`='$uid'"
        );
    } else {
        // Insérer un nouveau client — le compte est immédiatement actif (etat=1)
        mysqli_query($connexion,
            "INSERT INTO `clients`
                (`nom`, `prenom`, `email`, `password`, `etat`, `oauth_provider`, `oauth_uid`, `date_creation`)
             VALUES
                ('$nom', '$prenom', '$email', '', 1, '$provider', '$uid', '$now')"
        );
    }

    // Re-lire pour avoir l'id et toutes les colonnes
    $res2 = mysqli_query($connexion,
        "SELECT * FROM `clients` WHERE `oauth_provider`='$provider' AND `oauth_uid`='$uid' LIMIT 1"
    );
    return $res2 ? mysqli_fetch_assoc($res2) : null;
}

// ─────────────────────────────────────────────────────────────
// Créer la session identique au login classique
// ─────────────────────────────────────────────────────────────

function createOAuthSession(array $dbUser): void {
    global $connexion;
    $sess_id = md5(microtime() . $dbUser['id'] . rand());
    $_SESSION['client_id']    = $dbUser['id'];
    $_SESSION['client_login'] = $dbUser['email'];
    $_SESSION['client_nom']   = $dbUser['nom'];
    $_SESSION['sess_id']      = $sess_id;
    $sid = mysqli_real_escape_string($connexion, $sess_id);
    mysqli_query($connexion, "UPDATE `clients` SET `sess_id`='$sid' WHERE `id`='" . (int)$dbUser['id'] . "'");
}

// ─────────────────────────────────────────────────────────────
// Redirect vers connexion avec message d'erreur flash
// ─────────────────────────────────────────────────────────────

function oauthError(string $msg): never {
    $_SESSION['oauth_error'] = $msg;
    header('Location: ' . lienConnexion());
    exit;
}

// ─────────────────────────────────────────────────────────────
// Vérification CSRF (state)
// ─────────────────────────────────────────────────────────────

if (empty($_GET['state']) || $_GET['state'] !== ($_SESSION['oauth_state'] ?? '')) {
    oauthError('Requête invalide (protection CSRF). Veuillez réessayer.');
}
unset($_SESSION['oauth_state']);

if (isset($_GET['error'])) {
    oauthError('Connexion annulée.');
}

// ─────────────────────────────────────────────────────────────
// GOOGLE
// ─────────────────────────────────────────────────────────────

if ($provider === 'google') {

    if (empty($google_login_enabled) || empty($GOOGLE_CLIENT_ID)) {
        oauthError('La connexion Google est désactivée.');
    }

    // 1. Échanger le code contre un access_token
    $tokenData = oauth_post(GOOGLE_TOKEN_URL, [
        'code'          => $_GET['code'] ?? '',
        'client_id'     => $GOOGLE_CLIENT_ID,
        'client_secret' => $GOOGLE_CLIENT_SECRET,
        'redirect_uri'  => GOOGLE_REDIRECT_URI,
        'grant_type'    => 'authorization_code',
    ]);

    if (empty($tokenData['access_token'])) {
        oauthError('Impossible d\'obtenir le token Google. Veuillez réessayer.');
    }

    // 2. Récupérer les infos utilisateur
    $gUser = oauth_get(GOOGLE_USERINFO_URL, $tokenData['access_token']);

    if (empty($gUser['email'])) {
        oauthError('Google n\'a pas fourni d\'adresse email. Vérifiez les permissions de l\'application.');
    }

    // 3. Créer ou mettre à jour le client en BDD
    $dbUser = oauthUpsertClient([
        'oauth_provider' => 'google',
        'oauth_uid'      => $gUser['sub'],
        'nom'            => $gUser['family_name']  ?? ($gUser['name'] ?? ''),
        'prenom'         => $gUser['given_name']   ?? '',
        'email'          => $gUser['email'],
    ]);

// ─────────────────────────────────────────────────────────────
// FACEBOOK
// ─────────────────────────────────────────────────────────────

} elseif ($provider === 'facebook') {

    if (empty($facebook_login_enabled) || empty($FACEBOOK_APP_ID)) {
        oauthError('La connexion Facebook est désactivée.');
    }

    // 1. Échanger le code contre un access_token
    $tokenData = oauth_post(FACEBOOK_TOKEN_URL, [
        'code'          => $_GET['code'] ?? '',
        'client_id'     => $FACEBOOK_APP_ID,
        'client_secret' => $FACEBOOK_APP_SECRET,
        'redirect_uri'  => FACEBOOK_REDIRECT_URI,
    ]);

    if (empty($tokenData['access_token'])) {
        oauthError('Impossible d\'obtenir le token Facebook. Veuillez réessayer.');
    }

    // 2. Récupérer les infos via Graph API (GET direct — pas de Bearer)
    $fbUrl = FACEBOOK_USERINFO_URL . '&access_token=' . urlencode($tokenData['access_token']);
    $ch = curl_init($fbUrl);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_TIMEOUT => 15]);
    $fbUser = json_decode(curl_exec($ch) ?: '{}', true) ?? [];
    curl_close($ch);

    if (empty($fbUser['id'])) {
        oauthError('Facebook n\'a pas retourné les informations du compte.');
    }

    $email = $fbUser['email'] ?? ('fb_' . $fbUser['id'] . '@noemail.local');

    // 3. Créer ou mettre à jour le client en BDD
    $dbUser = oauthUpsertClient([
        'oauth_provider' => 'facebook',
        'oauth_uid'      => $fbUser['id'],
        'nom'            => $fbUser['last_name']  ?? ($fbUser['name'] ?? ''),
        'prenom'         => $fbUser['first_name'] ?? '',
        'email'          => $email,
    ]);

} else {
    oauthError('Provider OAuth inconnu.');
}

// ─────────────────────────────────────────────────────────────
// Créer la session et rediriger
// ─────────────────────────────────────────────────────────────

if (empty($dbUser)) {
    oauthError('Erreur lors de la création du compte. Veuillez réessayer.');
}

createOAuthSession($dbUser);

$redir = (isset($_SESSION['panier']['idcart']) &&
          is_array($_SESSION['panier']['idcart']) &&
          count($_SESSION['panier']['idcart']) > 0)
    ? lienPanier()
    : lienCompte();

header('Location: ' . $redir);
exit;
