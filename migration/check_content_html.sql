-- Vérifier s'il y a des images ou liens localhost dans les descriptions HTML des produits
SELECT id, titre FROM produits WHERE contenu LIKE '%localhost%';

-- Vérifier dans les articles de blog
SELECT id, titre FROM articles WHERE contenu LIKE '%localhost%';

-- Vérifier dans les services
SELECT id FROM services WHERE contenu LIKE '%localhost%';
