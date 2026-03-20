-- CORRECTION SÉCURISÉE AVEC RECHERCHE BINAIRE
-- Utilise BINARY pour ne pas confondre 'Ã' avec 'a' ou 'A'
-- Cela cible uniquement les vrais caractères corrompus.

-- 1. Table PRODUITS
UPDATE produits SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE produits SET court_contenu = CONVERT(CAST(CONVERT(court_contenu USING latin1) AS BINARY) USING utf8mb4) 
WHERE court_contenu LIKE BINARY '%Ã%';

UPDATE produits SET description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4) 
WHERE description LIKE BINARY '%Ã%';

UPDATE produits SET caracteristique = CONVERT(CAST(CONVERT(caracteristique USING latin1) AS BINARY) USING utf8mb4) 
WHERE caracteristique LIKE BINARY '%Ã%';

UPDATE produits SET remarque = CONVERT(CAST(CONVERT(remarque USING latin1) AS BINARY) USING utf8mb4) 
WHERE remarque LIKE BINARY '%Ã%';

UPDATE produits SET titre_page = CONVERT(CAST(CONVERT(titre_page USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre_page LIKE BINARY '%Ã%';

UPDATE produits SET keywords = CONVERT(CAST(CONVERT(keywords USING latin1) AS BINARY) USING utf8mb4) 
WHERE keywords LIKE BINARY '%Ã%';

-- 2. Table CATEGORIES_BLOG
UPDATE categories_blog SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE categories_blog SET description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4) 
WHERE description LIKE BINARY '%Ã%';

-- 3. Table SERVICES
UPDATE services SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE services SET contenu = CONVERT(CAST(CONVERT(contenu USING latin1) AS BINARY) USING utf8mb4) 
WHERE contenu LIKE BINARY '%Ã%';

-- 4. Table SITE_CONFIGURATION
UPDATE site_configuration SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE site_configuration SET adresse = CONVERT(CAST(CONVERT(adresse USING latin1) AS BINARY) USING utf8mb4) 
WHERE adresse LIKE BINARY '%Ã%';

UPDATE site_configuration SET description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4) 
WHERE description LIKE BINARY '%Ã%';

UPDATE site_configuration SET copyright = CONVERT(CAST(CONVERT(copyright USING latin1) AS BINARY) USING utf8mb4) 
WHERE copyright LIKE BINARY '%Ã%';

-- 5. Table SLIDERS
UPDATE sliders SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE sliders SET sous_titre = CONVERT(CAST(CONVERT(sous_titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE sous_titre LIKE BINARY '%Ã%';

-- 6. Table BLOC_ACCUEIL
UPDATE bloc_accueil SET titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE titre LIKE BINARY '%Ã%';

UPDATE bloc_accueil SET sous_titre = CONVERT(CAST(CONVERT(sous_titre USING latin1) AS BINARY) USING utf8mb4) 
WHERE sous_titre LIKE BINARY '%Ã%';
