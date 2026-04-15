<?php
session_start();
$_SESSION['panier'] = [
    'idcart' => [30], // assuming 30 is some product ID
    'total' => [500],
    'price' => [500],
    'qte_prd' => [1]
];

$postdata = http_build_query(['code' => 'TVLED10']);
$opts = ['http' => [
    'method'  => 'POST',
    'header'  => "Content-Type: application/x-www-form-urlencoded\r\nCookie: PHPSESSID=" . session_id() . "\r\n",
    'content' => $postdata
]];
$context  = stream_context_create($opts);
$result = file_get_contents('http://localhost/shop/ajax/ajax_validate_promo.php', false, $context);
echo "Result:\n$result\n";
