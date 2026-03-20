<?php
// Database configuration - environment specific
$conn_env = array();

if (
    $_SERVER['SERVER_NAME'] == 'localhost'
    || $_SERVER['REMOTE_ADDR'] == '127.0.0.1'
    || $_SERVER['REMOTE_ADDR'] == '::1'
) {
    // LOCAL (XAMPP)
    $conn_env['serveur']   = "localhost";
    $conn_env['user_bdd']  = "root";
    $conn_env['user_pass'] = "";
    $conn_env['name_bdd']  = "shop";
} else {
    // PRODUCTION
    $conn_env['serveur']   = "localhost";
    $conn_env['user_bdd']  = "technopl_dbuser19985";
    $conn_env['user_pass'] = "Techno+u2698iO$";
    $conn_env['name_bdd']  = "technopl_db";
}
?>
