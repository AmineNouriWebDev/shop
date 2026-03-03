-- Vérifier le contenu des champs tagmanager
SELECT tagmanager_head, tagmanager_body FROM site_configuration WHERE id = 1;

-- Si vous voyez des URLs localhost, exécutez ceci :
UPDATE site_configuration 
SET tagmanager_head = REPLACE(tagmanager_head, 'http://localhost/technoplus/', 'https://technoplus.io/'),
    tagmanager_body = REPLACE(tagmanager_body, 'http://localhost/technoplus/', 'https://technoplus.io/')
WHERE id = 1;

-- Ou pour les vider complètement (recommandé si vous n'êtes pas sûr des scripts) :
-- UPDATE site_configuration SET tagmanager_head = '', tagmanager_body = '' WHERE id = 1;
