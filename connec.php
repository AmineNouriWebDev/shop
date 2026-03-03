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
mysqli_set_charset($connexion, "utf8");

function sanitize($data) {
	global $connexion;
	if (!$connexion || !($connexion instanceof mysqli)) {
		$conn = connexionBDD();
		$connexion = mysqli_connect($conn['serveur'], $conn['user_bdd'], $conn['user_pass'], $conn['name_bdd']);
		if (!$connexion) { die("Connection failed: " . mysqli_connect_error()); }
		mysqli_set_charset($connexion, "utf8");
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
function nettrecherche($chaine) { $chaine = trim($chaine); }
function nettflux($chaine) { $chaine = trim($chaine); $new = str_replace(array("&amp;", "&nbsp;", "&agrave;", "&acirc;", "&eacute;", "&Eacute;", "&egrave;", "&ecirc;", "&icirc;", "&ccedil;", "&iuml;", "&oelig;", "&ugrave;", "&ucirc;", "&ocirc;", "&lt;", "&gt;", "&laquo;", "&raquo;", "&quot;", "&rsquo;", "&euro;"), array("&", " ", "", "", "", "", "", "", "", "", "", "", "", "", "", "<", ">", "", "", "'", "'", ""), $chaine); return $new; }
function nett($chaine) { $chaine = trim($chaine); $chaine = strtolower($chaine); $chaine = url_rewrite($chaine, 'utf-8'); $new = str_replace(array(" ", "#216;", "&amp;#200;", "&amp;#201;", "&amp;#202;", "&agrave;", "&acirc;", "&eacute;", "&egrave;", "&ecirc;", "&icirc;", "&ccedil;", "&iuml;", "&oelig;", "&ugrave;", "&ucirc;", "&ocirc;", "&Agrave;", "&Acirc;", "&Eacute;", "&Egrave;", "&Ecirc;", "&Icirc;", "&Ccedil;", "&Iuml;", "&Oelig;", "&Ugrave;", "&Ucirc;", "&Ocirc;", "&lt;", "&gt;", "&laquo;", "&raquo;", "&quot;", "&amp;", "'", "*", "&", ":", "+", "_", ")", "\\'", "/", "\\", "(", "%", ",", "!", " ", "--"), "-", $chaine); $new = rtrim($new, '-'); return strtolower($new); }
function url_rewrite($text, $charset = 'utf-8') { $text = htmlentities($text, ENT_NOQUOTES, $charset); $text = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $text); $text = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $text); $text = preg_replace('#&[^;]+;#', '', $text); $text = mb_strtolower($text, 'UTF-8'); $text = preg_replace('#[^a-zA-Z0-9]#', '-', $text); while (strstr($text, '--')) $text = str_replace('--', '-', $text); return $text; }
function nettinverse($chaine) { $new = str_replace(array("", ""), array("&agrave;", "&acirc;"), $chaine); return $new; } // Simplified for brevity as mostly unused in login

$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$data = mysqli_fetch_array($res);
if ($data) {
    foreach ($data as $key => $value) {
       if (!is_numeric($key)) { $$key = afficher($value); }
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

function cheminAbsolu() {
	$chemin = array();
	if ($_SERVER['SERVER_ADDR'] == "127.0.0.1") {
		$chemin['chemin_absolu'] = "https://clients.onlytech.tn/motaawebsite/";
		$chemin['chemin_admin'] = "_admin_site/";
		$chemin['chemin_media'] = "media";
		$chemin['chemin_functions'] = "fonctions";
	} else {
		$chemin['chemin_absolu'] = "localhost";
		$chemin['chemin_admin'] = "root";
		$chemin['chemin_media'] = "media";
		$chemin['chemin_functions'] = "fonctions";
	}
	return $chemin;
}

$is_local = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1');
if ($is_local) { $chemin_absolu = "http://localhost/shop/"; }
else { $chemin_absolu = !empty($chemin_absolu) ? $chemin_absolu : 'http://localhost/shop/'; }
$chemin_admin = '_admin_site/';
$chemin_functions = 'fonctions';
$chemin_media = 'media/';
