<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

// Include site environment
$root = dirname(__DIR__) . '/';
require_once $root . 'include.php';

// Check client is logged in (session key used by this shop)
$client_id = 0;
if (!empty($_SESSION['id_client'])) {
    $client_id = intval($_SESSION['id_client']);
} elseif (!empty($_SESSION['client_id'])) {
    $client_id = intval($_SESSION['client_id']);
} elseif (!empty($_SESSION['id'])) {
    $client_id = intval($_SESSION['id']);
}

if (!$client_id) {
    echo json_encode(['error' => 'non_connecte', 'message' => 'Vous devez être connecté pour noter ce produit.']);
    exit;
}

$id_produit = intval($_POST['id_produit'] ?? 0);
$note       = intval($_POST['note'] ?? 0);

if ($id_produit <= 0 || $note < 1 || $note > 5) {
    echo json_encode(['error' => 'invalid', 'message' => 'Note invalide.']);
    exit;
}

$cnx = ouvrirCnx();

// Vérifier que le produit existe
$rp = mysqli_query($cnx, "SELECT id FROM produits WHERE id='$id_produit' AND etat='1' LIMIT 1");
if (!$rp || mysqli_num_rows($rp) === 0) {
    echo json_encode(['error' => 'produit_introuvable']);
    exit;
}

// Define variables for queries
$note_esc   = intval($note);
$client_esc = intval($client_id);
$prod_esc   = intval($id_produit);

// 1. Check if this specific user already has a vote for this product
$r_check = mysqli_query($cnx, "SELECT note FROM avis_produits WHERE id_produit='$prod_esc' AND id_client='$client_esc' LIMIT 1");
$user_prev_note = null;
if ($r_check && mysqli_num_rows($r_check) > 0) {
    $d_check = mysqli_fetch_assoc($r_check);
    $user_prev_note = floatval($d_check['note']);
}

// 2. Get current displayed stats from the produits table
$r_prod = mysqli_query($cnx, "SELECT note_avis, nb_avis FROM produits WHERE id='$prod_esc' LIMIT 1");
$d_prod = mysqli_fetch_assoc($r_prod);
$old_nb   = intval($d_prod['nb_avis'] ?? 0);
$old_note = floatval($d_prod['note_avis'] ?? 0);

// 3. Perform the vote in the database (Source of Truth for individual reviews)
mysqli_query($cnx,
    "INSERT INTO `avis_produits` (`id_produit`, `id_client`, `note`)
     VALUES ('$prod_esc','$client_esc','$note_esc')
     ON DUPLICATE KEY UPDATE `note`='$note_esc', `datecreation`=NOW()"
);

// 4. Calculate NEW displayed stats using a "Running Total" approach
// This treats the current nb_avis as the baseline (including admin seeds).
if ($user_prev_note === null) {
    // New review: Increment count
    $new_nb = $old_nb + 1;
    $new_note = ($old_nb * $old_note + $note_esc) / $new_nb;
} else {
    // Update existing review: Keep count, adjust average
    $new_nb = $old_nb;
    if ($new_nb > 0) {
        $new_note = ($old_nb * $old_note - $user_prev_note + $note_esc) / $new_nb;
    } else {
        $new_note = $note_esc;
        $new_nb = 1;
    }
}

$new_note = round($new_note, 2);
if ($new_note > 5) $new_note = 5.0;
if ($new_note < 0) $new_note = 0.0;

// 5. Update the product table
mysqli_query($cnx, "UPDATE produits SET note_avis='$new_note', nb_avis='$new_nb' WHERE id='$prod_esc'");

// Return the updated values
echo json_encode([
    'success'  => true,
    'note'     => $new_note,
    'nb_avis'  => $new_nb,
    'user_vote'=> $note_esc
]);
exit;
?>
