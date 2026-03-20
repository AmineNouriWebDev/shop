<?php
session_start();
include("connec.php");
$r = mysqli_query($connexion, "SELECT ses_id, editor_user_name FROM editor LIMIT 1");
$data = mysqli_fetch_assoc($r);
$_SESSION['sess_id'] = $data['ses_id'];
$_SESSION['editor_login'] = $data['editor_user_name'];
$_SESSION['editor_id'] = 34; // mock
echo "Session Set: " . $data['ses_id'];
?>
