<?php
// ── One-time migration: add note_avis + nb_avis to produits, create avis_produits ──
session_start();
include('includes/include.php');
$cnx = ouvrirCnx();

$steps = [];

// 1. note_avis column
$c1 = mysqli_query($cnx, "ALTER TABLE `produits` ADD COLUMN `note_avis` DECIMAL(3,2) NOT NULL DEFAULT 0.00 AFTER `video`");
$steps[] = $c1 ? '✅ note_avis column added' : '⚠️ note_avis: ' . mysqli_error($cnx);

// 2. nb_avis column
$c2 = mysqli_query($cnx, "ALTER TABLE `produits` ADD COLUMN `nb_avis` INT NOT NULL DEFAULT 0 AFTER `note_avis`");
$steps[] = $c2 ? '✅ nb_avis column added' : '⚠️ nb_avis: ' . mysqli_error($cnx);

// 3. avis_produits table
$c3 = mysqli_query($cnx, "CREATE TABLE IF NOT EXISTS `avis_produits` (
  `id`           INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_produit`   INT          NOT NULL,
  `id_client`    INT          NOT NULL,
  `note`         TINYINT(1)   NOT NULL DEFAULT 0,
  `datecreation` DATETIME     DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_vote` (`id_produit`,`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
$steps[] = $c3 ? '✅ avis_produits table created' : '⚠️ avis_produits: ' . mysqli_error($cnx);

// 4. Random seed: update all existing products with note > 4 and random nb_avis
// Notes: random between 4.0 and 5.0 (step 0.1)
$c4 = mysqli_query($cnx, "UPDATE `produits` SET 
  `note_avis` = ROUND(4.0 + RAND() * 1.0, 1),
  `nb_avis`   = FLOOR(18 + RAND() * 480)
WHERE `note_avis` = 0 AND `etat` = 1");
$nb_updated = mysqli_affected_rows($cnx);
$steps[] = $c4 ? "✅ $nb_updated produits mis à jour avec notes aléatoires (4.0–5.0)" : '⚠️ seed: ' . mysqli_error($cnx);

echo '<pre style="font-family:monospace; padding:2rem;">';
echo "<b>Migration Résultats</b>\n\n";
foreach ($steps as $s) echo $s . "\n";
echo "\n<a href='index.php'>← Retour admin</a>";
echo '</pre>';
?>
