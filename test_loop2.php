<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("connec.php");
include("_admin_site/includes/fonctions/fction_db.php");
// Mock functions usually defined in other included files
// fction_pages.php or similar might have 'supprimerPages'
if (!function_exists('supprimerPages')) {
    function supprimerPages($id) {}
}

echo "<html><body><p>Starting execution...</p>";
ob_start();
try {
    include("_admin_site/includes/pages.php");
} catch (\Throwable $e) {
    echo "<b>Fatal Error Handled:</b> " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine();
}
$out = ob_get_clean();
echo "Execution done! Output length: " . strlen($out);
if (strpos($out, "Fatal Error") !== false) echo "<br>Error found in output.";
?>
