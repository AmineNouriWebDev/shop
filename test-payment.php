<?php error_reporting(E_ALL);
include('include.php');
//url dev
$url="https://api.preprod.konnect.network/api/v2/payments/init-payment";
$key_api="6604435ff85f11d7b8d67d67:yTvOzwXT1FL0tgc2Wu17";
$wallet="6604435ff85f11d7b8d67d6e";

//données production
/*$url= "https://api.konnect.network/api/v2/payments/init-payment";
$wallet ="6601e9c587ed39c5249a17b3";
$key_api="6601e9c587ed39c5249a17ac:SHqO1zlXYSvyLOwYKqxTTzEz51ul";
*/

$headers = array('Content-type: application/json','x-api-key: '.$key_api);

$montant_total  = $_GET['amount'];
$descriptionCmd = $_GET['description'];
$prenomclient   = $_GET['firstName'];
$nomclient      = $_GET['lastName'];
$telclient      = $_GET['phoneNumber'];
$emailclient    = $_GET['email'];
$orderId        = $_GET['orderId'];

$payload = json_encode(array(
        "receiverWalletId" => $wallet,
        "token" => "TND",
        "amount" => $montant_total,
        'type' => 'immediate',
        'description' => $descriptionCmd,//'payment description'
        'acceptedPaymentMethods' => array('wallet', 'bank_card'),
        //'lifespan' => '10',
        'checkoutForm' => false,
        'addPaymentFeesToAmount' => false,
        'firstName' => $prenomclient,
        'lastName' => $nomclient,
        'phoneNumber' => $telclient,
        'email' => $emailclient,
        'orderId' => $orderId,
        'webhook' => 'https://technoplus.tn/payment_webhook.php',
        'silentWebhook' => 'true',
        'successUrl' => 'https://technoplus.tn/payment-success.php',
        'failUrl' => 'https://technoplus.tn/payment-fail.php',
        'theme' => 'light',
));
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

    $response = curl_exec($ch);
    //echo curl_getinfo($ch, CURLINFO_HTTP_CODE)." - ".$response; exit;
  
      if (curl_errno($ch)) {
      echo curl_error($ch);
      die();
      }else{
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code == intval(200)){
      $response1=json_decode($response);
      $payment_ref = $response1->paymentRef;
        executeRequete("UPDATE `commandes` set `ref_paiement`='".$payment_ref."' WHERE `id`='".$orderId."'");
      //print_r($response1); 
      $payment_link=$response1->payUrl;
      ?>
  <script language="javascript">
  <!--
  window.location = '<?php echo $payment_link; ?>';
  -->
  </script>
  <?php
      exit;
    }
    else{
      //echo  $http_code." - ". $response; //"Ressource introuvable : " . $http_code;
    }
  }
    curl_close($ch);
 
?>