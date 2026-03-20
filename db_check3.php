<?php
include("connec.php");

echo "Checking site_configuration:<br>";
$req = "SELECT * FROM site_configuration";
$res = mysqli_query($connexion, $req);
while ($row = mysqli_fetch_assoc($res)) {
    foreach ($row as $k => $v) {
        if (strpos($v, 'Warning') !== false || strpos($v, 'disponibles') !== false || strpos($v, 'telConf') !== false) {
            echo "Found in site_configuration.$k : " . htmlspecialchars($v) . "<br>";
            // Auto clean
            $clean = mysqli_real_escape_string($connexion, "");
            mysqli_query($connexion, "UPDATE site_configuration SET $k = '$clean' WHERE id = " . $row['id']);
        }
    }
}

echo "Checking bloc_accueil:<br>";
$req2 = "SELECT * FROM bloc_accueil";
$res2 = mysqli_query($connexion, $req2);
while ($row = mysqli_fetch_assoc($res2)) {
    foreach ($row as $k => $v) {
        if (strpos($v, 'Warning') !== false || strpos($v, 'disponibles') !== false || strpos($v, 'telConf') !== false) {
            echo "Found in bloc_accueil.$k (ID " . $row['id'] . ") : " . htmlspecialchars($v) . "<br>";
            // Auto clean
            $clean = mysqli_real_escape_string($connexion, "");
            mysqli_query($connexion, "UPDATE bloc_accueil SET $k = '$clean' WHERE id = " . $row['id']);
        }
    }
}

echo "Done.";
?>
