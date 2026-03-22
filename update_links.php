<?php
require_once 'connec.php';

$tables_to_check = [
    'liste_section_content' => ['lien', 'lien_url'],
    'menu' => ['lien'],
    'bannieres' => ['lien'],
    'slider' => ['lien_bouton']
];

$updates_count = 0;

echo "<h3>Analyse et mise à jour des liens...</h3>";

foreach ($tables_to_check as $table => $columns) {
    // Vérifier si la table existe
    $res = mysqli_query($connexion, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($res) > 0) {
        foreach ($columns as $column) {
            // Check if column exists
            $col_res = mysqli_query($connexion, "SHOW COLUMNS FROM `$table` LIKE '$column'");
            if (mysqli_num_rows($col_res) > 0) {
                
                $query = "SELECT id, `$column` FROM `$table` WHERE `$column` LIKE '%produit.php?link=%' OR `$column` LIKE '%categorie.php?link=%'";
                $result = mysqli_query($connexion, $query);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<strong>Table $table, Colonne $column : " . mysqli_num_rows($result) . " liens trouvés.</strong><br>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $old_link = $row[$column];
                        $new_link = $old_link;
                        
                        // Replace absolus ou relatifs
                        // Ex: https://offipro.net/produit.php?link=XXX => https://offipro.net/produit/XXX/
                        // Ex: produit.php?link=XXX => /produit/XXX/
                        
                        $new_link = preg_replace('/([\/a-zA-Z0-9\.\:\-]+)?produit\.php\?link=([a-zA-Z0-9\-_]+)/', '$1/produit/$2/', $new_link);
                        $new_link = preg_replace('/([\/a-zA-Z0-9\.\:\-]+)?categorie\.php\?link=([a-zA-Z0-9\-_]+)/', '$1/categorie/$2/', $new_link);
                        
                        // Nettoyer les double slash (sauf pour http:// ou https://)
                        $new_link = preg_replace('/([^:])\/\//', '$1/', $new_link);
                        // S'assurer que ça commence par / si c'était relatif
                        if (strpos($new_link, 'http') === false && strpos($new_link, '/') !== 0) {
                            $new_link = '/' . $new_link;
                        }

                        if ($new_link !== $old_link) {
                            $update_query = "UPDATE `$table` SET `$column` = '" . mysqli_real_escape_string($connexion, $new_link) . "' WHERE id = " . $row['id'];
                            if (mysqli_query($connexion, $update_query)) {
                                echo "  - Mis à jour ID {$row['id']} : $old_link  =>  $new_link<br>";
                                $updates_count++;
                            } else {
                                echo "  - Erreur màj ID {$row['id']} : " . mysqli_error($connexion) . "<br>";
                            }
                        }
                    }
                }
            }
        }
    }
}

echo "<br><b>Terminé. Total des liens mis à jour : $updates_count</b><br>";
echo '<br><i>Vous pouvez maintenant supprimer ce fichier.</i>';
