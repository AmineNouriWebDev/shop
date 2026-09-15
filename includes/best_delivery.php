<?php
/**
 * Best Delivery SOAP API - Utilitaire PHP
 * Documentation : https://doc.best-delivery.net/
 * WSDL Production : https://api.best-delivery.net/serviceShipments.php?wsdl
 * WSDL Staging    : https://api.best-delivery-staging.com/serviceShipments.php?wsdl
 */

// ─── Identifiants (à déplacer dans la config admin plus tard) ───────────────
define('BEST_DELIVERY_LOGIN', 'emnaemna@best.com');
define('BEST_DELIVERY_PWD',   'emnaemna');
define('BEST_DELIVERY_WSDL',  'https://api.best-delivery-staging.com/serviceShipments.php?wsdl');
// Pour basculer en production, remplacer par :
// define('BEST_DELIVERY_WSDL', 'https://api.best-delivery.net/serviceShipments.php?wsdl');
// ────────────────────────────────────────────────────────────────────────────

/**
 * Construit un client SOAP configuré pour Best Delivery
 */
function bestDelivery_client() {
    $options = [
        'trace'              => 1,
        'exceptions'         => true,
        'connection_timeout' => 10,
        'stream_context'     => stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
            ]
        ])
    ];
    return new SoapClient(BEST_DELIVERY_WSDL, $options);
}

/**
 * Log de debug dans un fichier
 */
function bestDelivery_log($method, $params, $response, $error = '') {
    $log = "=== " . date('Y-m-d H:i:s') . " === Méthode: $method\n";
    $log .= "Params: " . json_encode($params, JSON_UNESCAPED_UNICODE) . "\n";
    if ($error) {
        $log .= "Erreur: $error\n";
    } else {
        $log .= "Réponse: " . json_encode($response, JSON_UNESCAPED_UNICODE) . "\n";
    }
    $log .= str_repeat('-', 60) . "\n";
    $logFile = __DIR__ . '/../debug_best_delivery.txt';
    file_put_contents($logFile, $log, FILE_APPEND);
}

/**
 * 1. CreatePickup — Créer un colis
 *
 * @param string $nom         Nom complet du client
 * @param string $gouvernerat Gouvernorat (ex: "Tunis", "Sfax", etc.)
 * @param string $ville       Ville / Délégation
 * @param string $adresse     Adresse complète
 * @param string $tel         Téléphone principal
 * @param float  $prix        Valeur totale du colis (montant à encaisser)
 * @param string $designation Description du colis / produits
 * @param string $msg         Commentaire optionnel
 * @param int    $echange     0 = livraison standard, 1 = échange
 * @param string $tel2        Téléphone secondaire (optionnel)
 *
 * @return array ['success' => bool, 'code_barre' => string|null, 'url' => string|null, 'error' => string|null]
 */
function bestDelivery_createPickup($nom, $gouvernerat, $ville, $adresse, $tel, $prix, $designation, $msg = '', $echange = 0, $tel2 = '') {
    $params = [
        'login'          => BEST_DELIVERY_LOGIN,
        'pwd'            => BEST_DELIVERY_PWD,
        'nom'            => $nom,
        'gouvernerat'    => $gouvernerat,
        'ville'          => $ville,
        'adresse'        => $adresse,
        'tel'            => $tel,
        'tel2'           => $tel2,
        'designation'    => substr($designation, 0, 200),
        'prix'           => (float) $prix,
        'msg'            => $msg,
        'echange'        => (int) $echange,
        // Champs auto gérés par l'API (valeurs 0)
        'tracking_number'=> 0,
        'agence'         => 0,
        'agence_dest'    => 0,
        'date_add'       => 0,
        'date_pick'      => 0,
        'date_stat'      => 0,
        'nb_article'     => 0,
        'unlink'         => 0,
        'modif'          => 0,
        'id_runsheet'    => 0,
        'recu'           => 0,
        'id_recette'     => 0,
        'transmit'       => 0,
        'etat'           => 0,
        'id_frs'         => 0,
        'frs'            => 0,
        'paye'           => 0,
        'code_barre'     => 0,
    ];

    try {
        $client = bestDelivery_client();
        $response = $client->CreatePickup($params);
        $result = is_object($response) ? (array)$response : $response;

        bestDelivery_log('CreatePickup', $params, $result);

        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            return [
                'success'    => true,
                'code_barre' => isset($result['CodeBarre']) ? (string)$result['CodeBarre'] : null,
                'url'        => isset($result['Url']) ? $result['Url'] : null,
                'error'      => null,
            ];
        } else {
            $errTxt = isset($result['ErrorsTxt']) ? $result['ErrorsTxt'] : 'Erreur inconnue';
            bestDelivery_log('CreatePickup', $params, $result, $errTxt);
            return ['success' => false, 'code_barre' => null, 'url' => null, 'error' => $errTxt];
        }

    } catch (Exception $e) {
        bestDelivery_log('CreatePickup', $params, [], $e->getMessage());
        return ['success' => false, 'code_barre' => null, 'url' => null, 'error' => $e->getMessage()];
    }
}

/**
 * 2. TrackShipmentStatus — État actuel d'un colis
 *
 * @param string|int $tracking_number Code barre du colis
 *
 * @return array ['success' => bool, 'status' => int|null, 'message' => string|null, 'error' => string|null]
 */
function bestDelivery_trackStatus($tracking_number) {
    $params = [
        'login'           => BEST_DELIVERY_LOGIN,
        'pwd'             => BEST_DELIVERY_PWD,
        'tracking_number' => $tracking_number,
    ];

    try {
        $client = bestDelivery_client();
        $response = $client->TrackShipmentStatus($params);
        $result = is_object($response) ? (array)$response : $response;

        bestDelivery_log('TrackShipmentStatus', $params, $result);

        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            return [
                'success' => true,
                'status'  => isset($result['status']) ? (int)$result['status'] : null,
                'message' => isset($result['message']) ? $result['message'] : null,
                'error'   => null,
            ];
        } else {
            $errTxt = isset($result['ErrorsTxt']) ? $result['ErrorsTxt'] : 'Erreur inconnue';
            return ['success' => false, 'status' => null, 'message' => null, 'error' => $errTxt];
        }

    } catch (Exception $e) {
        bestDelivery_log('TrackShipmentStatus', $params, [], $e->getMessage());
        return ['success' => false, 'status' => null, 'message' => null, 'error' => $e->getMessage()];
    }
}

/**
 * 3. TrackShipment — Historique complet d'un colis
 *
 * @param string|int $tracking_number Code barre du colis
 *
 * @return array ['success' => bool, 'history' => array|null, 'error' => string|null]
 */
function bestDelivery_trackHistory($tracking_number) {
    $params = [
        'login'           => BEST_DELIVERY_LOGIN,
        'pwd'             => BEST_DELIVERY_PWD,
        'tracking_number' => $tracking_number,
    ];

    try {
        $client = bestDelivery_client();
        $response = $client->TrackShipment($params);
        $result = is_object($response) ? (array)$response : $response;

        bestDelivery_log('TrackShipment', $params, $result);

        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            return [
                'success' => true,
                'history' => isset($result['status']) ? (array)$result['status'] : [],
                'error'   => null,
            ];
        } else {
            $errTxt = isset($result['ErrorsTxt']) ? $result['ErrorsTxt'] : 'Erreur inconnue';
            return ['success' => false, 'history' => null, 'error' => $errTxt];
        }

    } catch (Exception $e) {
        bestDelivery_log('TrackShipment', $params, [], $e->getMessage());
        return ['success' => false, 'history' => null, 'error' => $e->getMessage()];
    }
}

/**
 * 4. GetOrder — Liste paginée des colis
 *
 * @param int $page  Page courante (défaut 1)
 * @param int $ofset Nombre d'éléments par page (défaut 10)
 *
 * @return array ['success' => bool, 'orders' => array, 'total_pages' => int, 'current_page' => int, 'error' => string|null]
 */
function bestDelivery_getOrders($page = 1, $ofset = 10) {
    $params = [
        'login' => BEST_DELIVERY_LOGIN,
        'pwd'   => BEST_DELIVERY_PWD,
        'page'  => (int) $page,
        'ofset' => (int) $ofset,
    ];

    try {
        $client = bestDelivery_client();
        $response = $client->GetOrder($params);
        $result = is_object($response) ? (array)$response : $response;

        bestDelivery_log('GetOrder', $params, $result);

        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            return [
                'success'      => true,
                'orders'       => isset($result['message']) ? (array)$result['message'] : [],
                'total_pages'  => isset($result['total_pages']) ? (int)$result['total_pages'] : 1,
                'current_page' => isset($result['current_page']) ? (int)$result['current_page'] : 1,
                'error'        => null,
            ];
        } else {
            $errTxt = isset($result['ErrorsTxt']) ? $result['ErrorsTxt'] : 'Erreur inconnue';
            return ['success' => false, 'orders' => [], 'total_pages' => 0, 'current_page' => 0, 'error' => $errTxt];
        }

    } catch (Exception $e) {
        bestDelivery_log('GetOrder', $params, [], $e->getMessage());
        return ['success' => false, 'orders' => [], 'total_pages' => 0, 'current_page' => 0, 'error' => $e->getMessage()];
    }
}

/**
 * 5. GetRecette — Liste paginée des recettes (encaissements)
 *
 * @param int $page  Page courante (défaut 1)
 * @param int $ofset Nombre d'éléments par page (défaut 10)
 *
 * @return array ['success' => bool, 'recettes' => array, 'total_pages' => int, 'current_page' => int, 'error' => string|null]
 */
function bestDelivery_getRecettes($page = 1, $ofset = 10) {
    $params = [
        'login' => BEST_DELIVERY_LOGIN,
        'pwd'   => BEST_DELIVERY_PWD,
        'page'  => (int) $page,
        'ofset' => (int) $ofset,
    ];

    try {
        $client = bestDelivery_client();
        $response = $client->GetRecette($params);
        $result = is_object($response) ? (array)$response : $response;

        bestDelivery_log('GetRecette', $params, $result);

        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            return [
                'success'      => true,
                'recettes'     => isset($result['message']) ? (array)$result['message'] : [],
                'total_pages'  => isset($result['total_pages']) ? (int)$result['total_pages'] : 1,
                'current_page' => isset($result['current_page']) ? (int)$result['current_page'] : 1,
                'error'        => null,
            ];
        } else {
            $errTxt = isset($result['ErrorsTxt']) ? $result['ErrorsTxt'] : 'Erreur inconnue';
            return ['success' => false, 'recettes' => [], 'total_pages' => 0, 'current_page' => 0, 'error' => $errTxt];
        }

    } catch (Exception $e) {
        bestDelivery_log('GetRecette', $params, [], $e->getMessage());
        return ['success' => false, 'recettes' => [], 'total_pages' => 0, 'current_page' => 0, 'error' => $e->getMessage()];
    }
}

/**
 * Tableau de correspondance des codes d'état Best Delivery
 */
function bestDelivery_statusLabel($code) {
    $labels = [
        0  => 'En attente',
        1  => 'En cours',
        2  => 'Livrée',
        3  => 'Échange livré au client',
        4  => 'Échange',
        5  => 'Retour Expéditeur',
        6  => 'Supprimée',
        7  => 'Retour Client Agence',
        8  => 'Au dépôt',
        9  => 'Inter Dépôt',
        10 => 'Chez client finale',
        11 => 'Retour Dépôt',
        15 => 'Non reçu',
        20 => 'Retour Exp sac',
        30 => 'Retour reçu',
        31 => 'Retour définitif',
        32 => 'Reçu payé',
        40 => 'Delete Depot',
        41 => 'Delete En cours',
        45 => 'Retour Échange livré au client',
        46 => 'Retour Échange Refusée par client',
    ];
    return isset($labels[$code]) ? $labels[$code] : 'État inconnu (' . $code . ')';
}
