<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/shop/includes/fetch_data_test.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['action' => 'fetch_data', 'search' => 'iphone X']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP $httpcode\n";
echo "RESPONSE:\n$server_output";
?>
