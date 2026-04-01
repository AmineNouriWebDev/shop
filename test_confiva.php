<?php
include("connec.php"); // Pour récupérer la clé API depuis site_configuration

echo "<h1>Test de l'API Confiva</h1>";

$confiva_key = !empty($confiva_api_key) ? $confiva_api_key : '';

if(empty($confiva_key)) {
    echo "<p style='color:red'>Erreur : Aucune clé API trouvée dans la base de données. L'avez-vous bien enregistrée dans l'admin ?</p>";
    exit;
} else {
    echo "<p>Clé API trouvée : " . substr($confiva_key, 0, 5) . "*********</p>";
}

// Données de test strictes selon la documentation
$confiva_data = [
    'nom_client' => 'Client Test Local',
    'adresse'    => '12 Rue de test',
    'gouvernorat'=> 'Tunis', // Exactement comme dans la liste
    'city'       => 'Tunis',
    'telephone'  => '22123456',
    'prix'       => 150.00,
    'contenu'    => 'Test API',
    'echange'    => "0",
    'autoriser_ouverture' => "0"
];

echo "<h3>Données envoyées :</h3>";
echo "<pre>" . print_r($confiva_data, true) . "</pre>";

$chConf = curl_init('https://expediteur.confiva-logistics.com/api/client/colis/create');
curl_setopt($chConf, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chConf, CURLOPT_POST, true);
curl_setopt($chConf, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'x-api-key: ' . $confiva_key
]);
curl_setopt($chConf, CURLOPT_POSTFIELDS, json_encode($confiva_data));

// TRÈS IMPORTANT EN LOCAL SOUS WINDOWS : Désactiver la vérification SSL
curl_setopt($chConf, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chConf, CURLOPT_SSL_VERIFYHOST, false);

$confiva_resp = curl_exec($chConf);
$confiva_code = curl_getinfo($chConf, CURLINFO_HTTP_CODE);
$curl_error   = curl_error($chConf);
curl_close($chConf);

echo "<h3>Réponse de l'API :</h3>";
echo "<p><b>Code HTTP :</b> " . $confiva_code . "</p>";

if($curl_error) {
    echo "<p style='color:red'><b>Erreur cURL (Bloqué par local/PC) :</b> " . $curl_error . "</p>";
} else {
    echo "<b>Réponse Brute :</b><br><pre>" . htmlspecialchars($confiva_resp) . "</pre>";
    $res = json_decode($confiva_resp, true);
    if(isset($res['code_barres'])) {
        echo "<p style='color:green; font-weight:bold;'>Succès ! Voici le code généré : " . $res['code_barres'] . "</p>";
    }
}
?>
