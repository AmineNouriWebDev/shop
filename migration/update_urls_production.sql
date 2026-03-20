-- ============================================
-- Script SQL de mise à jour pour production
-- À exécuter dans phpMyAdmin après import de la BDD
-- ============================================

-- 1. Mettre à jour le chemin absolu dans la configuration du site
UPDATE site_configuration 
SET chemin_absolu = 'https://technoplus.io/', 
    protocole = '2'  -- 2 = HTTPS, 1 = HTTP
WHERE id = 1;

-- 2. Vérifier qu'il n'y a pas d'autres URLs localhost dans les tables
-- (Cette requête est juste pour AUDIT, elle n'effectue aucune modification)

SELECT 'site_menu' AS table_name, id, titre, link_externe AS url 
FROM site_menu 
WHERE link_externe LIKE '%localhost%'
UNION ALL
SELECT 'site_configuration' AS table_name, id, nom_site, chemin_absolu AS url  
FROM site_configuration 
WHERE chemin_absolu LIKE '%localhost%';

-- Si la requête ci-dessus retourne des résultats (autres que site_configuration),
-- ajoutez manuellement les UPDATE nécessaires ici.

-- Exemple de UPDATE si vous trouvez d'autres URLs :
-- UPDATE site_menu SET link_externe = REPLACE(link_externe, 'http://localhost/technoplus/', 'https://technoplus.io/') WHERE link_externe LIKE '%localhost%';

-- 3. Vérifier la configuration finale
SELECT id, nom_site, chemin_absolu, protocole, email_contact 
FROM site_configuration 
WHERE id = 1;
