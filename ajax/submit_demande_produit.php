<?php
session_start();
include("../include.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recherche = isset($_POST['recherche']) ? formReception($_POST['recherche']) : '';
    $nom_produit = isset($_POST['nom_produit']) ? formReception($_POST['nom_produit']) : '';
    $telephone = isset($_POST['telephone']) ? formReception($_POST['telephone']) : '';

    if (!empty($nom_produit)) {
        $req = "INSERT INTO `demandes_produits` (`recherche`, `nom_client`, `telephone`, `traite`, `date_demande`) VALUES ('$recherche', '$nom_produit', '$telephone', '0', NOW())";
        $success = executeRequete($req);
        if($success) {
            // Notifications
            $tg_token = !empty($telegram_bot_token) ? $telegram_bot_token : '';
            $tg_chat  = !empty($telegram_chat_id)   ? $telegram_chat_id   : '';
            
            if (!empty($tg_token) && !empty($tg_chat)) {
                $msg = "🔍 *NOUVELLE SUGGESTION PRODUIT*\n\n"
                     . "📦 *Produit :* {$nom_produit}\n"
                     . "📞 *Tél Client :* {$telephone}\n"
                     . "🔎 *Recherche initiale :* {$recherche}\n";
                
                $tg_url = "https://api.telegram.org/bot{$tg_token}/sendMessage";
                $ch = @curl_init($tg_url);
                if($ch) {
                    @curl_setopt_array($ch, [
                        CURLOPT_POST           => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT        => 5,
                        CURLOPT_POSTFIELDS     => json_encode([
                            'chat_id'    => $tg_chat,
                            'text'       => $msg,
                            'parse_mode' => 'Markdown',
                        ]),
                        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                    ]);
                    @curl_exec($ch);
                    @curl_close($ch);
                }
            }

            // Email Notification
            if(!empty($email_contact)) {
                $sujet = "Nouvelle suggestion de produit : " . $nom_produit;
                $msg_html = "<h3>Nouvelle demande de produit absente</h3>"
                          . "<p><b>Produit suggéré :</b> " . $nom_produit . "</p>"
                          . "<p><b>Téléphone :</b> " . $telephone . "</p>"
                          . "<p><b>Recherche effectuée :</b> " . $recherche . "</p>";
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                $headers .= 'From: ' . $nom_site . ' <' . $email_contact . '>' . "\r\n";
                
                @mail($email_contact, $sujet, $msg_html, $headers);
            }

            echo "OK";
        } else {
            http_response_code(500);
            echo "Erreur lors de l'insertion en base de données";
        }
    } else {
        http_response_code(400);
        echo "Erreur";
    }
} else {
    http_response_code(405);
    echo "Methode non autorisée";
}
?>
