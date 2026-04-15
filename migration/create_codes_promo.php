<?php
/**
 * Migration : Création de la table codes_promo
 * Exécuter une seule fois depuis le navigateur
 */
include('../include.php');

$sql = "CREATE TABLE IF NOT EXISTS `codes_promo` (
    `id`              INT(11)        NOT NULL AUTO_INCREMENT,
    `code`            VARCHAR(50)    NOT NULL UNIQUE,
    `libelle`         VARCHAR(255)   DEFAULT '',
    `type`            ENUM('percent','fixed') NOT NULL DEFAULT 'percent'  COMMENT 'percent = %, fixed = montant fixe DT',
    `valeur`          DECIMAL(10,3)  NOT NULL DEFAULT '0.000',
    `max_utilisations` INT(11)       DEFAULT NULL            COMMENT 'NULL = illimité',
    `utilisations`    INT(11)        NOT NULL DEFAULT 0      COMMENT 'Nombre réel d utilisation',
    `date_expiration` DATE           DEFAULT NULL            COMMENT 'NULL = pas de date limite',
    `montant_min`     DECIMAL(10,3)  NOT NULL DEFAULT '0.000' COMMENT 'Panier minimum requis (0 = aucun)',
    `etat`            TINYINT(1)     NOT NULL DEFAULT 1      COMMENT '1=actif, 0=inactif',
    `created_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_code` (`code`),
    KEY `idx_etat` (`etat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$result = mysqli_query($connexion, $sql);

if ($result) {
    echo "<div style='color:green;font-family:monospace;padding:20px;'>✅ Table <strong>codes_promo</strong> créée avec succès.</div>";
    
    // Ajouter colonne code_promo dans commandes si elle n'existe pas
    $checkCol = mysqli_query($connexion, "SHOW COLUMNS FROM `commandes` LIKE 'code_promo'");
    if (mysqli_num_rows($checkCol) == 0) {
        $alterCmd = "ALTER TABLE `commandes` ADD COLUMN `code_promo` VARCHAR(50) DEFAULT NULL AFTER `remise`";
        $alterDiscount = "ALTER TABLE `commandes` ADD COLUMN `remise_promo` DECIMAL(10,3) DEFAULT 0.000 AFTER `code_promo`";
        mysqli_query($connexion, $alterCmd);
        mysqli_query($connexion, $alterDiscount);
        echo "<div style='color:green;font-family:monospace;padding:10px 20px;'>✅ Colonnes <strong>code_promo</strong> et <strong>remise_promo</strong> ajoutées à la table commandes.</div>";
    } else {
        echo "<div style='color:blue;font-family:monospace;padding:10px 20px;'>ℹ️ Colonne code_promo déjà présente dans commandes.</div>";
    }
} else {
    echo "<div style='color:red;font-family:monospace;padding:20px;'>❌ Erreur : " . mysqli_error($connexion) . "</div>";
}
