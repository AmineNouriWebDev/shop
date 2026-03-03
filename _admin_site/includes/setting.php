<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp_logo' ) {
		$requete = "SELECT * FROM `site_configuration`";
	    $resultat = executeRequete($requete);
	    $data = mysqli_fetch_array($resultat);
	     $image 	= afficheChamp($data['logo']);
	     if($image!="") unlink("../media/site/".$image);
          executeRequete("UPDATE `site_configuration` SET `logo`=''");
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=setting';
	-->
	</script>
	<?php
} ?>
<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp_favicon' ) {
		$requete = "SELECT * FROM `site_configuration`";
	    $resultat = executeRequete($requete);
	    $data = mysqli_fetch_array($resultat);
	     $image 	= afficheChamp($data['favicon']);
	     if($image!="") unlink("../media/site/".$image);
          executeRequete("UPDATE `site_configuration` SET `favicon`=''");
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=setting';
	-->
	</script>
	<?php
} ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$nom_site 			= formReception($_POST['nom_site']);
	$email_contact 		= formReception($_POST['email_contact']);
	$protocole          = formReception($_POST['protocole']);
	$chemin_absolu      = formReception($_POST['chemin_absolu']);
	$titre_page		 	= formReception($_POST['titre_page']);
	$adresse      	 	= formReception($_POST['adresse']);
	$longitude    	 	= formReception($_POST['longitude']);
	$latitude    	 	= formReception($_POST['latitude']);
	$analytics	     	= formReception($_POST['analytics']);
	$texte_footer     	= formReception($_POST['texte_footer']);
	$texte_footeren 	= formReception($_POST['texte_footeren']);
    $tagmanager_body    = formReception($_POST['tagmanager_body']);
    $tagmanager_head    = formReception($_POST['tagmanager_head']);
	$tel                = formReception($_POST['tel']);
	$gsm                = formReception($_POST['gsm']);
	$map                = formReception($_POST['map']);
	$fax                = formReception($_POST['fax']);
	$stickyfooter_number= formReception($_POST['stickyfooter_number']);
	$video              = formReception($_POST['video']);
    $whatsapp           = formReception($_POST['whatsapp']);
    $adresse_contact    = formReception($_POST['adresse_contact']);
    $GOOGLE_CLIENT_ID   = formReception($_POST['gcid']);
    $GOOGLE_CLIENT_SECRET    = formReception($_POST['gcs']);
    
	$cmd_num_sms 		= formReception($_POST['cmd_num_sms']);
	$cmd_num_whatsapp 	= formReception($_POST['cmd_num_whatsapp']);
	$message_cmd_sms 	= formReception($_POST['message_cmd_sms']);
	$message_cmd_whatsapp 	= formReception($_POST['message_cmd_whatsapp']);
	$lien_cmd_messenger 	= formReception($_POST['lien_cmd_messenger']);
	$message_cmd_messenger 	= formReception($_POST['message_cmd_messenger']);
    
    $key_api             = formReception($_POST['key_api']);	
    $wallet              = formReception($_POST['wallet']);	
    $url_payment         = formReception($_POST['url_payment']);
    
    
	if($_POST['version'] != '') $version            = formReception($_POST['version']);
	if($_POST['copyright'] != '') $copyright          = formReception($_POST['copyright']);
	if($_POST['copyright_bo'] != '') $copyright_bo       = formReception($_POST['copyright_bo']);
	if($_POST['cle'] != '') $cle                = formReception($_POST['cle']);
	if($_POST['secret'] != '') $secret             = formReception($_POST['secret']);
		
	$requete = 'UPDATE `site_configuration` SET	`nom_site` = "'. $nom_site .'", `protocole` = "'. $protocole .'",`whatsapp` = "'. $whatsapp .'",`map` = "'. $map .'",
	`adresse_contact` = "'. $adresse_contact .'",`tagmanager_body` = "'. $tagmanager_body .'",`tagmanager_head` = "'. $tagmanager_head .'", `chemin_absolu` = "'. $chemin_absolu .'",
	`email_contact` = "'. $email_contact .'",`key_api` = "'. $key_api .'",`wallet` = "'. $wallet .'",`url_payment` = "'. $url_payment .'",`titre_page` = "'.$titre_page.'",`analytics` = "'. $analytics .'", `tel` = "'. $tel .'", `gsm` = "'. $gsm .'", `fax` = "'. $fax .'",
	`adresse` = "'. $adresse .'", `longitude` = "'. $longitude .'", `latitude` = "'. $latitude .'",`num_appel_vocale`="'. $stickyfooter_number .'",`texte_footer`="'. $texte_footer .'",
	`texte_footeren`="'. $texte_footeren .'", `copyright` = "'. $copyright .'",  `copyright_bo` = "'. $copyright_bo .'",`version` = "'. $version .'", `cle` = "'. $cle .'",
	`message_cmd_messenger` = "'. $message_cmd_messenger .'",`cmd_num_whatsapp` = "'. $cmd_num_whatsapp .'",`cmd_num_sms` = "'. $cmd_num_sms .'",`message_cmd_sms` = "'. $message_cmd_sms .'",
	`message_cmd_whatsapp` = "'. $message_cmd_whatsapp .'",`lien_cmd_messenger` = "'. $lien_cmd_messenger .'",	`secret` = "'. $secret .'",`GOOGLE_CLIENT_SECRET` = "'. $GOOGLE_CLIENT_SECRET .'",`GOOGLE_CLIENT_ID` = "'. $GOOGLE_CLIENT_ID .'"';

	$resultat = executeRequete($requete);
	
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
	 if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-',"logo-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `site_configuration` set `logo`="'. $photo .'"';
			$result = executeRequete($requete);	
		}
	}
	   
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" ) {
	
			$destination1 = str_replace(' ', '-',"favicon-".$_FILES['image']['name']);
			$destination1 = str_replace('é', 'e', $destination1);
			$destination1 = str_replace('è', 'e', $destination1);
			$destination1 = str_replace('à', 'a', $destination1);
			$destination1 = str_replace('ù', 'u', $destination1);
			$destination1 = str_replace('ç', 'c', $destination1);

			copy ($_FILES['image']['tmp_name'], "../media/site/".$destination1);
			$image = $destination1;
			$requete = 'UPDATE `site_configuration` set `favicon`="'. $image .'"';
			$result = executeRequete($requete);	
		}
	}
	   
	
	$msg="Paramètres mis à jour avec succès.";
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $msg;?>');
		window.location = 'index.php?r=setting';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
}
?>
        <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Paramètres générals du site</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Nom Site <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="nom_site" value="<?php echo $nom_site; ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Logo</h5>
                                        <?php if($logo) { ?>
								         <div><img src="../media/site/<?php echo $logo; ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Favicon</h5>
                                        <?php if($favicon) { ?>
								         <div><img src="../media/site/<?php echo $favicon; ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="image" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Activer SSL:</h5>
                                                <fieldset class="controls">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="1" name="protocole" id="styled_radio1" class="custom-control-input" <?php if($protocole ==1)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="protocole" id="styled_radio2" class="custom-control-input"  <?php if($protocole ==0)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-8">
                                      <div class="form-group">
                                        <h5>Chemin absolu</h5>
                                        <div class="controls">
                                            <input type="text" name="chemin_absolu" value="<?php echo $chemin_absolu; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Email contact (Séparer les emails par des points virgules)</h5>
                                        <div class="controls">
                                            <input type="text" name="email_contact" value="<?php echo $email_contact; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <hr class="border-primary">
									<h4>Commande contact</h4>
									<div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>N° Commande SMS</h5>
                                        <div class="controls">
                                            <input type="text" name="cmd_num_sms" value="<?php echo $cmd_num_sms; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <h5>Messsage Commande SMS</h5>
                                        <div class="controls">
                                            <textarea name="message_cmd_sms" class="form-control" rows="5"> <?php echo $message_cmd_sms; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>N° Commande Whatsapp</h5>
                                        <div class="controls">
                                            <input type="text" name="cmd_num_whatsapp" value="<?php echo $cmd_num_whatsapp; ?>" class="form-control"> 
                                        </div>
                                    </div>
									<div class="form-group">
                                        <h5>Messsage Commande Whatsapp</h5>
                                        <div class="controls">
                                            <textarea name="message_cmd_whatsapp" class="form-control" rows="5"> <?php echo $message_cmd_whatsapp; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                    </div><div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Lien Commande Messenger</h5>
                                        <div class="controls">
                                            <input type="text" name="lien_cmd_messenger" value="<?php echo $lien_cmd_messenger; ?>" class="form-control"> 
                                        </div>
                                    </div> 
                                      <div class="form-group">
                                        <h5>Messsage Commande Messenger</h5>
                                        <div class="controls">
                                            <textarea name="message_cmd_messenger" class="form-control" rows="5"> <?php echo $message_cmd_messenger; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                    </div>
									<hr class="border-primary">
                                    
                                    
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>Téléphone</h5>
                                        <div class="controls">
                                            <input type="text" name="tel" value="<?php echo $telConfig; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>GSM</h5>
                                        <div class="controls">
                                            <input type="text" name="gsm" value="<?php echo $gsm; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>Fax</h5>
                                        <div class="controls">
                                            <input type="text" name="fax" value="<?php echo $fax; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>Whatsapp</h5>
                                        <div class="controls">
                                            <input type="text" name="whatsapp" value="<?php echo $whatsapp; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>Adresse email contact</h5>
                                        <div class="controls">
                                            <input type="text" name="adresse_contact" value="<?php echo $adresse_contact; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <h5>N° appel vocale</h5>
                                        <div class="controls">
                                            <input type="text" name="stickyfooter_number" value="<?php echo $stickyfooter_number; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Vidéo</h5>
                                        <div class="controls">
                                            <input type="text" name="video" value="<?php echo $video; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Adresse</h5>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="<?php echo $adresse; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Longitude</h5>
                                        <div class="controls">
                                            <input type="text" name="longitude" value="<?php echo $longitude; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Latitude</h5>
                                        <div class="controls">
                                            <input type="text" name="latitude" value="<?php echo $latitude; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>GOOGLE_CLIENT_ID</h5>
                                        <div class="controls">
                                            <input type="text" name="gcid" value="<?php echo $GOOGLE_CLIENT_ID ; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>GOOGLE_CLIENT_SECRET</h5>
                                        <div class="controls">
                                            <input type="text" name="gcs" value="<?php echo $GOOGLE_CLIENT_SECRET; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Tagmanager head</h5>
                                        <div class="controls">
                                            <textarea name="tagmanager_head" class="form-control" rows="5"> <?php echo $tagmanager_head; ?> </textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Tagmanager body</h5>
                                        <div class="controls">
                                            <textarea name="tagmanager_body" class="form-control" rows="5"> <?php echo $tagmanager_body; ?> </textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Titre site par défaut</h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo $titre_page; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                                                        
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Map</h5>
                                        <div class="controls">
                                            <textarea name="map" class="form-control" rows="3"><?php echo $map; ?></textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Footer</h5>
                                                <div class="controls">
                                                  <textarea id="editor1" name="texte_footer" class="form-control" rows="3"><?php echo $texte_footer; ?></textarea>
                                                </div>
                                            </div>
                                            <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                            <div class="form-group">
                                                <h5>Footer anglais</h5>
                                                <div class="controls">
                                                  <textarea id="editor11" name="texte_footeren" class="form-control" rows="3"><?php echo $texte_footeren; ?></textarea>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>                          
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Google analytics</h5>
                                        <div class="controls">
                                            <textarea name="analytics" class="form-control" rows="5"><?php echo $analytics; ?></textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Copyright backoffice</h5>
                                        <div class="controls">
                                            <input type="text" name="copyright_bo" value="<?php echo $copyright_bo; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Version</h5>
                                        <div class="controls">
                                            <input type="text" name="version" value="<?php echo $version; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Clé du site</h5>
                                        <div class="controls">
                                            <input type="text" name="cle" value="<?php echo $cle; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Clé secrète</h5>
                                        <div class="controls">
                                          <input type="text" name="secret" value="<?php echo $secret; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>  
                                    <?php } ?>
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Clé </h5>
                                        <div class="controls">
                                            <input type="text" name="key_api" value="<?php echo $key_api; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Portfeuille</h5>
                                        <div class="controls">
                                          <input type="text" name="wallet" value="<?php echo $wallet; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>URL paiement</h5>
                                        <div class="controls">
                                          <input type="text" name="url_payment" value="<?php echo $url_payment; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Copyright front office</h5>
                                        <div class="controls">
                                            <input type="text" name="copyright" value="<?php echo $copyright; ?>" class="form-control"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                             
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=setting'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
