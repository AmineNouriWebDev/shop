-- ============================================
-- Script SQL COMPLET de correction des URLs localhost
-- À exécuter IMMÉDIATEMENT dans phpMyAdmin sur technoplus.io
-- ============================================

-- 1. MISE À JOUR CRITIQUE : Chemin absolu dans configuration
-- C'est la cause principale de l'alerte JavaScript
UPDATE site_configuration 
SET chemin_absolu = 'https://technoplus.io/', 
    protocole = '2'
WHERE id = 1;

-- 2. Corriger les URLs dans bloc_accueil
UPDATE bloc_accueil 
SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE lien LIKE '%localhost%';

-- 3. Corriger les URLs dans sliders
UPDATE sliders 
SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE lien LIKE '%localhost%';

-- 4. Vérifier s'il reste d'autres URLs localhost dans d'autres tables
-- Produits (utilise 'link' et non 'lien')
UPDATE produits 
SET link = REPLACE(link, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link LIKE '%localhost%';

-- Categories blog
UPDATE categories_blog 
SET link = REPLACE(link, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link LIKE '%localhost%';

-- Articles (vérifier si la colonne existe)
-- UPDATE articles 
-- SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
-- WHERE lien LIKE '%localhost%';

-- Site menu (au cas où)
UPDATE site_menu 
SET link_externe = REPLACE(link_externe, 'http://localhost/technoplus/', 'https://technoplus.io/') 
WHERE link_externe LIKE '%localhost%';

-- Partenaires (vérifier si la colonne existe)
-- UPDATE partenaires 
-- SET lien = REPLACE(lien, 'http://localhost/technoplus/', 'https://technoplus.io/') 
-- WHERE lien LIKE '%localhost%';

-- 5. VÉRIFICATION FINALE - Cette requête NE DOIT RIEN RETOURNER
-- Si elle retourne des résultats, il faut identifier et corriger ces tables
SELECT 'site_configuration' as source, chemin_absolu as url FROM site_configuration WHERE chemin_absolu LIKE '%localhost%'
UNION ALL
SELECT 'site_menu' as source, link_externe FROM site_menu WHERE link_externe LIKE '%localhost%'
UNION ALL
SELECT 'bloc_accueil' as source, lien FROM bloc_accueil WHERE lien LIKE '%localhost%'
UNION ALL
SELECT 'sliders' as source, lien FROM sliders WHERE lien LIKE '%localhost%'
UNION ALL
SELECT 'produits' as source, link FROM produits WHERE link LIKE '%localhost%'
UNION ALL
SELECT 'categories_blog' as source, link FROM categories_blog WHERE link LIKE '%localhost%';

-- 6. Afficher la configuration finale (pour confirmation)
SELECT 'Configuration actuelle' as info, chemin_absolu, protocole 
FROM site_configuration 
WHERE id = 1;
