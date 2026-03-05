<?php
$data = array(
    'draw' => 1,
    'start' => 0,
    'length' => 10,
    'order' => array(
        0 => array(
            'column' => 1,
            'dir' => 'desc'
        )
    ),
    'columns' => array(
        1 => array(
            'data' => 'produit'
        )
    ),
    'searchByTitle' => '',
    'searchByCateg' => '',
    'searchByMarque' => ''
);

$ch = curl_init('http://localhost/shop/_admin_site/arrays.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}
curl_close($ch);

echo "RESPONSE:\n";
echo $response;
