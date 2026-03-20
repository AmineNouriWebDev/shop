-- Remplacer 'sambox-box-android-km35-pro-2-16go-uhd-4k' par le link du produit testé si besoin
SET @link = 'sambox-box-android-km35-pro-2-16go-uhd-4k';

SELECT 
    id, 
    titre, 
    court_contenu as 'Actuel (court_contenu)',
    CONVERT(CAST(CONVERT(court_contenu USING latin1) AS BINARY) USING utf8mb4) as 'Corrigé (court_contenu)',
    caracteristique as 'Actuel (caracteristique)',
    CONVERT(CAST(CONVERT(caracteristique USING latin1) AS BINARY) USING utf8mb4) as 'Corrigé (caracteristique)'
FROM produits 
WHERE link = @link;

-- Test sur un autre champ potentiellement touché
SELECT 
    id, 
    CONVERT(CAST(CONVERT(titre USING latin1) AS BINARY) USING utf8mb4) as 'Titre Corrigé'
FROM produits 
LIMIT 5;
