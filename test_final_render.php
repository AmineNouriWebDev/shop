<?php
$c = mysqli_connect('localhost', 'root', '', 'technopl_db');
$q = mysqli_query($c, 'SELECT developer_comment FROM site_configuration');
$row = mysqli_fetch_assoc($q);
$dev_comment = $row['developer_comment'];

$html = file_get_contents('http://localhost/shop/');
if (strpos($html, $dev_comment) !== false) {
    echo "SUCCESS: Found developer_comment in the exact rendered homepage output via cURL.\n";
} else {
    echo "FAIL: developer_comment missing from rendered output.\n";
    file_put_contents('test_homepage_render.txt', $html);
}
?>
