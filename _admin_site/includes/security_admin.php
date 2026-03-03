<?php
session_start();
//include("includes/include.php");
if(!isset($_SESSION['sess_id'])){
      header("location:login.php");
      die();
   }
   $sess_id=$_SESSION['sess_id'];
   $admin_group=$_SESSION['admin_group'];
   $user_check = $_SESSION['login_user'];
   if($admin_group!=1) {
	  header("location:login.php");
      die();   
   }
   $ses_sql = executeRequete("select * from utilisateurs where tel = '$user_check' AND sess_id='".$sess_id."' AND admin='1' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   if(!isset($row['id'])){
      header("location:login.php");
      die();
   } else {
	$login_session = $row['tel'];   
   }
   
   
   
   
?>