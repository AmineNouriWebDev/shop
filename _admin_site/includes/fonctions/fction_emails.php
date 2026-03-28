<?php
function sujetEmail($id)
{
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['sujet']);
}
function messageEmail($id)
{
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['message']);
}
function envoiEmail($id)
{
    global $email_contact;
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    $email = afficheChamp($data['email_envoi']);
    
    // Default system emails to replace dynamically
    $defaults = ['contact@technoplus.tn', 'info@technoplus.tn', 'no_reply@technoplus.tn', 'info@technoplus.io'];
    
    if(empty($email) || in_array(strtolower($email), $defaults)) {
        if(!empty($email_contact)) {
            return explode(';', $email_contact)[0];
        }
    }
	return $email;
}

/**
 * Fonction asynchrone pour envoyer des e-mails ou des notifications (Telegram, etc.)
 * via le webhook n8n configuré par l'administrateur.
 */
function envoiEmail_n8n($payload) {
    global $n8n_webhook_mailing;
    
    // Vérifier si le webhook est configuré et que nous ne sommes pas en local
    if ($_SERVER['SERVER_NAME'] != 'localhost' && !empty($n8n_webhook_mailing)) {
        $ch = curl_init($n8n_webhook_mailing);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Timeout court pour ne pas ralentir le client
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    return false;
}

?>