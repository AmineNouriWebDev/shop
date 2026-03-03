<?php 

    //$url="https://api.preprod.konnect.network/api/v2/payments/init-payment";
    //$key_api="6604435ff85f11d7b8d67d67:yTvOzwXT1FL0tgc2Wu17";
    //$wallet="6604435ff85f11d7b8d67d6e";

    if(isset($_POST['action']) && $_POST['action']=="confirm_cmd" ){
        $id_client         = sanitize($_SESSION['client_id']);
        $moyen_livraison   = isset($_SESSION['shipping']) ? sanitize($_SESSION['shipping']) : '';
        $moyen_paiement    = sanitize($_POST['paymentMethod']);
        $datec             = timestampTD(date("d/m/Y H:i:s"));
        $montant_globale   = sanitize($_POST['soustotal']);
        $globale           = sanitize($_POST['total']);
        $nom               = sanitize($_POST['nom']);
        $prenom            = sanitize($_POST['prenom']);
        $email             = sanitize($_POST['email']);
        $adresse           = sanitize($_POST['adresse']);
        $ville             = sanitize($_POST['ville']);
        $cp                = sanitize($_POST['cp']);
        $phone             = sanitize($_POST['phone']);
        $commentaire       = sanitize($_POST['commentaire']);
        $frais_livraison   = sanitize($_POST['frais_livraison']);
        $etat              = '1';
        $descriptionCmd    ='';
        $urlOg = '';
     
     
        
        $requete = 'INSERT INTO `commandes` 
        (`idclient`, `date`, `sous_total`, `total`, `moyen_paiement`, `moyen_livraison`, `frais_livraison`, `nom`, `prenom`, `email`, `adresse`, `ville`, `cp`, `tel`, `commentaire`, `remise`, `date_paiement`, `lien_paiement`, `ref_paiement`, `code_envoi`, `code`, `cmd_express`, `etat`) 
        VALUES
        ("'.$id_client .'", "'. $datec .'", "'. $montant_globale .'", "'. $globale .'", "'. $moyen_paiement .'", "0", "'.$frais_livraison.'", "'. $nom .'","'. $prenom .'","'. $email .'","'. $adresse .'", "'. $ville .'", "'. $cp .'","'. $phone .'", "'. $commentaire .'", "0.000", "", "", "", "", "", "", "'.$etat.'")';
		$connexion = ouvrirCnx() or die("erreur cnx");
	    $resultat  = mysqli_query($connexion, $requete);	
	    $id_cmd    = mysqli_insert_id($connexion);
        $nombre_cmd =  sprintf("%05d", $id_cmd);
		$code_cmd  = date("y").date("m").$nombre_cmd;
		
        
		$cmd = $id_cmd;
		
		        $client = nomClient($id_client).' '.prenomClient($id_client);
    		    $email  = emailClient($id_client);
    		    
    		    $headersMail  = 'MIME-Version: 1.0' . "\r\n";
    		    $headersMail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    		    $headersMail .= 'From:'.$nomSite.' <info@technoplus.tn>'. "\r\n";
    		    $sujet    = sujetEmail(9);
    		    $sujet    = str_replace('%%NCMD%%',$cmd,$sujet);
    		    $contenumsg =  messageEmail(9);
    		    $contenumsg =  str_replace('%%NOMCLT%%',$client,$contenumsg);
    		    $contenumsg =  str_replace('%%MNTCMD%%',totalCommande($cmd),$contenumsg);
    		    $contenumsg =  str_replace('%%DETAILSCMD%%',detailsCommande($cmd),$contenumsg);
    		    $contenumsg .= 'Email client : '.$email;
    		    $contenumsg .= '<br/> Commentaire : '.$commentaire;
    		    //echo $contenumsg;
    		    if($_SERVER['SERVER_NAME'] != 'localhost') {
    		        @mail($email_contact, $sujet, $contenumsg, $headersMail, "-f ".$email_contact."");
    		    }
    		    
		
		$requete_cmd = 'UPDATE `commandes` set `code`="'.$code_cmd.'" WHERE `id`="'.$id_cmd.'"';
		$resultat_cmd = executeRequete($requete_cmd); 
		
		$nbArticles=count($_SESSION['panier']['idcart']);
		//echo $nbArticles;
		$total_globale = 0;
		  for ($i=0 ;$i < $nbArticles ; $i++) {
			if($_SESSION['panier']['promo'][$i]) {
			  $prix1 = $_SESSION['panier']['promo'][$i];
			  $totalProduit = $_SESSION['panier']['promo'][$i]*$_SESSION['panier']['qte_prd'][$i];
  		   } else {
			  $prix1 = $_SESSION['panier']['price'][$i];
			  $totalProduit = $_SESSION['panier']['price'][$i]*$_SESSION['panier']['qte_prd'][$i];
		  }
		   $prix  = $_SESSION['panier']['promo'][$i];
		   $total = $_SESSION['panier']['qte_prd'][$i] * $prix1;
		   
		   $descriptionCmd .= $_SESSION['panier']['qte_prd'][$i].' x '.titreProduits($_SESSION['panier']['idcart'][$i]);
		   
		   $total_globale = $total_globale + $total;
		  //echo ($_SESSION['panier']['idcart'][$i]);exit; 	 		  
		   $valeur_promo = !empty($_SESSION['panier']['promo'][$i]) ? $_SESSION['panier']['promo'][$i] : '0.000';
		   
		   $requete_ligne  =  "INSERT INTO `ligne_commande` 
		  (`idcommande`, `id_produit`, `quantite`, `prix`, `remise`, `prix_promo`, `total`, `code_barre`, `notification`, `commentaire`, `date`, `etat`)
		  VALUES
		  ('". $id_cmd ."', '". $_SESSION['panier']['idcart'][$i] ."', '". $_SESSION['panier']['qte_prd'][$i] ."', '". $_SESSION['panier']['price'][$i] ."', '0.000', '". $valeur_promo ."', '". $totalProduit ."', '', '0', '', '". $datec ."',  '".$etat."')";
		  //echo $requete_ligne; exit;
	      $resultat_ligne = executeRequete($requete_ligne);
		    
			$quantite_produit = quantiteProduits($_SESSION['panier']['idcart'][$i])-$_SESSION['panier']['qte_prd'][$i];
			
			
			$urlOg .= $descriptionCmd." / ";
			
			$requete2 = 'UPDATE `produits` set `quantite`="'. $quantite_produit .'" WHERE `id`="'.$_SESSION['panier']['idcart'][$i].'"';
			$result2  = executeRequete($requete2);
			
         } 
		 
		if($moyen_paiement == 10){
		    $urlOg = rtrim($urlOg," / ");
		    $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode(str_replace('%%lien_produit%%',$urlOg,$message_cmd_whatsapp));
		/*-------------------------------------------------------- Payment part ----------------------------------------------------------------------------*/
		//echo str_replace('.','',$globale);
		/*$descriptionCmd ="Paiement commande Technoplus.tn :".$cmd;
		$headers = array('Content-type: application/json','x-api-key: '.$key_api);
        $payload = json_encode(array(
                "receiverWalletId" => $wallet,
                "token" => "TND",
                "amount" => str_replace('.','',$globale),
                'type' => 'immediate',
                'description' => $descriptionCmd,//'payment description'
                'acceptedPaymentMethods' => array('bank_card'),
                //'lifespan' => '10',
                'checkoutForm' => false,
                'addPaymentFeesToAmount' => false,
                'firstName' => $prenom,
                'lastName' => $nom,
                'phoneNumber' => $phone,
                'email' => $email,
                'orderId' => $cmd,
                'webhook' => 'https://technoplus.tn/payment_webhook.php',
                'silentWebhook' => 'true',
                'successUrl' => 'https://technoplus.tn/payment-success.php',
                'failUrl' => 'https://technoplus.tn/payment-fail.php',
                'theme' => 'light',
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_payment);
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
                //print_r($response1); 
                $payment_link=$response1->payUrl;
    		
                executeRequete("UPDATE `commandes` set `lien_paiement`='".$payment_link."',`ref_paiement`='".$payment_ref."' WHERE `id`='".$cmd."'");
                
    		    // Alerte client 
		        $client = $nom.' '.$prenom;
    		    $sujet1    = sujetEmail(2);
    		    $sujet1    = str_replace('%%CODECMD%%',$code_cmd,$sujet1);
    		    $contenumsg1 =  messageEmail(2);
    		    $contenumsg1 =  str_replace('%%NOMCLT%%',$client,$contenumsg1);
    		    $contenumsg1 =  str_replace('%%CODECMD%%',$code_cmd,$contenumsg1);
    		    $contenumsg1 =  str_replace('%%DETAILSCMD%%',detailsCommande($cmd),$contenumsg1);
    		    $contenumsg1 =  str_replace('%%PLATEFORM%%',$payment_link,$contenumsg1);
    		    
    		    mail($email, $sujet1, $contenumsg1, $headersMail, "-f ".$email_contact."");
    		    
            }
            else{
              //echo  $http_code." - ". $response; //"Ressource introuvable : " . $http_code;
            }
        } 
        */
        /*---------------------------------------------------------------------------------------------------------------------------------------------------*/
        
        }

        if($moyen_paiement == 11){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
            $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express / Paiement D17:".$urlOg);
        }
        if($moyen_paiement == 12){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
            $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express / Paiement Paypal:".$urlOg);
        }
        
		$msg="Votre commande a été bien enregistrée.";

		   unset($_SESSION['panier']);
		   if($moyen_paiement == 10 || $moyen_paiement == 11 || $moyen_paiement == 12){
?>
	<script language="javascript">
      <!--
      window.open('<?php echo $payment_link;?>');
      -->
    </script>
    <?php 
    
    curl_close($ch); 
    
    }else{ ?>
    <script language="javascript">
    
        alert('<?php echo $msg; ?>');
	 <!--
	  window.location = '<?php echo lienConfirm($cmd); ?>';
	 -->
	</script>
<?php }
        
} ?>    
    
    <div class="main main-content-wrapper d-flex clearfix">
        
        <div class="cart-table-area section-padding-20 animated fadeInUp " data-delay="0.8s">
            <div class="container">
				
				
				<form action="<?php echo lienCommande(); ?>" method="post">
                <div class="row">
                    <div class="col-12">
						<div class="title">
                            <h2>Caisse</h2>
							<div class="shop_sidebar_area p-0 bg-transparent mb-5">
								<div class="line"></div>
							</div>
                        </div>
					</div>
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-0 clearfix">
                                <div class="row">
                                    
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="nom" class="form-control" id="last_name" value="<?php echo nomClient($id_client); ?>" placeholder="Nom" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="prenom" class="form-control" id="first_name" value="<?php echo prenomClient($id_client); ?>" placeholder="Prenom" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo emailClient($id_client); ?>" required>
                                    </div> 
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="phone" class="form-control" id="phone_number" placeholder="N° téléphone" value="" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" name="adresse" class="form-control mb-3" id="street_address" placeholder="Adresse" value="" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="ville" class="form-control" id="city" placeholder="Ville" value="" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="cp" class="form-control" id="zipCode" placeholder="Code postale" value="" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <textarea name="commentaire" class="form-control w-100" id="comment" cols="30" rows="10" placeholder="Laissez un commentaire sur votre commande"></textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
					
					<?php $nbArticles=count($_SESSION['panier']['idcart']); ?>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary  mt-0">
                            <h5> Total du panier <span class="badge badge-primary badge-pill pull-right"><?php echo $nbArticles; ?></span></h5>
                            <ul class="summary-table">
								<?php 
								if($nbArticles) { 
								$sous_total= 0;
								$total= 0;
								$frais= 0;
								$devise="DT";
								$type='';
								   for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
                                    {
                                        $total_ligne =number_format($_SESSION['panier']['total'][$i], 3, '.', '');
					                    $sous_total = $sous_total + $total_ligne;
					                    $type .= typeProduits($_SESSION['panier']['idcart'][$i]).',';
					                    
                                    }
                                    $type = rtrim($type,',');
                                    $req = "SELECT * FROM `frais_livraison` WHERE min < $sous_total AND max > $sous_total  ORDER BY `id`";
                        			$res = executeRequete($req);
                        			$numres = mysqli_num_rows($res);
                        			if($numres > 0){
                            			while ($data = mysqli_fetch_array($res))
                            			{
                            												
                            				$id=afficheChamp($data['id']);
                            				if(in_array('E',explode(',',$type))){
                                                $frais = valeurFraisLivraison($id);
                            				}else{
                                                $frais = '0.000';
                            				}
                                            
                                            $cout = number_format($frais,3, '.', ' ').' DT';
                                            $sous_total1 = $frais + $sous_total;
                                            $total  = number_format($sous_total1,3, '.', ' ');
                                            
                            			}
                        			}else{
                        			    
                            			$req1 = "SELECT * FROM `frais_livraison` WHERE min < $sous_total AND max ='0'  ORDER BY `id`";
                            			$res1 = executeRequete($req1);
                            			$numres1 = mysqli_num_rows($res1);
                            			if($numres1 > 0){
                            			while ($data1 = mysqli_fetch_array($res1))
                                			{
                                												
                                				$id1=afficheChamp($data1['id']);
                                                if(in_array('E',explode(',',$type))){
                                                    $frais = valeurFraisLivraison($id1);
                                				}else{
                                                    $frais = '0.000';
                                				}
                                                
                                                $cout = 'Gratuit';
                                                $sous_total1 = $frais + $sous_total;
                                                $total  = number_format($sous_total1,3, '.', ' ');
                                                
                                			}
                            			}
                        			    
                        			}
							    ?>
                                <li><span>sous-total:</span> <span><?php echo number_format($sous_total,3, '.', ' ').' '.$devise; ?> </span></li>
     
                                <li><span>livraison:</span> <span id="cout_mod_liv"><?php echo $cout; ?></span></li>
                                <li><span>total:</span> <span id="total_cmd"><?php echo $total.' '.$devise; ?> </span></li>
								
								<?php } ?>
								
                            </ul>
							<input type="hidden" name="soustotal" value="<?php echo number_format($sous_total,3, '.', ' '); ?>" />
							<input type="hidden" name="total" id="total_commande" value="<?php echo $total; ?>" />
							<input type="hidden" name="frais_livraison" id="frais_livraison" value="<?php echo $frais; ?>" />

                            <div class="payment-method">
								<?php
									$requete = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1"';
									$res     = executeRequete($requete);
								   while($data    = mysqli_fetch_array($res)){
								?>
                                <!-- Cash on delivery -->
                                <div class="custom-control custom-radio mr-sm-2">
                                    <input type="radio" name="paymentMethod" class="custom-control-input" value="<?php echo $data['id']; ?>" id="payment_<?php echo $data['id'];?>" <?php if($data['id'] == 9){ echo "checked"; } ?>  required>
                                     <label class="custom-control-label" for="payment_<?php echo $data['id'];?>"><?php echo moyen_paiement($data['id']); 
                                                    if(moyen_paiement($data['id']) == "Paiement en ligne") echo '<img class="ml-15" src="dist/img/paiement_en_ligne.png" alt="">';
                                                    if(moyen_paiement($data['id']) == "Paiement Paypal") echo '<img class="ml-15" src="dist/img/paypal.png" alt="">';
                                                    if(moyen_paiement($data['id']) == "Paiement par D17") echo '<img class="ml-15" src="dist/img/d17.png" alt="">';

                                                    ?></label>
                                    </div>
								<?php } //onclick="SetSessionPayment(this.value)" ?>
                            </div>

                            <div class="cart-btn mt-50">
                                <button type="submit" class="btn amado-btn w-100">Confirmez la commande</button>
                               
								<input type="hidden" name="action" id="confirmVal"  value="confirm_cmd" />	
								
                            </div>
                        </div>
                    </div>
                </div>
				</form>
            </div>
        </div>
        
    </div>
    
    <script>
        /*function SetSessionPayment(val){
            
            if($("input[name='paymentMethod']:checked").length > 0){
                if($("input[name='paymentMethod']:checked").val() == 9){
			    var sous_total = $("input[name='soustotal']").val();
			    var total ='';
                $.ajax({
                   type: "POST", 
                   url: "includes/ml.php",
    			   data: {"mod_liv":val,"sous_total":sous_total}, 
    			   dataType: 'json',
    	           success: function(json) { 
    			      $('#cout_mod_liv').html(json['cout_ml_f']);
    			      $('#total_cmd').html(json['sous_total']);
    			      $('#frais_livraison').val(json['cout_ml']);
    			      $('#total_commande').val(json['total']);
    				  
                    }
 
                });
                }
                else{
                    var sous_total = $("input[name='soustotal']").val();
                    var frais_livraison = $("input[name='frais_livraison']").val();
    			    var total =$("input[name='total']").val();
                    $.ajax({
                       type: "POST", 
                       url: "includes/removeml.php",
        			   data: {"frais_livraison":frais_livraison,"sous_total":sous_total,"total":total}, 
        			   dataType: 'json',
        	           success: function(json) { 
        			      $('#cout_mod_liv').html(json['cout_ml_f']);
        			      $('#total_cmd').html(json['sous_total']);
        			      $('#frais_livraison').val(json['cout_ml']);
        			      $('#total_commande').val(json['total']);
        				  
                        }
     
                    });
                }
            }
        }*/
    </script>