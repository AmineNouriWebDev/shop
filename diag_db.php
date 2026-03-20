<?php
include("connec.php");

echo "<h1>Diagnostic BDD</h1>";

echo "<h2>Bloc Accueil - Texte Topbar</h2>";
$req = "SELECT * FROM `bloc_accueil` WHERE `titre_bloc` = 'Texte Topbar'";
$res = mysqli_query($connexion, $req);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Contenu: <pre>" . htmlspecialchars($row['contenu']) . "</pre><br>";
        echo "Icone: " . $row['icone'] . "<br>";
    }
} else {
    echo "Erreur requête bloc_accueil: " . mysqli_error($connexion);
}

echo "<h2>Configuration du site (site_configuration)</h2>";
$req = "SELECT * FROM `site_configuration` LIMIT 1";
$res = mysqli_query($connexion, $req);
if ($res) {
    $row = mysqli_fetch_assoc($res);
    foreach ($row as $key => $value) {
        echo "<strong>$key</strong>: " . htmlspecialchars($value) . "<br>";
    }
} else {
    echo "Erreur requête site_configuration: " . mysqli_error($connexion);
}
?>
