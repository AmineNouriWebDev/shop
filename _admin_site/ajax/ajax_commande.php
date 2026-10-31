<?php
session_start();
if (!isset($_SESSION['editor_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Accès non autorisé.']);
    exit;
}

include("../../connec.php");
include("../includes/fonctions/fction_db.php");
include("../includes/fonctions/fction_commandes.php");
include("../includes/fonctions/fction_emails.php");

header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? '';
$id_commande = intval($_POST['id'] ?? 0);

if ($id_commande <= 0) {
    echo json_encode(['success' => false, 'error' => 'Identifiant de commande invalide.']);
    exit;
}

if ($action === 'accepter' || $action === 'expedier' || $action === 'changer_etat') {
    if ($action === 'accepter') {
        $new_etat = 3; // 3 = Traitement en cours
        $commentaire = "Commande acceptée directement depuis la liste des commandes";
    } elseif ($action === 'expedier') {
        $new_etat = 2; // 2 = Commande Expédiée
        $commentaire = "Commande marquée comme expédiée depuis la liste des commandes";
    } else {
        $new_etat = intval($_POST['etat'] ?? 3);
        $commentaire = formReception($_POST['commentaire'] ?? "Statut mis à jour directement depuis la liste");
    }
    
    // Vérifier l'existence de la commande
    $chk = executeRequete("SELECT id, etat FROM commandes WHERE id = '$id_commande' LIMIT 1");
    if (!$chk || mysqli_num_rows($chk) == 0) {
        echo json_encode(['success' => false, 'error' => 'Commande introuvable.']);
        exit;
    }
    
    $date = date('Y-m-d H:i:s');
    $notify = '1';
    
    // Mettre à jour la commande
    executeRequete("UPDATE `commandes` SET `etat` = '$new_etat' WHERE `id` = '$id_commande'");
    
    // Enregistrer dans l'historique
    executeRequete("INSERT INTO `historique_etat_commande` (`idcommande`, `idetat`, `date`, `commentaire`, `notif_client`) 
                   VALUES ('$id_commande', '$new_etat', '$date', '$commentaire', '$notify')");
                   
    // Notification client via webhook n8n si configuré
    $template_id = ($new_etat == 9) ? 11 : 10;
    $to = emailCommande($id_commande);
    if (!empty($to)) {
        $num_cmd = numcommande($id_commande);
        $sujet = str_replace('%%NCMD%%', $num_cmd, sujetEmail($template_id));
        $message_envoi = str_replace('%%NCMD%%', $num_cmd, messageEmail($template_id));
        $message_envoi = str_replace('%%ETATCMD%%', etat_commandes($new_etat), $message_envoi);
        $message_envoi = str_replace('%%CMNT%%', $commentaire, $message_envoi);
        
        $payload_n8n = [
            'event'          => 'order_status_update',
            'order_id'       => $id_commande,
            'customer_email' => $to,
            'email_subject'  => $sujet,
            'email_html'     => $message_envoi
        ];
        envoiEmail_n8n($payload_n8n);
    }
    
    $etat_nom = etat_commandes($new_etat);
    if (empty($etat_nom)) {
        if ($new_etat == 3) $etat_nom = 'Traitement en cours';
        elseif ($new_etat == 2) $etat_nom = 'Commande Expédiée';
        else $etat_nom = 'Mise à jour';
    }
    
    if ($action === 'expedier') {
        $msg = "La commande #$id_commande a été marquée comme expédiée avec succès.";
    } elseif ($action === 'accepter') {
        $msg = "La commande #$id_commande a été acceptée avec succès (Statut : $etat_nom).";
    } else {
        $msg = "Le statut de la commande #$id_commande a été mis à jour ($etat_nom).";
    }
    
    echo json_encode([
        'success' => true,
        'message' => $msg,
        'new_etat' => $new_etat,
        'etat_label' => $etat_nom
    ]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Action inconnue.']);
exit;
