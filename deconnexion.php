<?php
// Include configuration file 

unset($_SESSION['userData']); 
 
// Destroy entire session data 
   if(session_destroy()) {
      header("Location: ".lienConnexion());
   }
?>