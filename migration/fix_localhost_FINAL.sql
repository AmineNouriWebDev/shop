-- ============================================
-- Script SQL SIMPLIFIÉ - Version corrigée
-- Exécutez ce script dans phpMyAdmin
-- ============================================

-- ÉTAPE 1: Configuration principale (CRITIQUE)
UPDATE site_configuration 
SET chemin_absolu = 'https://technoplus.io/', 
    protocole = '2'
WHERE id = 1;

-- ÉTAPE 2: Blocs d'accueil
UPDATE bloc_accueil 
SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE lien LIKE '%localhost%';

-- ÉTAPE 3: Sliders
UPDATE sliders 
SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE lien LIKE '%localhost%';

-- ÉTAPE 4: Produits (colonne = 'link')
UPDATE produits 
SET link = REPLACE(link, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link LIKE '%localhost%';

-- ÉTAPE 5: Categories blog (colonne = 'link')
UPDATE categories_blog 
SET link = REPLACE(link, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link LIKE '%localhost%';

-- ÉTAPE 6: Site menu
UPDATE site_menu 
SET link_externe = REPLACE(link_externe, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link_externe LIKE '%localhost%';

-- ============================================
-- VÉRIFICATION - NE DOIT RIEN RETOURNER
-- ============================================
SELECT 'site_configuration' as table_name, chemin_absolu as url 
FROM site_configuration 
WHERE chemin_absolu LIKE '%localhost%'
UNION ALL
SELECT 'bloc_accueil', lien FROM bloc_accueil WHERE lien LIKE '%localhost%'
UNION ALL
SELECT 'sliders', lien FROM sliders WHERE lien LIKE '%localhost%'
UNION ALL
SELECT 'produits', link FROM produits WHERE link LIKE '%localhost%'
UNION ALL
SELECT 'categories_blog', link FROM categories_blog WHERE link LIKE '%localhost%'
UNION ALL
SELECT 'site_menu', link_externe FROM site_menu WHERE link_externe LIKE '%localhost%';

-- Si cette requête retourne 0 résultat = SUCCÈS ✅
-- Si elle retourne des résultats = il reste des URLs à corriger

-- ============================================
-- CONFIRMATION FINALE
-- ============================================
SELECT 'Configuration actuelle' as info, 
       chemin_absolu, 
       protocole 
FROM site_configuration 
WHERE id = 1;

-- Résultat attendu:
-- chemin_absolu = https://technoplus.io/
-- protocole = 2
