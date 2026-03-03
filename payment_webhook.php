<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("includes/includes.php"); 
include("include.php"); 
//url dev
$mode="live";

//données production
/*$url= "https://api.konnect.network/api/v2/payments/init-payment";
$wallet ="6601e9c587ed39c5249a17b3";
$key_api="6601e9c587ed39c5249a17ac:SHqO1zlXYSvyLOwYKqxTTzEz51ul";
*/
$headers = array('Content-type: application/json','x-api-key: '.$key_api,'Accept: application/json');
$payment_ref = $_GET['payment_ref'];
            
            if ($mode == 'sandbox') {
                $url = 'https://api.preprod.konnect.network/api/v2/payments/'. $payment_ref;
            }
            elseif ($mode == 'live') {
                $url = 'https://api.konnect.network/api/v2/payments/'. $payment_ref;
            }


/*$payload = json_encode(array(
        "receiverWalletId" => $wallet,
        "token" => "TND",
        "amount" => 10000,
        'type' => 'immediate',
        'description' => 'payment description',
        'acceptedPaymentMethods' => array('wallet', 'bank_card'),
        //'lifespan' => '10',
        'checkoutForm' => false,
        'addPaymentFeesToAmount' => false,
        'firstName' => 'Hsan',
        'lastName' => 'Trabelsi',
        'phoneNumber' => '26020100',
        'email' => 'hsan.trabelsi@gmail.com',
        'orderId' => '100',
        'webhook' => 'https://www.parapharm.tn/payment_webhook.php',
        'silentWebhook' => 'true',
        'successUrl' => 'https://www.parapharm.tn/payment-success/',
        'failUrl' => 'https://www.parapharm.tn/payment-fail/',
        'theme' => 'light',
));
*/
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 


    $response = curl_exec($ch);
    //$response1=json_decode($response,true);
   
    // Send
     $from = "contact@parapharm.tn";
    $to = "hsan.trabelsi@gmail.com";
    $subject = "Essai de PHP Mail";
     $message = wordwrap($response, 70, "\r\n");
    $headers = "De :" . $from;
    //if(mail($to,$subject,$message, $headers)) echo "envoi ok";
   // else echo "envoi non";
    //var_dump($response1); 

    //exit;
    // envoi email 
/*require_once('/home/parapharm1/www/class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"
$mail->SetFrom('contact@parapharm.tn', 'Parapharm.tn');
$mail->AddReplyTo("contact@parapharm.tn","¨Parapharm.tn");
$address = "hsan.trabelsi@gmail.com";
//$address = $email;
$mail->AddAddress($address);//, "Hsan Trabelsi");
$mail->Subject    = "Debug paiement en ligne";
$body=$response;
echo $body;
$mail->MsgHTML($body);
$mail->Send();
*/
//exit;
    //echo curl_getinfo($ch, CURLINFO_HTTP_CODE)." - ".$response; exit;
  
      if (curl_errno($ch)) {
      echo curl_error($ch);
      die();
      }else{
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code == intval(200)){
        
      $response1=json_decode($response);
      echo ($response1->payment->status);
      
      if($response1->payment->status == 'pending'){
          $statut='1';
          
      }elseif($response1->payment->status == 'completed'){
          $statut='9';
          $date = date("d/m/Y H:i:s");
          $datep = timestampTD($date);
          executeRequete("UPDATE `commandes` set `etat`='".$statut."',`date_paiement` = '".$datep."' WHERE `ref_paiement`='".$payment_ref."'");
          $cmdID = orderIdByRefCommande($payment_ref);
          $idClient =idclientCommande($cmdID);
		  $client = nomClient($idClient).' '.prenomClient($idClient);
		  
		  $cmd_express = cmd_expressCommande($cmdID);
		  if($cmd_express == ''){
          // Send
            /*------------------------------------ Email client ----------------------------------------*/
            $to = emailClient(idclientCommande($cmdId));
            $from = $email_contact;//$email_contact
            $subject    = sujetEmail(12);
		    $contenumsg =  messageEmail(12);
		    $contenumsg =  str_replace('%%NOMCLT%%',$client,$contenumsg);
		    $contenumsg =  str_replace('%%NCMD%%',$cmdID,$contenumsg);
		    $contenumsg =  str_replace('%%MNTCMD%%',totalCommande($cmdID),$contenumsg);
		    $contenumsg =  str_replace('%%DATEPCMD%%',$date,$contenumsg);
            //$message = wordwrap($contenumsg, 70, "\r\n");
		    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= "De :" .$from;
            mail($to,$subject,$contenumsg, $headers);
		  }
            
            /*------------------------------------ Email admin ----------------------------------------*/
            
            $from = emailClient(idclientCommande($cmdId));
            $to1 = $email_contact;//$email_contact
            $subject1    = sujetEmail(11);
		    $contenumsg1 =  messageEmail(11);
		    $contenumsg1 =  str_replace('%%MNTCMD%%',totalCommande($cmdID),$contenumsg1);
		    $contenumsg1 =  str_replace('%%NCMD%%',$cmdID,$contenumsg1);
		    $contenumsg1 =  str_replace('%%NOMCLT%%',$client,$contenumsg1);
		    $contenumsg1 =  str_replace('%%DETAILSCMD%%',detailsPaiementCommande($cmdID),$contenumsg1);
            //$message1 = wordwrap($contenumsg1, 70, "\r\n");
            mail($to1,$subject1,$contenumsg1, $headers);
            
      }
      
      //$payment_link=$response1->payUrl;
      ?>
  <?php
      exit;
    }
    else{
      //echo  $http_code." - ". $response; //"Ressource introuvable : " . $http_code;
    }
  }
    curl_close($ch);
 
?>
