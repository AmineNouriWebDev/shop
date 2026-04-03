<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['sess_id'])){
    header("location:login.php");
    die();
}
$sess_id=$_SESSION['sess_id'];
$user_check = $_SESSION['editor_login'] ?? '';
$ses_sql = executeRequete("select * from editor where ses_id='".$sess_id."'");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

if(!isset($row['editor_id'])){
    header("location:login.php");
    die();
} else {
    $login_session = $row['editor_user_name'];   
}
?>