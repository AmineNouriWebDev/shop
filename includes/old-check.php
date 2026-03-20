<?php 

    if(isset($_GET['cmdId'])){ $cmdId = sanitize($_GET['cmdId']); }

   if(isset($_POST['action']) && $_POST['action']=="confirm_cmd" ){
     $id_client         = sanitize($_SESSION['client_id']);
     $moyen_livraison   = sanitize($_SESSION['shipping']);
     $moyen_paiement    = sanitize($_POST['paymentMethod']);
     $datec             = timestampTD(date("d/m/Y H:i:s"));
     $montant_globale   = sanitize($_POST['soustotal']);
     $globale           = sanitize($_POST['total']);
     $nom               = sanitize($_POST['nom']);
     $email             = sanitize($_POST['email']);
     $adresse           = sanitize($_POST['adresse']);
     $ville             = sanitize($_POST['ville']);
     $cp                = sanitize($_POST['cp']);
     $phone             = sanitize($_POST['phone']);
     $commentaire       = sanitize($_POST['commentaire']);
     $frais_livraison   = sanitize($_POST['frais_livraison']);
     $etat           	= '1';
     $cmdId             = sanitize($_POST['idcmd']);
     //$remise            = sanitize($_GET['remise']);
     $code_envoi        = random(40);
     
     
     $cmd = '';
     
        $requeteLigneCmd  = 'SELECT * FROM `ligne_commande` WHERE `idcommande` = "'.$cmdId.'"';
        //echo $requeteLigneCmd; exit;
        $resultatLigneCmd = executeRequete($requeteLigneCmd);
        $numrowsLigneCmd  = mysqli_num_rows($resultatLigneCmd);
        
        if($numrowsLigneCmd > 0 ){
            
            
	    $date         = date('Y-m-d H:i:s');
        
		$requete_cmd  = 'UPDATE `commandes` set `etat`="3" WHERE `id`="'.$cmdId.'"';
		$resultat_cmd = executeRequete($requete_cmd);   
		$requete_cmd1  = 'UPDATE `ligne_commande` set `etat`="3", `date` ="'. $date .'" WHERE `idcommande`="'.$cmdId.'"';
		$resultat_cmd1 = executeRequete($requete_cmd1);  
		
        $ref_paiement=referencePaiementCommande($cmdId);
        executeRequete("UPDATE `commandes` set `ref_paiement`='".$ref_paiement."' WHERE `id`='".$cmdId."'");
		
		$cmd = $cmdId;
		
		    $client = nomClient($id_client).' '.prenomClient($id_client);
		    $email  = emailClient($id_client);
		    $email_contacts = explode(';',$email_contact);
		    // Alerte client 
		    foreach($email_contacts as $emc){
		    // Alerte client     
		    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		    $headers .= 'From:'.$nomSite.' <info@technoplus.tn>' . "\r\n";
		    $sujet    = sujetEmail(2);
		    $sujet    = str_replace('%%NCMD%%',$cmd,$sujet);
		    $contenumsg =  messageEmail(2);
		    $contenumsg =  str_replace('%%NOMCLT%%',$client,$contenumsg);
		    $contenumsg =  str_replace('%%NCMD%%',$cmd,$contenumsg);
		    $contenumsg =  str_replace('%%MNTCMD%%',totalCommande($cmd),$contenumsg);
		    $contenumsg =  str_replace('%%DETAILSCMD%%',detailsCommande($cmd),$contenumsg);
		    $contenumsg =  str_replace('%%PLATEFORMECMD%%',url_paiement($moyen_paiement),$contenumsg);
		    $contenumsg .= 'Commentaire : '.$commentaire;
		    //echo $contenumsg;
		    mail($email, $sujet, $contenumsg, $headers, "-f ".$emc."");
		    }
									
            
        }else{
        
        $requete = 'INSERT INTO `commandes` 
        (`idclient`, `date`, `sous_total`, `total`, `moyen_paiement`,`frais_livraison`,`code_envoi`, `adresse`, `ville`, `cp`, `tel`, `commentaire`,  `etat`) 
        VALUES
        ("'. $id_client .'", "'. $datec .'", "'. $montant_globale .'", "'. $globale .'", "'. $moyen_paiement .'","'.$frais_livraison.'","'.$code_envoi.'", "'. $adresse .'", "'. $ville .'", "'. $cp .'","'. $phone .'", "'. $commentaire .'", "'.$etat.'")';
		$connexion = ouvrirCnx() or die("erreur cnx");
	    $resultat  = mysqli_query($connexion, $requete);	
	    $id_cmd    = mysqli_insert_id($connexion);
        $nombre_cmd =  sprintf("%05d", $id_cmd);
		$code_cmd  = date("y").date("m").$nombre_cmd;
		
        $ref_paiement=referencePaiementCommande($id_cmd);
        executeRequete("UPDATE `commandes` set `ref_paiement`='".$ref_paiement."' WHERE `id`='".$id_cmd."'");
        
		$cmd = $id_cmd;
		
		    
		
		    $client = nomClient($id_client).' '.prenomClient($id_client);
		    $email  = emailClient($id_client);
		    $email_contacts = explode(';',$email_contact);
		    // Alerte client 
		    foreach($email_contacts as $emc){
		    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		    $headers .= 'From:'.$nomSite.' <info@technoplus.tn>'. "\r\n";
		    $sujet    = sujetEmail(9);
		    $sujet    = str_replace('%%NCMD%%',$cmd,$sujet);
		    $contenumsg =  messageEmail(9);
		    $contenumsg =  str_replace('%%NOMCLT%%',$client,$contenumsg);
		    $contenumsg =  str_replace('%%MNTCMD%%',totalCommande($cmd),$contenumsg);
		    $contenumsg =  str_replace('%%DETAILSCMD%%',detailsCommande($cmd),$contenumsg);
		    $contenumsg .= 'Email client : '.$email;
		    $contenumsg .= '<br/> Commentaire : '.$commentaire;
		    //echo $contenumsg;
		    mail($emc, $sujet, $contenumsg, $headers, "-f ".$emc."");
		    }
		
		$requete_cmd = 'UPDATE `commandes` set `code`="'.$code_cmd.'" WHERE `id`="'.$id_cmd.'"';
		$resultat_cmd = executeRequete($requete_cmd); 
		
		$nbArticles=count($_SESSION['panier']['idcart']);
		//echo $nbArticles;
		$total_globale ="";
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
		   
		   $total_globale = $total_globale + $total;
		  //echo ($_SESSION['panier']['idcart'][$i]);exit; 	 		  
		  $requete_ligne  =  "INSERT INTO `ligne_commande` (`idcommande`, `id_produit`, `quantite`, `prix`, `prix_promo`, `total`, `etat`) VALUES ('". $id_cmd ."', '". $_SESSION['panier']['idcart'][$i] ."', '". $_SESSION['panier']['qte_prd'][$i] ."', '". $_SESSION['panier']['price'][$i] ."', '". $_SESSION['panier']['promo'][$i] ."', '". $totalProduit ."',  '".$etat."')";
		  //echo $requete_ligne; exit;
	      $resultat_ligne = executeRequete($requete_ligne);
		    
			$quantite_produit = quantiteProduits($_SESSION['panier']['idcart'][$i])-$_SESSION['panier']['qte_prd'][$i];
			
			
			$requete2 = 'UPDATE `produits` set `quantite`="'. $quantite_produit .'" WHERE `id`="'.$_SESSION['panier']['idcart'][$i].'"';
			$result2  = executeRequete($requete2);
			
         } 
        }
		 
		  
		//$msg="<div class='alert alert-success' role='alert'>Votre commande a été bien enregistrée.</div>";
		$msg="Votre commande a été bien enregistrée.";

		   unset($_SESSION['panier']);
?>
    <script language="javascript">
    
        alert('<?php echo $msg; ?>');
	 <!--
	  window.location = '<?php echo lienConfirm($cmd); ?>';
	 -->
	</script>
<?php } ?>    
    
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
                                        <input type="text" name="nom" class="form-control" id="first_name" value="<?php echo nomClient($id_client).' '.prenomClient($id_client); ?>" placeholder="Nom" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo emailClient($id_client); ?>" required>
                                    </div> 
                                    <div class="col-12 mb-3">
                                        <input type="text" name="adresse" class="form-control mb-3" id="street_address" placeholder="Adresse" value="" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" name="ville" class="form-control" id="city" placeholder="Ville" value="" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="cp" class="form-control" id="zipCode" placeholder="Code postale" value="" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="phone" class="form-control" id="phone_number" placeholder="N° téléphone" value="" required>
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
								   for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
                                    {
                                        $total_ligne =number_format($_SESSION['panier']['total'][$i], 3, '.', '');
					                    $sous_total = $sous_total + $total_ligne;
                                    }
							    ?>
                                <li><span>sous-total:</span> <span><?php echo number_format($sous_total, 3, '.', '').' '.$devise; ?> </span></li>
     
                                  <?php $total= $total + $sous_total; ?>
                                <li><span>livraison:</span> <span id="cout_mod_liv">Gratuit</span></li>
                                <li><span>total:</span> <span id="total_cmd"><?php echo number_format($total, 3, '.', '').' '.$devise; ?> </span></li>
								
								<?php }elseif($cmdId){ ?>
								
                                <li><span>sous-total:</span> <span><?php echo soustotalCommande($cmdId); ?> </span></li>
     
                                  <?php $total= $total + $sous_total; ?>
                                <li><span>livraison:</span> <span>Gratuit</span></li>
                                <li><span>total:</span> <span id="total_cmd"><?php echo totalcommande($cmdId); ?> </span></li>
								<?php } ?>
                            </ul>
							<input type="hidden" name="soustotal" value="<?php if($cmdId) echo soustotalCommande($cmdId); else echo $sous_total; ?>" />
							<input type="hidden" name="total" id="total_commande" value="<?php if($cmdId) echo totalcommande($cmdId); else echo number_format($total, 3, '.', '').' '.$devise; ?>" />
							<input type="hidden" name="idcmd" value="<?php if($cmdId) echo $cmdId;?>" />
							<input type="hidden" name="frais_livraison" id="frais_livraison" value="" />

                            <div class="payment-method">
								<?php
									$requete = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1"';
									$res     = executeRequete($requete);
								   while($data    = mysqli_fetch_array($res)){
								?>
                                <!-- Cash on delivery -->
                                <div class="custom-control custom-radio mr-sm-2">
                                    <input type="radio" name="paymentMethod" class="custom-control-input" onclick="SetSessionPayment(this.value)" value="<?php echo $data['id']; ?>" id="payment_<?php echo $data['id'];?>" required>
                                    <label class="custom-control-label" for="payment_<?php echo $data['id'];?>"><?php echo moyen_paiement($data['id']); if(moyen_paiement($data['id']) == "Paiement en ligne") echo '<img class="ml-15" src="dist/img/paypal.png" alt="">'; ?></label>
                                </div>
								<?php } ?>
                            </div>

                            <div class="cart-btn mt-50">
                                <button type="submit" class="btn amado-btn w-100">Confirmez la commande</button>
                               
								<input type="hidden" name="action" id="confirmVal"  value="" />	
								
                            </div>
                        </div>
                    </div>
                </div>
				</form>
            </div>
        </div>
        
    </div>
    
    <script>
        function SetSessionPayment(val){
            
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
    			      $('#total_commande').val(json['sous_total']);
    			      $('#confirmVal').val('confirm_cmd');
    				  
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
    			          //$('#confirmVal').val('confirm_paiement');
    			          $('#confirmVal').val('confirm_cmd');
        				  
                        }
     
                    });
                }
            }
        }
    </script>