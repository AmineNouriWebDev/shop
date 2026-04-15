<?php
session_start();
// simulate cart with TV LED (category 2) and another product
$_SESSION['panier'] = [
    'idcart' => [3253], // TV Vega 32'' LED HD
    'total' => [500.000],
    'price' => [500.000],
    'qte_prd' => [1]
];
$session_id = session_id();
session_write_close();

$postdata = http_build_query(['code' => 'TVLED10']);
$opts = ['http' => [
    'method'  => 'POST',
    'header'  => "Content-Type: application/x-www-form-urlencoded\r\nCookie: PHPSESSID=" . $session_id . "\r\n",
    'content' => $postdata
]];
$context  = stream_context_create($opts);

$result = file_get_contents('http://localhost/shop/ajax/ajax_validate_promo.php', false, $context);
echo "Result:\n$result\n";
