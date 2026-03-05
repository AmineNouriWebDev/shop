<?php
// Simulate a DataTables request to the refactored arrays.php
$_POST['draw'] = 1;
$_POST['start'] = 0;
$_POST['length'] = 5;
$_POST['order'][0]['column'] = 1;
$_POST['order'][0]['dir'] = 'desc';
$_POST['searchByTitle'] = '';
$_POST['searchByCateg'] = '';
$_POST['searchByMarque'] = '';

ob_start();
include('c:/projects/htdocs/shop/_admin_site/arrays.php');
$output = ob_get_clean();

$data = json_decode($output, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "ERROR: Invalid JSON response\n";
    echo "RAW OUTPUT:\n" . substr($output, 0, 1000) . "...\n";
    exit(1);
}

echo "SUCCESS: Valid JSON response received\n";
echo "Draw: " . $data['draw'] . "\n";
echo "Total Records: " . $data['iTotalRecords'] . "\n";
echo "Filtered Records: " . $data['iTotalDisplayRecords'] . "\n";
echo "Data Count: " . count($data['data']) . "\n";

if (count($data['data']) > 0) {
    echo "First Row Sample:\n";
    print_r($data['data'][0]);
}
?>
