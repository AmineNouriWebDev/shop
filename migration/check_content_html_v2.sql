-- Vérifier s'il y a des images ou liens localhost dans les champs de contenu (HTML)

-- 1. Table PRODUITS (champs: court_contenu, caracteristique, remarque, video, description)
SELECT id, titre, 'court_contenu' as champ FROM produits WHERE court_contenu LIKE '%localhost%';
SELECT id, titre, 'caracteristique' as champ FROM produits WHERE caracteristique LIKE '%localhost%';
SELECT id, titre, 'remarque' as champ FROM produits WHERE remarque LIKE '%localhost%';
SELECT id, titre, 'video' as champ FROM produits WHERE video LIKE '%localhost%';
SELECT id, titre, 'description' as champ FROM produits WHERE description LIKE '%localhost%';

-- 2. Table SERVICES (champ: contenu)
SELECT id, titre FROM services WHERE contenu LIKE '%localhost%';

-- 3. Table BLOG/ARTICLES (champs à vérifier)
-- On vérifie d'abord la structure si "articles" est vide ou non, mais s'il y a une table categories_blog :
SELECT id, titre, link FROM categories_blog WHERE link LIKE '%localhost%';
