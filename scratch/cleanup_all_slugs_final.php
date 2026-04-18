<?php
include("../include.php");

// Prevention: disable error display to keep output clean
ini_set('display_errors', 0);
error_reporting(E_ALL);

echo "<h1>Migration Globale des Slugs SEO</h1>";

$connexion = ouvrirCnx();
$res = mysqli_query($connexion, "SELECT id, titre, link FROM produits");

$count = 0;
$updated = 0;

while ($row = mysqli_fetch_assoc($res)) {
    $count++;
    $id = $row['id'];
    $old_link = $row['link'];
    // Generate new clean link using the updated nett() function in connec.php
    $new_link = nett($row['titre']);
    
    if ($new_link !== $old_link && !empty($new_link)) {
        echo "Produit #$id : '$old_link' -> <strong>'$new_link'</strong><br>";
        
        $old_link_esc = mysqli_real_escape_string($connexion, $old_link);
        $new_link_esc = mysqli_real_escape_string($connexion, $new_link);
        
        // 1. Archive in the redirects table
        mysqli_query($connexion, "INSERT INTO `produits_redirects` (id_produit, old_link) VALUES ('$id', '$old_link_esc')");
        
        // 2. Update the product itself
        mysqli_query($connexion, "UPDATE `produits` SET `link` = '$new_link_esc', `link_old` = '$old_link_esc' WHERE id = '$id'");
        
        $updated++;
    }
}

echo "<hr>";
echo "Migration terminée !<br>";
echo "Total produits analysés : $count<br>";
echo "Total produits mis à jour : $updated<br>";

if ($updated > 0) {
    echo "<p style='color:green;'>Succès : Tous les liens 'sales' ont été nettoyés et les redirections 301 sont actives.</p>";
} else {
    echo "<p>Tous les liens étaient déjà propres.</p>";
}
?>
