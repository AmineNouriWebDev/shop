<?php
$postdata = http_build_query(['code' => 'TVLED10']);
$opts = ['http' => [
    'method'  => 'POST',
    'header'  => 'Content-Type: application/x-www-form-urlencoded',
    'content' => $postdata
]];
$context  = stream_context_create($opts);
$result = file_get_contents('http://localhost/shop/ajax/ajax_validate_promo.php', false, $context);
echo "Response:\n";
var_dump($result);
