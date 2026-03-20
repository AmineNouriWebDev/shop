-- CORRECTION MANUELLE VIA REPLACE (POUR PRÉSERVER LES EMOJIS)
-- Cette méthode est plus sûre quand il y a des emojis car elle ne recode pas toute la chaîne.

SET SQL_SAFE_UPDATES = 0;

-- 1. Table PRODUITS
-- Titre
UPDATE produits SET titre = REPLACE(titre, 'Ã©', 'é') WHERE titre LIKE BINARY '%Ã©%';
UPDATE produits SET titre = REPLACE(titre, 'Ã¨', 'è') WHERE titre LIKE BINARY '%Ã¨%';
UPDATE produits SET titre = REPLACE(titre, 'Ãª', 'ê') WHERE titre LIKE BINARY '%Ãª%';
UPDATE produits SET titre = REPLACE(titre, 'Ã¢', 'â') WHERE titre LIKE BINARY '%Ã¢%';
UPDATE produits SET titre = REPLACE(titre, 'Ã ', 'à') WHERE titre LIKE BINARY '%Ã %';
UPDATE produits SET titre = REPLACE(titre, 'Ã®', 'î') WHERE titre LIKE BINARY '%Ã®%';
UPDATE produits SET titre = REPLACE(titre, 'Ã´', 'ô') WHERE titre LIKE BINARY '%Ã´%';
UPDATE produits SET titre = REPLACE(titre, 'Ã»', 'û') WHERE titre LIKE BINARY '%Ã»%';
UPDATE produits SET titre = REPLACE(titre, 'â€™', '’') WHERE titre LIKE BINARY '%â€™%';

-- Court Contenu
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã©', 'é') WHERE court_contenu LIKE BINARY '%Ã©%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã¨', 'è') WHERE court_contenu LIKE BINARY '%Ã¨%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ãª', 'ê') WHERE court_contenu LIKE BINARY '%Ãª%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã¢', 'â') WHERE court_contenu LIKE BINARY '%Ã¢%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã ', 'à') WHERE court_contenu LIKE BINARY '%Ã %';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã®', 'î') WHERE court_contenu LIKE BINARY '%Ã®%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã´', 'ô') WHERE court_contenu LIKE BINARY '%Ã´%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã»', 'û') WHERE court_contenu LIKE BINARY '%Ã»%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'â€™', '’') WHERE court_contenu LIKE BINARY '%â€™%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Â°', '°') WHERE court_contenu LIKE BINARY '%Â°%';
UPDATE produits SET court_contenu = REPLACE(court_contenu, 'Ã—', '×') WHERE court_contenu LIKE BINARY '%Ã—%';

-- Description
UPDATE produits SET description = REPLACE(description, 'Ã©', 'é') WHERE description LIKE BINARY '%Ã©%';
UPDATE produits SET description = REPLACE(description, 'Ã¨', 'è') WHERE description LIKE BINARY '%Ã¨%';
UPDATE produits SET description = REPLACE(description, 'Ãª', 'ê') WHERE description LIKE BINARY '%Ãª%';
UPDATE produits SET description = REPLACE(description, 'Ã¢', 'â') WHERE description LIKE BINARY '%Ã¢%';
UPDATE produits SET description = REPLACE(description, 'Ã ', 'à') WHERE description LIKE BINARY '%Ã %';
UPDATE produits SET description = REPLACE(description, 'â€™', '’') WHERE description LIKE BINARY '%â€™%';

-- Caracteristique
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'Ã©', 'é') WHERE caracteristique LIKE BINARY '%Ã©%';
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'Ã¨', 'è') WHERE caracteristique LIKE BINARY '%Ã¨%';
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'Ãª', 'ê') WHERE caracteristique LIKE BINARY '%Ãª%';
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'Ã¢', 'â') WHERE caracteristique LIKE BINARY '%Ã¢%';
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'Ã ', 'à') WHERE caracteristique LIKE BINARY '%Ã %';
UPDATE produits SET caracteristique = REPLACE(caracteristique, 'â€™', '’') WHERE caracteristique LIKE BINARY '%â€™%';


-- 2. Table SITE_CONFIGURATION
UPDATE site_configuration SET nom_site = REPLACE(nom_site, 'Ã©', 'é') WHERE nom_site LIKE BINARY '%Ã©%';
UPDATE site_configuration SET titre_page = REPLACE(titre_page, 'Ã©', 'é') WHERE titre_page LIKE BINARY '%Ã©%';
UPDATE site_configuration SET copyright = REPLACE(copyright, 'Ã©', 'é') WHERE copyright LIKE BINARY '%Ã©%';
UPDATE site_configuration SET copyright = REPLACE(copyright, 'Â©', '©') WHERE copyright LIKE BINARY '%Â©%';

-- 3. Table SERVICES
UPDATE services SET titre = REPLACE(titre, 'Ã©', 'é') WHERE titre LIKE BINARY '%Ã©%';
UPDATE services SET titre = REPLACE(titre, 'Ã¨', 'è') WHERE titre LIKE BINARY '%Ã¨%';
UPDATE services SET contenu = REPLACE(contenu, 'Ã©', 'é') WHERE contenu LIKE BINARY '%Ã©%';
UPDATE services SET contenu = REPLACE(contenu, 'Ã¨', 'è') WHERE contenu LIKE BINARY '%Ã¨%';

-- 4. Table CATEGORIES_BLOG
UPDATE categories_blog SET titre = REPLACE(titre, 'Ã©', 'é') WHERE titre LIKE BINARY '%Ã©%';
UPDATE categories_blog SET titre = REPLACE(titre, 'Ã¨', 'è') WHERE titre LIKE BINARY '%Ã¨%';
