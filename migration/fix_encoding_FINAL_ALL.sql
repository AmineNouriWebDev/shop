-- CORRECTION MASSIVE DE L'ENCODAGE (Double encodage UTF-8)
-- Ce script répare les caractères "mojibake" (ex: Ã© -> é) sur tout le site.

-- 1. Table PRODUITS
UPDATE produits SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    court_contenu = CONVERT(CAST(CONVERT(court_contenu USING latin1) AS BINARY) USING utf8mb4),
    description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4),
    caracteristique = CONVERT(CAST(CONVERT(caracteristique USING latin1) AS BINARY) USING utf8mb4),
    remarque = CONVERT(CAST(CONVERT(remarque USING latin1) AS BINARY) USING utf8mb4),
    titre_page = CONVERT(CAST(CONVERT(titre_page USING latin1) AS BINARY) USING utf8mb4),
    keywords = CONVERT(CAST(CONVERT(keywords USING latin1) AS BINARY) USING utf8mb4);

-- 2. Table CATEGORIES_BLOG (si applicable)
UPDATE categories_blog SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4);

-- 3. Table SERVICES
UPDATE services SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    contenu = CONVERT(CAST(CONVERT(contenu USING latin1) AS BINARY) USING utf8mb4);

-- 4. Table SITE_CONFIGURATION (Titres, adresses...)
UPDATE site_configuration SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    adresse = CONVERT(CAST(CONVERT(adresse USING latin1) AS BINARY) USING utf8mb4),
    description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4),
    copyright = CONVERT(CAST(CONVERT(copyright USING latin1) AS BINARY) USING utf8mb4);

-- 5. Table SLIDERS
UPDATE sliders SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    sous_titre = CONVERT(CAST(CONVERT(sous_titre USING latin1) AS BINARY) USING utf8mb4);

-- 6. Table BLOC_ACCUEIL
UPDATE bloc_accueil SET 
    titre = CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4),
    sous_titre = CONVERT(CAST(CONVERT(sous_titre USING latin1) AS BINARY) USING utf8mb4);

-- Note: Si vous avez des avis clients, des articles de blog, ou d'autres tables de texte, ajoutez-les ici.
