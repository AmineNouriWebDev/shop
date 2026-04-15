<?php
/**
 * fction_codes_promo.php
 * Fonctions pour la gestion des codes promo
 */

// ─── Récupération ─────────────────────────────────────────────

function getCodePromo($code) {
    global $connexion;
    $code = mysqli_real_escape_string($connexion, strtoupper(trim($code)));
    $res  = @mysqli_query($connexion, "SELECT * FROM `codes_promo` WHERE `code` = '$code' LIMIT 1");
    return ($res && $res instanceof mysqli_result) ? mysqli_fetch_assoc($res) : null;
}

function getCodePromoById($id) {
    global $connexion;
    $id  = (int)$id;
    $res = @mysqli_query($connexion, "SELECT * FROM `codes_promo` WHERE `id` = $id LIMIT 1");
    return ($res && $res instanceof mysqli_result) ? mysqli_fetch_assoc($res) : null;
}

function verifierTableCodesPromo() {
    global $connexion;
    $check = @mysqli_query($connexion, "SHOW TABLES LIKE 'codes_promo'");
    if ($check && mysqli_num_rows($check) == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS `codes_promo` (
            `id`              INT(11)        NOT NULL AUTO_INCREMENT,
            `code`            VARCHAR(50)    NOT NULL UNIQUE,
            `libelle`         VARCHAR(255)   DEFAULT '',
            `type`            ENUM('percent','fixed') NOT NULL DEFAULT 'percent',
            `valeur`          DECIMAL(10,3)  NOT NULL DEFAULT '0.000',
            `max_utilisations` INT(11)       DEFAULT NULL,
            `utilisations`    INT(11)        NOT NULL DEFAULT 0,
            `date_expiration` DATE           DEFAULT NULL,
            `montant_min`     DECIMAL(10,3)  NOT NULL DEFAULT '0.000',
            `etat`            TINYINT(1)     NOT NULL DEFAULT 1,
            `created_at`      TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_code` (`code`),
            KEY `idx_etat` (`etat`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        mysqli_query($connexion, $sql);
        
        // Ajouter aussi les colonnes dans commandes au cas où
        @mysqli_query($connexion, "ALTER TABLE `commandes` ADD COLUMN `code_promo` VARCHAR(50) DEFAULT NULL AFTER `remise` ");
        @mysqli_query($connexion, "ALTER TABLE `commandes` ADD COLUMN `remise_promo` DECIMAL(10,3) DEFAULT 0.000 AFTER `code_promo` ");
    }

    // Ajout de la colonne montant_min_type si absente
    $res = @mysqli_query($connexion, "SHOW COLUMNS FROM `codes_promo` LIKE 'montant_min_type'");
    if ($res && mysqli_num_rows($res) == 0) {
        @mysqli_query($connexion, "ALTER TABLE `codes_promo` ADD COLUMN `montant_min_type` ENUM('total','eligible') NOT NULL DEFAULT 'total' AFTER `montant_min` ");
    }

    // Création de la table de liaison catégories
    @mysqli_query($connexion, "CREATE TABLE IF NOT EXISTS `codes_promo_categories` (
        `id_code_promo` INT(11) NOT NULL,
        `id_categorie`  INT(11) NOT NULL,
        PRIMARY KEY (`id_code_promo`, `id_categorie`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}

function getPromoCategories($promo_id) {
    global $connexion;
    $promo_id = (int)$promo_id;
    $res = @mysqli_query($connexion, "SELECT id_categorie FROM `codes_promo_categories` WHERE id_code_promo = $promo_id");
    $ids = [];
    if($res && $res instanceof mysqli_result) {
        while($row = mysqli_fetch_assoc($res)) { $ids[] = $row['id_categorie']; }
    }
    return $ids;
}

function getRecursiveSubcategories($parent_id, &$visited = []) {
    global $connexion;
    
    // Garde-fou contre les boucles infinies (catégories parentes croisées)
    if (in_array((int)$parent_id, $visited)) {
        return [];
    }
    $visited[] = (int)$parent_id;

    $ids = [(int)$parent_id];
    $res = mysqli_query($connexion, "SELECT id FROM categories_blog WHERE idparent = " . (int)$parent_id);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $ids = array_merge($ids, getRecursiveSubcategories($row['id'], $visited));
        }
    }
    return $ids;
}

function listCodesPromo() {
    global $connexion;
    verifierTableCodesPromo();
    // Sécurité : Vérifier si la table existe avant de requêter pour éviter un crash PHP 8
    $res = @mysqli_query($connexion, "SELECT * FROM `codes_promo` ORDER BY `id` DESC");
    $list = [];
    if ($res && $res instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($res)) { $list[] = $row; }
    }
    return $list;
}

// ─── Validation ───────────────────────────────────────────────

/**
 * Valide un code promo et retourne les infos ou une erreur.
 * @param string $code         Le code saisi par le client
 * @param float  $panier_total Le montant du panier (sous-total)
 * @return array [ 'valid' => bool, 'message' => string, 'promo' => array|null, 'reduction' => float ]
 */
function validerCodePromo($code, $panier_total) {
    global $connexion;
    $code = strtoupper(trim($code));

    if (empty($code)) {
        return ['valid' => false, 'message' => 'Veuillez saisir un code promo.', 'promo' => null, 'reduction' => 0];
    }

    $promo = getCodePromo($code);

    if (!$promo) {
        return ['valid' => false, 'message' => 'Code promo invalide.', 'promo' => null, 'reduction' => 0];
    }

    if ($promo['etat'] != 1) {
        return ['valid' => false, 'message' => 'Ce code promo est désactivé.', 'promo' => null, 'reduction' => 0];
    }

    // Vérification date d'expiration
    if (!empty($promo['date_expiration'])) {
        $today   = new DateTime();
        $expDate = new DateTime($promo['date_expiration']);
        $expDate->setTime(23, 59, 59);
        if ($today > $expDate) {
            return ['valid' => false, 'message' => 'Ce code promo a expiré.', 'promo' => null, 'reduction' => 0];
        }
    }

    // Vérification nombre d'utilisations
    if (!is_null($promo['max_utilisations']) && $promo['max_utilisations'] > 0) {
        if ($promo['utilisations'] >= $promo['max_utilisations']) {
            return ['valid' => false, 'message' => 'Ce code promo a atteint sa limite d\'utilisation.', 'promo' => null, 'reduction' => 0];
        }
    }

    // Vérification des restrictions de catégories
    $allowed_cat_ids = getPromoCategories($promo['id']);
    $is_restricted   = !empty($allowed_cat_ids);
    $eligible_total  = $panier_total; // Par défaut tout est éligible

    if ($is_restricted) {
        // Étendre la liste aux sous-catégories
        $all_allowed_ids = [];
        foreach($allowed_cat_ids as $cid) {
            $all_allowed_ids = array_merge($all_allowed_ids, getRecursiveSubcategories($cid));
        }
        $all_allowed_ids = array_unique($all_allowed_ids);

        // Calculer le total éligible basé sur le panier en session
        $eligible_total = 0;
        if (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart'])) {
            foreach ($_SESSION['panier']['idcart'] as $i => $pid) {
                // Récupérer la catégorie du produit
                $q_prod = mysqli_query($connexion, "SELECT categorie FROM produits WHERE id = " . (int)$pid);
                if ($r_prod = mysqli_fetch_assoc($q_prod)) {
                    if (in_array($r_prod['categorie'], $all_allowed_ids)) {
                        $ligne_total = isset($_SESSION['panier']['total'][$i]) ? (float)$_SESSION['panier']['total'][$i] : 0;
                        if ($ligne_total <= 0 && isset($_SESSION['panier']['price'][$i]) && isset($_SESSION['panier']['qte_prd'][$i])) {
                            $ligne_total = (float)$_SESSION['panier']['price'][$i] * (int)$_SESSION['panier']['qte_prd'][$i];
                        }
                        $eligible_total += $ligne_total;
                    }
                }
            }
        }

        if ($eligible_total <= 0) {
            return ['valid' => false, 'message' => 'Ce code ne s\'applique pas aux articles de votre panier.', 'promo' => null, 'reduction' => 0];
        }
    }

    // Vérification montant minimum du panier
    $montant_a_verifier = ($promo['montant_min_type'] === 'eligible') ? $eligible_total : $panier_total;
    if ($promo['montant_min'] > 0 && $montant_a_verifier < $promo['montant_min']) {
        $msg = 'Ce code nécessite un minimum d\'achat de ' . number_format($promo['montant_min'], 3, '.', ' ') . ' DT';
        if ($promo['montant_min_type'] === 'eligible') $msg .= ' sur les articles sélectionnés';
        return [
            'valid'     => false,
            'message'   => $msg . '.',
            'promo'     => null,
            'reduction' => 0
        ];
    }

    // Calcul de la réduction basée sur le total éligible
    $reduction = 0;
    if ($promo['type'] === 'percent') {
        $reduction = round($eligible_total * $promo['valeur'] / 100, 3);
    } else {
        $reduction = min((float)$promo['valeur'], $eligible_total);
    }

    return [
        'valid'     => true,
        'message'   => 'Code promo appliqué avec succès !',
        'promo'     => $promo,
        'reduction' => $reduction
    ];
}

/**
 * Vérifie si un produit spécifique est éligible à un code promo
 */
function isProductEligibleForPromo($product_id, $promo_code) {
    global $connexion;
    $promo = getCodePromo($promo_code);
    if (!$promo) return false;
    
    $allowed_cat_ids = getPromoCategories($promo['id']);
    if (empty($allowed_cat_ids)) return true; // Pas de restriction = éligible
    
    // Étendre la liste aux sous-catégories
    $all_allowed_ids = [];
    foreach($allowed_cat_ids as $cid) {
        $all_allowed_ids = array_merge($all_allowed_ids, getRecursiveSubcategories($cid));
    }
    $all_allowed_ids = array_unique($all_allowed_ids);
    
    $q_prod = mysqli_query($connexion, "SELECT categorie FROM produits WHERE id = " . (int)$product_id);
    if ($r_prod = mysqli_fetch_assoc($q_prod)) {
        return in_array($r_prod['categorie'], $all_allowed_ids);
    }
    return false;
}

// ─── Incrémenter l'utilisation ────────────────────────────────

function incrementerUtilisationCodePromo($code) {
    global $connexion;
    $code = mysqli_real_escape_string($connexion, strtoupper(trim($code)));
    mysqli_query($connexion, "UPDATE `codes_promo` SET `utilisations` = `utilisations` + 1 WHERE `code` = '$code'");
}

// ─── CRUD ─────────────────────────────────────────────────────

function creerCodePromo($data) {
    global $connexion;
    $code           = mysqli_real_escape_string($connexion, strtoupper(trim($data['code'])));
    $libelle        = mysqli_real_escape_string($connexion, trim($data['libelle'] ?? ''));
    $type           = in_array($data['type'] ?? '', ['percent', 'fixed']) ? $data['type'] : 'percent';
    $valeur         = (float)($data['valeur'] ?? 0);
    $max_util       = isset($data['max_utilisations']) && $data['max_utilisations'] !== '' ? (int)$data['max_utilisations'] : 'NULL';
    $date_exp       = !empty($data['date_expiration']) ? "'" . mysqli_real_escape_string($connexion, $data['date_expiration']) . "'" : 'NULL';
    $montant_min    = (float)($data['montant_min'] ?? 0);
    $min_type       = in_array($data['montant_min_type'] ?? '', ['total','eligible']) ? $data['montant_min_type'] : 'total';
    $etat           = isset($data['etat']) ? (int)$data['etat'] : 1;

    $sql = "INSERT INTO `codes_promo` 
            (`code`, `libelle`, `type`, `valeur`, `max_utilisations`, `date_expiration`, `montant_min`, `montant_min_type`, `etat`)
            VALUES 
            ('$code', '$libelle', '$type', $valeur, $max_util, $date_exp, $montant_min, '$min_type', $etat)";

    if (mysqli_query($connexion, $sql)) {
        $promo_id = mysqli_insert_id($connexion);
        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cid) {
                mysqli_query($connexion, "INSERT INTO `codes_promo_categories` (id_code_promo, id_categorie) VALUES ($promo_id, " . (int)$cid . ")");
            }
        }
        return true;
    }
    return false;
}

function modifierCodePromo($id, $data) {
    global $connexion;
    $id             = (int)$id;
    $code           = mysqli_real_escape_string($connexion, strtoupper(trim($data['code'])));
    $libelle        = mysqli_real_escape_string($connexion, trim($data['libelle'] ?? ''));
    $type           = in_array($data['type'] ?? '', ['percent', 'fixed']) ? $data['type'] : 'percent';
    $valeur         = (float)($data['valeur'] ?? 0);
    $max_util       = isset($data['max_utilisations']) && $data['max_utilisations'] !== '' ? (int)$data['max_utilisations'] : 'NULL';
    $date_exp       = !empty($data['date_expiration']) ? "'" . mysqli_real_escape_string($connexion, $data['date_expiration']) . "'" : 'NULL';
    $montant_min    = (float)($data['montant_min'] ?? 0);
    $min_type       = in_array($data['montant_min_type'] ?? '', ['total','eligible']) ? $data['montant_min_type'] : 'total';
    $etat           = isset($data['etat']) ? (int)$data['etat'] : 1;

    $sql = "UPDATE `codes_promo` SET
            `code`           = '$code',
            `libelle`        = '$libelle',
            `type`           = '$type',
            `valeur`         = $valeur,
            `max_utilisations` = $max_util,
            `date_expiration` = $date_exp,
            `montant_min`    = $montant_min,
            `montant_min_type` = '$min_type',
            `etat`           = $etat
            WHERE `id` = $id";

    if (mysqli_query($connexion, $sql)) {
        mysqli_query($connexion, "DELETE FROM `codes_promo_categories` WHERE id_code_promo = $id");
        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cid) {
                mysqli_query($connexion, "INSERT INTO `codes_promo_categories` (id_code_promo, id_categorie) VALUES ($id, " . (int)$cid . ")");
            }
        }
        return true;
    }
    return false;
}

function supprimerCodePromo($id) {
    global $connexion;
    $id = (int)$id;
    return mysqli_query($connexion, "DELETE FROM `codes_promo` WHERE `id` = $id");
}

function toggleEtatCodePromo($id) {
    global $connexion;
    $id = (int)$id;
    return mysqli_query($connexion, "UPDATE `codes_promo` SET `etat` = IF(`etat`=1, 0, 1) WHERE `id` = $id");
}

// ─── Générateur de code lisible ───────────────────────────────

function genererCodePromo($prefix = '') {
    // Format : PROMO-XXXX-XXXX (facile à copier, pas de 0/O, 1/I)
    $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
    $part1 = '';
    $part2 = '';
    for ($i = 0; $i < 4; $i++) { 
        $idx = function_exists('random_int') ? random_int(0, strlen($chars)-1) : mt_rand(0, strlen($chars)-1);
        $part1 .= $chars[$idx]; 
    }
    for ($i = 0; $i < 4; $i++) { 
        $idx = function_exists('random_int') ? random_int(0, strlen($chars)-1) : mt_rand(0, strlen($chars)-1);
        $part2 .= $chars[$idx]; 
    }
    $prefix = $prefix ? strtoupper($prefix) . '-' : '';
    return $prefix . $part1 . '-' . $part2;
}

// ─── Helpers d'affichage ──────────────────────────────────────

function statutCodePromo($promo) {
    $now = time();

    // Inactif manuellement
    if ($promo['etat'] == 0) {
        return '<span style="background:#fef2f2;color:#dc2626;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">Désactivé</span>';
    }

    // Date expirée
    if (!empty($promo['date_expiration']) && strtotime($promo['date_expiration'] . ' 23:59:59') < $now) {
        return '<span style="background:#fef3c7;color:#d97706;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">Expiré</span>';
    }

    // Limite d'utilisations atteinte
    if (!is_null($promo['max_utilisations']) && $promo['max_utilisations'] > 0 && $promo['utilisations'] >= $promo['max_utilisations']) {
        return '<span style="background:#fef3c7;color:#d97706;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">Épuisé</span>';
    }

    return '<span style="background:#f0fdf4;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;">Actif</span>';
}

function joursRestantsCodePromo($date_exp) {
    if (empty($date_exp)) return '∞';
    $diff = (strtotime($date_exp . ' 23:59:59') - time());
    if ($diff < 0) return '<span style="color:#dc2626;">Expiré</span>';
    $jours = ceil($diff / 86400);
    if ($jours <= 7) return '<span style="color:#d97706;">' . $jours . 'j</span>';
    return '<span style="color:#16a34a;">' . $jours . 'j</span>';
}

function afficherValeurCodePromo($promo) {
    if ($promo['type'] === 'percent') {
        return '<strong>' . number_format($promo['valeur'], 0) . ' %</strong>';
    }
    return '<strong>' . number_format($promo['valeur'], 3, '.', ' ') . ' DT</strong>';
}

function utilisationsCodePromo($promo) {
    $util = (int)$promo['utilisations'];
    $max  = $promo['max_utilisations'];
    if (is_null($max) || $max == 0) {
        return $util . ' / <span style="color:#a0aec0;">∞</span>';
    }
    $ratio = $util / $max;
    $color = $ratio >= 1 ? '#dc2626' : ($ratio >= 0.8 ? '#d97706' : '#16a34a');
    return '<span style="color:' . $color . ';">' . $util . ' / ' . $max . '</span>';
}
