<?php
// Clean connec.php - No display_errors override, no trailing spaces
function connexionBDD() {
        $conn = array();

        require_once 'env.php';

        $conn['serveur']   = $conn_env['serveur'];
        $conn['user_bdd']  = $conn_env['user_bdd'];
        $conn['user_pass'] = $conn_env['user_pass'];
        $conn['name_bdd']  = $conn_env['name_bdd'];

        return $conn;
}

$conn = connexionBDD();
$connexion = mysqli_connect($conn['serveur'], $conn['user_bdd'], $conn['user_pass'], $conn['name_bdd']);
if (!$connexion) {
        die("Erreur connexion DB : " . mysqli_connect_error());
}
mysqli_report(MYSQLI_REPORT_OFF);
mysqli_set_charset($connexion, "utf8mb4");
mysqli_query($connexion, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
mysqli_query($connexion, "SET SESSION sql_mode = ''");

function sanitize($data) {
        global $connexion;
        if (!$connexion || !($connexion instanceof mysqli)) {
                $conn = connexionBDD();
                $connexion = mysqli_connect($conn['serveur'], $conn['user_bdd'], $conn['user_pass'], $conn['name_bdd']);
                if (!$connexion) { die("Connection failed: " . mysqli_connect_error()); }
                mysqli_report(MYSQLI_REPORT_OFF);
                mysqli_set_charset($connexion, "utf8mb4");
                mysqli_query($connexion, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
                mysqli_query($connexion, "SET SESSION sql_mode = ''");
        }
        $data = trim($data ?? '');
        $data = mysqli_real_escape_string($connexion, $data);
        return $data;
}

function afficher($texte) { return $texte; }
function timestamp($date) { list($day, $month, $year) = explode('/', $date); return mktime(0, 180, 0, $month, $day, $year); }
function timestampus($date) { list($year, $month, $day) = explode('-', $date); return mktime(0, 0, 0, $month, $day, $year); }
function timestamptodate($timestamp) { return date("d/m/Y", $timestamp); }
function timestamptodate2($timestamp) { return date("Y-m-d", $timestamp); }
function timestampTDtodate($timestamp) { return date("d/m/Y H:i:s", $timestamp); }
function datefr($date) { list($year, $month, $day) = explode('-', $date); return $day . "/" . $month . "/" . $year; }
function datehtfr($date) { $split = explode(" ", $date); $date = $split[0]; $time = $split[1]; $exp = explode("-", $date); $annee = $exp[0]; $mois = $exp[1]; $jour = $exp[2]; return "$jour/$mois/$annee $time"; }
function dateSanshtfr($date) { $split = explode(" ", $date); $date = $split[0]; $exp = explode("-", $date); $annee = $exp[0]; $mois = $exp[1]; $jour = $exp[2]; return "$jour/$mois/$annee"; }
function datehtus($date) { $split = explode(" ", $date); $date = $split[0]; $time = $split[1]; $exp = explode("/", $date); $annee = $exp[2]; $mois = $exp[1]; $jour = $exp[0]; return "$annee-$mois-$jour $time"; }
function datemois($datefr) { list($day, $month, $year) = explode('/', $datefr); $mois = array("", "Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t", "Septembre", "Octobre", "Novembre", "D&eacute;cembre"); return $day . " " . $mois[ltrim($month, "0")] . " " . $year; }
function dateus($date) { list($day, $month, $year) = explode('/', $date); return $year . "-" . $month . "-" . $day; }
function timestampTD($date) { list($date1, $time) = explode(' ', $date); list($heure, $minutes, $secondes) = explode(':', $time); list($day, $month, $year) = explode('/', $date1); return mktime($heure, $minutes, $secondes, $month, $day, $year); }
function extraire_jour($date) { $split = explode("/", $date); return $split[0]; }
function extraire_mois($date) { $split = explode("/", $date); return $split[1]; }
function extraire_annee($date) { $split = explode("-", $date); return $split[0]; }
function random($car) { $string = ""; $chaine = "abcdefghijklmnpqrstuvwxy1234567890"; srand((float)microtime() * 1000000); for ($i = 0; $i < $car; $i++) { $string .= $chaine[rand() % strlen($chaine)]; } return $string; }
function randomnb($car) { $string = ""; $chaine = "1234567890"; srand((float)microtime() * 1000000); for ($i = 0; $i < $car; $i++) { $string .= $chaine[rand() % strlen($chaine)]; } return $string; }
function tronquer1($texte, $taille, $lien) { if (strlen($texte) >= $taille) { $texte = substr($texte, 0, $taille); $espace = strrpos($texte, " "); $texte = substr($texte, 0, $espace) . '...'; } return $texte; }
function tronquer($texte, $taille) { if (strlen($texte) >= $taille) { $texte = substr($texte, 0, $taille); $espace = strrpos($texte, " "); $texte = substr($texte, 0, $espace) . '...'; } return $texte; }
function formatage($txt) { return strtolower($txt); }
function majuscule($Chaine) { $pos = $Chaine[0]; $maj = strtoupper($pos); $i = 1; $Suite = ""; while ($Chaine[$i]) { $Suite .= $Chaine[$i]; $i++; } return $maj . $Suite; }
function nett($text) {
    if (empty($text)) return "";
    $text = strip_tags($text);
    // Supprimer les entités HTML déjà existantes (comme &#039;) avant de traiter
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    $text = strtr( $text, $unwanted_array );

    // Remplacer tout ce qui n'est pas une lettre ou un chiffre par un tiret
    $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    
    if (empty($text)) return 'p';
    return $text;
}

function url_rewrite($text, $charset = 'utf-8') {
    return nett($text);
}
function nettinverse($chaine) { $new = str_replace(array("", ""), array("&agrave;", "&acirc;"), $chaine); return $new; } // Simplified for brevity as mostly unused in login

$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$data = mysqli_fetch_array($res);
if ($data) {
    foreach ($data as $key => $value) {
       if (!is_numeric($key)) {
           if ($key === 'developer_comment') {
               $$key = $value; // Preserve HTML
           } else {
               $$key = afficher($value);
           }
       }
    }
}

// SEO Data
$req1  = "SELECT * FROM `optimisation_seo` WHERE 1";
$res1  = mysqli_query($connexion, $req1);
$data1 = mysqli_fetch_array($res1);
if ($data1) {
    foreach ($data1 as $key => $value) {
       if (!is_numeric($key)) { $$key = afficher($value); }
    }
}


// Détection de l'environnement
$is_local = (
    (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'))
    || (isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false))
    || (isset($_SERVER['REMOTE_ADDR']) && ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1'))
);

// Force production false si on est sur le domaine officiel
if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'offipro.net') {
    $is_local = false;
}

if ($is_local) {
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8080';
    $chemin_absolu = "http://" . $host . "/";
    // Désactiver Cloudflare Turnstile en local pour éviter les erreurs de domaine
    $cloudflare_site_key = "";
    $cloudflare_secret_key = "";
} else {
    // PRODUCTION : on utilise la valeur déjà récupérée depuis site_configuration
    if (empty($chemin_absolu)) {
        $chemin_absolu = '/';
    }
}
$chemin_admin = '_admin_site/';
$chemin_functions = 'fonctions';
$chemin_media = 'media/';
// offipro

