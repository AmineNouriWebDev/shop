-- Correction de l'encodage pour LE produit test uniquement
-- Produit: Sambox Box Android Km35 Pro
-- Link: sambox-box-android-km35-pro-2-16go-uhd-4k

UPDATE produits 
SET 
    court_contenu = CONVERT(CAST(CONVERT(court_contenu USING latin1) AS BINARY) USING utf8mb4),
    caracteristique = CONVERT(CAST(CONVERT(caracteristique USING latin1) AS BINARY) USING utf8mb4),
    description = CONVERT(CAST(CONVERT(description USING latin1) AS BINARY) USING utf8mb4),
    remarque = CONVERT(CAST(CONVERT(remarque USING latin1) AS BINARY) USING utf8mb4)
WHERE link = 'sambox-box-android-km35-pro-2-16go-uhd-4k';
