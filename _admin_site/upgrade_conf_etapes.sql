-- =====================================================================
-- UPGRADE conf_etapes — Multi-sources + Rôles intelligents
-- À exécuter dans phpMyAdmin (LOCAL et EN LIGNE)
-- =====================================================================

-- 1. Ajouter les colonnes multi-sources et rôle (IF NOT EXISTS = sans erreur si déjà fait)
ALTER TABLE `conf_etapes`
    ADD COLUMN IF NOT EXISTS `categories_ids` TEXT DEFAULT NULL COMMENT 'JSON array of category IDs',
    ADD COLUMN IF NOT EXISTS `produits_ids`   TEXT DEFAULT NULL COMMENT 'JSON array of specific product IDs',
    ADD COLUMN IF NOT EXISTS `role`           VARCHAR(50) DEFAULT NULL COMMENT 'dvr|nvr|camera_filaire|camera_wifi|hdd|cable|switch|alimentation|accessoire';

-- 2. Migration automatique des données existantes
--    (Pour les étapes déjà créées, on peuple les nouvelles colonnes depuis id_lien)
UPDATE `conf_etapes`
SET `categories_ids` = CONCAT('["', `id_lien`, '"]')
WHERE `type_lien` = 'categorie'
  AND `id_lien` > 0
  AND (`categories_ids` IS NULL OR `categories_ids` = '');

UPDATE `conf_etapes`
SET `produits_ids` = CONCAT('["', `id_lien`, '"]')
WHERE `type_lien` = 'produit'
  AND `id_lien` > 0
  AND (`produits_ids` IS NULL OR `produits_ids` = '');

-- Vérification (optionnel)
-- SELECT id, titre, type_lien, id_lien, categories_ids, produits_ids, role FROM conf_etapes;
