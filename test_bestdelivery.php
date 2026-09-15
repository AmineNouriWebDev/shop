<?php
// Script de diagnostic Best Delivery - À SUPPRIMER après test
// Accès : https://offipro.net/test_bestdelivery.php

echo "<pre style='font-family:monospace; background:#111; color:#0f0; padding:20px;'>";
echo "=== DIAGNOSTIC BEST DELIVERY ===\n\n";

// 1. Extension SOAP
echo "1. Extension PHP SOAP : ";
if (class_exists('SoapClient')) {
    echo "✅ INSTALLÉE\n";
} else {
    echo "❌ NON INSTALLÉE — C'est le problème ! Installez : apt install php8.1-soap\n";
}

// 2. Connexion au WSDL staging
echo "\n2. Connexion au WSDL staging :\n";
$wsdl = 'https://api.best-delivery-staging.com/serviceShipments.php?wsdl';
$ch = curl_init($wsdl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err  = curl_error($ch);
curl_close($ch);
if ($code == 200) {
    echo "   ✅ WSDL accessible (HTTP $code)\n";
} else {
    echo "   ❌ WSDL inaccessible (HTTP $code) — Erreur : $err\n";
}

// 3. Test CreatePickup réel
if (class_exists('SoapClient') && $code == 200) {
    echo "\n3. Test CreatePickup (colis fictif) :\n";
    try {
        $options = [
            'trace'              => 1,
            'exceptions'         => true,
            'connection_timeout' => 10,
            'stream_context'     => stream_context_create([
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
            ])
        ];
        $client = new SoapClient($wsdl, $options);
        $params = [
            'login'          => 'emnaemna@best.com',
            'pwd'            => 'emnaemna',
            'nom'            => 'Client Test',
            'gouvernerat'    => 'Tunis',
            'ville'          => 'Tunis',
            'adresse'        => '10 Rue de Test',
            'tel'            => '22000000',
            'tel2'           => '',
            'designation'    => 'Produit Test',
            'prix'           => 52.000,
            'msg'            => 'Test depuis offipro.net',
            'echange'        => 0,
            'tracking_number'=> 0,
            'agence'         => 0, 'agence_dest' => 0, 'date_add' => 0, 'date_pick' => 0,
            'date_stat'      => 0, 'nb_article' => 0, 'unlink' => 0, 'modif' => 0,
            'id_runsheet'    => 0, 'recu' => 0, 'id_recette' => 0, 'transmit' => 0,
            'etat'           => 0, 'id_frs' => 0, 'frs' => 0, 'paye' => 0, 'code_barre' => 0,
        ];
        $response = $client->CreatePickup($params);
        $result   = (array)$response;
        echo "   Réponse API : " . json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
        if (isset($result['HasErrors']) && (int)$result['HasErrors'] === 0) {
            echo "\n   ✅ SUCCÈS ! Code barre : " . $result['CodeBarre'] . "\n";
            echo "   🖨️  Bon de commande : " . $result['Url'] . "\n";
        } else {
            echo "\n   ❌ ERREUR API : " . ($result['ErrorsTxt'] ?? 'Inconnue') . "\n";
        }
    } catch (Exception $e) {
        echo "   ❌ EXCEPTION : " . $e->getMessage() . "\n";
    }
} else {
    echo "\n3. Test CreatePickup : ⏭️ IGNORÉ (prérequis non satisfaits)\n";
}

// 4. Contenu du log
echo "\n4. Dernier contenu du fichier debug_best_delivery.txt :\n";
$logFile = __DIR__ . '/debug_best_delivery.txt';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $last = array_slice($lines, -30);
    echo implode('', $last);
} else {
    echo "   (fichier absent — l'appel n'a jamais été tenté)\n";
}

echo "\n=== FIN DU DIAGNOSTIC ===";
echo "</pre>";
