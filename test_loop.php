<?php
set_time_limit(5); // Stop after 5 seconds to prevent true infinite loops server-side during test
include "connec.php";
require_once "_admin_site/includes/fonctions/fction_generale.php"; // assuming executeRequete is here?

// Try to include the file to see if it hangs
ob_start();
include "_admin_site/includes/pages.php";
$output = ob_get_clean();
echo "Execution finished. Output length: " . strlen($output);
?>
