<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp_logo' ) {
		$requete = "SELECT * FROM `site_configuration`";
	    $resultat = executeRequete($requete);
	    $data = mysqli_fetch_array($resultat);
	     $image 	= afficheChamp($data['logo']);
	     if($image!="") unlink("../media/site/".$image);
          executeRequete("UPDATE `site_configuration` SET `logo`=''");
		  phpToastRedirect("Logo supprimé", 'index.php?r=setting', 'info');
} ?>
<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp_favicon' ) {
		$requete = "SELECT * FROM `site_configuration`";
	    $resultat = executeRequete($requete);
	    $data = mysqli_fetch_array($resultat);
	     $image 	= afficheChamp($data['favicon']);
	     if($image!="") unlink("../media/site/".$image);
          executeRequete("UPDATE `site_configuration` SET `favicon`=''");
		  phpToastRedirect("Favicon supprimé", 'index.php?r=setting', 'info');
} ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	// --- Auto DB Patch For Specific Missing Columns ---
	$columns_to_check = [
		"confiva_api_key" => "VARCHAR(255)"
	];
	foreach ($columns_to_check as $col => $sqlType) {
		$resCol = mysqli_query($connexion, "SHOW COLUMNS FROM `site_configuration` LIKE '$col'");
		if (mysqli_num_rows($resCol) === 0) {
			mysqli_query($connexion, "ALTER TABLE `site_configuration` ADD `$col` $sqlType");
		}
	}
	// ----------------------------------------------------
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
    $FACEBOOK_APP_ID         = formReception($_POST['fb_app_id'] ?? '');
    $FACEBOOK_APP_SECRET     = formReception($_POST['fb_app_secret'] ?? '');
    $google_login_enabled    = isset($_POST['google_login_enabled']) ? (int)$_POST['google_login_enabled'] : 0;
    $facebook_login_enabled  = isset($_POST['facebook_login_enabled']) ? (int)$_POST['facebook_login_enabled'] : 0;
    $cloudflare_site_key    = formReception($_POST['cloudflare_site_key'] ?? '');
    $cloudflare_secret_key  = formReception($_POST['cloudflare_secret_key'] ?? '');
    $confiva_api_key        = formReception($_POST['confiva_api_key'] ?? '');
    
	$cmd_num_sms 		= formReception($_POST['cmd_num_sms']);
	$cmd_num_whatsapp 	= formReception($_POST['cmd_num_whatsapp']);
	$message_cmd_sms 	= formReception($_POST['message_cmd_sms']);
	$message_cmd_whatsapp 	= formReception($_POST['message_cmd_whatsapp']);
	$lien_cmd_messenger 	= formReception($_POST['lien_cmd_messenger']);
	$message_cmd_messenger 	= formReception($_POST['message_cmd_messenger']);
    
    $key_api             = formReception($_POST['key_api']);	
    $wallet              = formReception($_POST['wallet']);	
    $url_payment         = formReception($_POST['url_payment']);
    $telegram_bot_token  = formReception($_POST['telegram_bot_token'] ?? '');
    $telegram_chat_id    = formReception($_POST['telegram_chat_id'] ?? '');
    $n8n_webhook_url     = formReception($_POST['n8n_webhook_url'] ?? '');
    $n8n_webhook_mailing = formReception($_POST['n8n_webhook_mailing'] ?? '');
    $google_search_console = formReception($_POST['google_search_console'] ?? '');
    $facebook_pixel      = formReception($_POST['facebook_pixel'] ?? '');
    $theme_color         = formReception($_POST['theme_color'] ?? '#ffffff');
    $matricule_fiscale   = formReception($_POST['matricule_fiscale'] ?? '');
    $rne                 = formReception($_POST['rne'] ?? '');
    $registre_commerce   = formReception($_POST['registre_commerce'] ?? '');
    $banque              = formReception($_POST['banque'] ?? '');
    $rib                 = formReception($_POST['rib'] ?? '');
    $swift               = formReception($_POST['swift'] ?? '');
    $code_douane         = formReception($_POST['code_douane'] ?? '');
    $developer_comment   = $_POST['developer_comment'] ?? ''; // Pas de formReception strict pour garder le formatage HTML
    $social_share_token  = formReception($_POST['social_share_token'] ?? '');
    
    
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
	`message_cmd_whatsapp` = "'. $message_cmd_whatsapp .'",`lien_cmd_messenger` = "'. $lien_cmd_messenger .'",	`secret` = "'. $secret .'",`GOOGLE_CLIENT_SECRET` = "'. $GOOGLE_CLIENT_SECRET .'",`GOOGLE_CLIENT_ID` = "'. $GOOGLE_CLIENT_ID .'",
	`FACEBOOK_APP_ID` = "'. $FACEBOOK_APP_ID .'", `FACEBOOK_APP_SECRET` = "'. $FACEBOOK_APP_SECRET .'",
	`google_login_enabled` = "'. $google_login_enabled .'", `facebook_login_enabled` = "'. $facebook_login_enabled .'",
	`cloudflare_site_key` = "'. $cloudflare_site_key .'", `cloudflare_secret_key` = "'. $cloudflare_secret_key .'",
	`telegram_bot_token` = "'. $telegram_bot_token .'", `telegram_chat_id` = "'. $telegram_chat_id .'", `n8n_webhook_url` = "'. $n8n_webhook_url .'", `n8n_webhook_mailing` = "'. $n8n_webhook_mailing .'",
	`matricule_fiscale` = "'.$matricule_fiscale.'", `rne` = "'.$rne.'", `registre_commerce` = "'.$registre_commerce.'", `banque` = "'.$banque.'",
	`rib` = "'.$rib.'", `swift` = "'.$swift.'", `code_douane` = "'.$code_douane.'",
	`google_search_console` = "'.$google_search_console.'", `facebook_pixel` = "'.$facebook_pixel.'", `theme_color` = "'.$theme_color.'", `developer_comment` = "'. mysqli_real_escape_string(ouvrirCnx(), $developer_comment) .'",
    `confiva_api_key` = "'. $confiva_api_key .'", `social_share_token` = "'.$social_share_token.'"';

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
            
            // Génération dynamique des icônes PWA au format WebP
            if (function_exists('generatePwaIcons')) {
                generatePwaIcons("../media/site/".$destination1, "../media/site/");
            }

			$requete = 'UPDATE `site_configuration` set `favicon`="'. $image .'"';
			$result = executeRequete($requete);	
		}
	}
	   
	
	$msg="Paramètres mis à jour avec succès.";
	phpToastRedirect($msg, 'index.php?r=setting', 'success');
}
?>
        <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774a1.125 1.125 0 0 1 .12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.894.15c.542.09.94.56.94 1.11v1.094c0 .55-.398 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738a1.125 1.125 0 0 1-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.45.12l-.737-.527c-.35-.25-.806-.272-1.204-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527a1.125 1.125 0 0 1-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.11v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.774-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.398-.165.71-.505.78-.929l.15-.894Z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Paramètres généraux du site
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Nom Site <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input type="text" name="nom_site" value="<?php echo $nom_site; ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Logo</label>
                                        <?php if($logo) { ?>
								         <div><img src="../media/site/<?php echo $logo; ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Favicon</label>
                                        <?php if($favicon) { ?>
								         <div><img src="../media/site/<?php echo $favicon; ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="image" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Activer SSL:</label>
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
                                        <label>Chemin absolu</label>
                                        <div class="controls">
                                            <input type="text" name="chemin_absolu" value="<?php echo $chemin_absolu; ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Email contact (Séparer les emails par des points virgules)</label>
                                        <div class="controls">
                                            <input type="text" name="email_contact" value="<?php echo $email_contact; ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <hr class="border-primary">
									<div class="admin-card-title mt-6 mb-4 text-lg">Commande contact</div>
									<div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>N° Commande SMS</label>
                                        <div class="controls">
                                            <input type="text" name="cmd_num_sms" value="<?php echo $cmd_num_sms; ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label>Messsage Commande SMS</label>
                                        <div class="controls">
                                            <textarea name="message_cmd_sms" class="admin-input" rows="5"> <?php echo $message_cmd_sms; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>N° Commande Whatsapp</label>
                                        <div class="controls">
                                            <input type="text" name="cmd_num_whatsapp" value="<?php echo $cmd_num_whatsapp; ?>" class="admin-input"> 
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label>Messsage Commande Whatsapp</label>
                                        <div class="controls">
                                            <textarea name="message_cmd_whatsapp" class="admin-input" rows="5"> <?php echo $message_cmd_whatsapp; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                    </div><div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Lien Commande Messenger</label>
                                        <div class="controls">
                                            <input type="text" name="lien_cmd_messenger" value="<?php echo $lien_cmd_messenger; ?>" class="admin-input"> 
                                        </div>
                                    </div> 
                                      <div class="form-group">
                                        <label>Messsage Commande Messenger</label>
                                        <div class="controls">
                                            <textarea name="message_cmd_messenger" class="admin-input" rows="5"> <?php echo $message_cmd_messenger; ?> </textarea>
                                        </div>
										</div>
                                     </div>
                                    </div>
									<hr class="border-primary">
                                    
                                    
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Téléphone</label>
                                        <div class="controls">
                                            <input type="text" name="tel" value="<?php echo $tel; ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>GSM</label>
                                        <div class="controls">
                                            <input type="text" name="gsm" value="<?php echo $gsm; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Fax</label>
                                        <div class="controls">
                                            <input type="text" name="fax" value="<?php echo $fax; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Whatsapp</label>
                                        <div class="controls">
                                            <input type="text" name="whatsapp" value="<?php echo $whatsapp; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Adresse email contact</label>
                                        <div class="controls">
                                            <input type="text" name="adresse_contact" value="<?php echo $adresse_contact; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <hr class="border-primary">
									<div class="admin-card-title mt-6 mb-4 text-lg">Mentions Légales Entreprise</div>
									<div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Matricule Fiscal</label>
                                        <div class="controls">
                                            <input type="text" name="matricule_fiscale" value="<?php echo htmlspecialchars($matricule_fiscale ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Identifiant Unique (RNE)</label>
                                        <div class="controls">
                                            <input type="text" name="rne" value="<?php echo htmlspecialchars($rne ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Registre de Commerce</label>
                                        <div class="controls">
                                            <input type="text" name="registre_commerce" value="<?php echo htmlspecialchars($registre_commerce ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Code Douane</label>
                                        <div class="controls">
                                            <input type="text" name="code_douane" value="<?php echo htmlspecialchars($code_douane ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Banque</label>
                                        <div class="controls">
                                            <input type="text" name="banque" value="<?php echo htmlspecialchars($banque ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>RIB / IBAN</label>
                                        <div class="controls">
                                            <input type="text" name="rib" value="<?php echo htmlspecialchars($rib ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Code SWIFT</label>
                                        <div class="controls">
                                            <input type="text" name="swift" value="<?php echo htmlspecialchars($swift ?? ''); ?>" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                    <hr class="border-primary">
                                    
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="form-group">
                                        <label>N° appel vocale</label>
                                        <div class="controls">
                                            <input type="text" name="stickyfooter_number" value="<?php echo $num_appel_vocale; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Vidéo</label>
                                        <div class="controls">
                                            <input type="text" name="video" value="<?php echo $video; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Adresse</label>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="<?php echo $adresse; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Longitude</label>
                                        <div class="controls">
                                            <input type="text" name="longitude" value="<?php echo $longitude; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Latitude</label>
                                        <div class="controls">
                                            <input type="text" name="latitude" value="<?php echo $latitude; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <hr class="border-primary">
                                    <div class="admin-card-title mt-6 mb-4 text-lg flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.25rem;height:1.25rem;color:var(--color-primary)">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                        </svg>
                                        Outils SEO & Tracking Global
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Code vérification Google Search Console</label>
                                                <p class="text-xs text-muted mb-1">Insérez unquement le code de la balise meta (ex: <code>AbcDefGhiJklMno</code>)</p>
                                                <input type="text" name="google_search_console" value="<?php echo htmlspecialchars($google_search_console ?? '', ENT_QUOTES); ?>" class="admin-input"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Google Analytics (Measurement ID)</label>
                                                <p class="text-xs text-muted mb-1">Ex: <code>G-XXXXXXXXXX</code> ou l'ancien mode <code>UA-XXXXX-Y</code></p>
                                                <input type="text" name="analytics" value="<?php echo htmlspecialchars($analytics ?? '', ENT_QUOTES); ?>" class="admin-input"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ID Facebook Pixel</label>
                                                <p class="text-xs text-muted mb-1">Insérez uniquement l'ID du pixel (ex: <code>123456789098765</code>)</p>
                                                <input type="text" name="facebook_pixel" value="<?php echo htmlspecialchars($facebook_pixel ?? '', ENT_QUOTES); ?>" class="admin-input"> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Couleur du Thème Mobile (PWA)</label>
                                                <p class="text-xs text-muted mb-1">Couleur primaire pour la barre de navigateur mobile (ex: <code>#1E3A8A</code>)</p>
                                                <div class="d-flex align-items-center">
                                                    <input type="color" name="theme_color" value="<?php echo htmlspecialchars($theme_color ?? '#ffffff', ENT_QUOTES); ?>" class="form-control" style="width:50px; height:38px; padding:2px; cursor:pointer;"> 
                                                    <span class="ml-2 font-mono text-sm"><?php echo htmlspecialchars($theme_color ?? '#ffffff', ENT_QUOTES); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Commentaire Développeur (Code Source)</label>
                                                <p class="text-xs text-muted mb-1">Ce texte sera inséré sous forme de commentaire HTML masqué au début du code source de votre site (balise <code>&lt;!-- --&gt;</code>).</p>
                                                <textarea name="developer_comment" class="form-control" rows="6" placeholder="<!--&#10;  Website Developer: Nom Prénom&#10;  Company: Mon Entreprise&#10;-->"><?php echo htmlspecialchars($developer_comment ?? '', ENT_QUOTES); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="border-primary">
                                    <div class="admin-card-title mt-6 mb-4 text-lg flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.25rem;height:1.25rem;color:var(--color-primary)">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z" />
                                        </svg>
                                        Connexion Sociale (OAuth)
                                    </div>
                                    <p class="text-sm mb-4" style="color:var(--color-text-secondary)">
                                        Activez la connexion via Google et/ou Facebook pour vos clients. Les boutons apparaîtront sur la page de connexion uniquement si le provider est activé ET que les clés API sont renseignées.
                                    </p>

                                    <!-- ── GOOGLE ── -->
                                    <div class="admin-card mb-4" style="border:1px solid var(--color-border); box-shadow:none">
                                        <div class="admin-card-header" style="background:linear-gradient(135deg,#fff 0%,#f8f0ff 100%)">
                                            <div class="admin-card-title flex items-center gap-2" style="font-size:1rem">
                                                <!-- Google logo SVG -->
                                                <svg viewBox="0 0 48 48" style="width:1.25rem;height:1.25rem;flex-shrink:0">
                                                  <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C35.9 2.5 30.3 0 24 0 14.6 0 6.6 5.5 2.7 13.5l7.8 6.1C12.4 13.1 17.7 9.5 24 9.5z"/>
                                                  <path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.7c-.5 3-2.2 5.5-4.7 7.2l7.3 5.7c4.3-3.9 6.7-9.7 6.7-16.4-.1-.1-.5-.5-.5-.5z"/>
                                                  <path fill="#FBBC05" d="M10.5 28.4A14.3 14.3 0 0 1 9.5 24a14.3 14.3 0 0 1 1-4.4l-7.8-6.1A23.9 23.9 0 0 0 0 24c0 3.9.9 7.6 2.7 10.9l7.8-6.5z"/>
                                                  <path fill="#34A853" d="M24 48c6.3 0 11.6-2.1 15.4-5.7l-7.3-5.7c-2.1 1.4-4.8 2.2-8.1 2.2-6.3 0-11.6-3.6-13.5-9.4l-7.8 6.1C6.6 42.5 14.6 48 24 48z"/>
                                                  <path fill="none" d="M0 0h48v48H0z"/>
                                                </svg>
                                                Google Login
                                            </div>
                                        </div>
                                        <div class="admin-card-body">
                                            <div class="form-group">
                                                <label>Activer la connexion Google</label>
                                                <div class="admin-toggle-group mt-1">
                                                    <div class="admin-toggle-item">
                                                        <input type="radio" name="google_login_enabled" id="google_on" value="1" <?php if(!empty($google_login_enabled) && $google_login_enabled == 1) echo 'checked'; ?>>
                                                        <label for="google_on" class="admin-toggle-label">Oui</label>
                                                    </div>
                                                    <div class="admin-toggle-item">
                                                        <input type="radio" name="google_login_enabled" id="google_off" value="0" <?php if(empty($google_login_enabled) || $google_login_enabled == 0) echo 'checked'; ?>>
                                                        <label for="google_off" class="admin-toggle-label">Non</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Google Client ID</label>
                                                        <div class="controls">
                                                            <input type="text" name="gcid" value="<?php echo htmlspecialchars($GOOGLE_CLIENT_ID ?? ''); ?>" class="admin-input" placeholder="xxxxxxx.apps.googleusercontent.com">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Google Client Secret</label>
                                                        <div class="controls">
                                                            <input type="password" name="gcs" value="<?php echo htmlspecialchars($GOOGLE_CLIENT_SECRET ?? ''); ?>" class="admin-input" placeholder="GOCSPX-...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 p-3 rounded-lg text-sm" style="background:color-mix(in srgb,var(--color-primary) 8%,transparent); border:1px solid color-mix(in srgb,var(--color-primary) 20%,transparent)">
                                                <strong>URI de redirection à enregistrer dans Google Cloud Console :</strong><br>
                                                <code class="text-xs" style="word-break:break-all"><?php
                                                    $is_local = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost','127.0.0.1']);
                                                    $base_oauth = $is_local ? 'http://localhost/shop' : rtrim($chemin_absolu ?? '', '/');
                                                    echo htmlspecialchars($base_oauth . '/oauth-callback.php?provider=google');
                                                ?></code>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ── FACEBOOK ── -->
                                    <div class="admin-card mb-4" style="border:1px solid var(--color-border); box-shadow:none">
                                        <div class="admin-card-header" style="background:linear-gradient(135deg,#fff 0%,#eef3ff 100%)">
                                            <div class="admin-card-title flex items-center gap-2" style="font-size:1rem">
                                                <!-- Facebook logo SVG -->
                                                <svg viewBox="0 0 48 48" style="width:1.25rem;height:1.25rem;flex-shrink:0">
                                                  <path fill="#1877F2" d="M48 24C48 10.7 37.3 0 24 0S0 10.7 0 24c0 12 8.8 21.9 20.2 23.7V30.9h-6.1V24h6.1v-5.3c0-6 3.6-9.3 9-9.3 2.6 0 5.3.5 5.3.5v5.8h-3c-2.9 0-3.8 1.8-3.8 3.7V24h6.5l-1 6.9h-5.4V47.7C39.2 45.9 48 36 48 24z"/>
                                                  <path fill="#fff" d="M33.3 30.9l1-6.9h-6.5v-4.4c0-1.9.9-3.7 3.8-3.7h3v-5.8s-2.7-.5-5.3-.5c-5.4 0-9 3.3-9 9.3V24h-6.1v6.9h6.1v16.8c1.2.2 2.5.3 3.7.3 1.3 0 2.5-.1 3.7-.3V30.9h5.6z"/>
                                                </svg>
                                                Facebook Login
                                            </div>
                                        </div>
                                        <div class="admin-card-body">
                                            <div class="form-group">
                                                <label>Activer la connexion Facebook</label>
                                                <div class="admin-toggle-group mt-1">
                                                    <div class="admin-toggle-item">
                                                        <input type="radio" name="facebook_login_enabled" id="fb_on" value="1" <?php if(!empty($facebook_login_enabled) && $facebook_login_enabled == 1) echo 'checked'; ?>>
                                                        <label for="fb_on" class="admin-toggle-label">Oui</label>
                                                    </div>
                                                    <div class="admin-toggle-item">
                                                        <input type="radio" name="facebook_login_enabled" id="fb_off" value="0" <?php if(empty($facebook_login_enabled) || $facebook_login_enabled == 0) echo 'checked'; ?>>
                                                        <label for="fb_off" class="admin-toggle-label">Non</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Facebook App ID</label>
                                                        <div class="controls">
                                                            <input type="text" name="fb_app_id" value="<?php echo htmlspecialchars($FACEBOOK_APP_ID ?? ''); ?>" class="admin-input" placeholder="1234567890123456">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Facebook App Secret</label>
                                                        <div class="controls">
                                                            <input type="password" name="fb_app_secret" value="<?php echo htmlspecialchars($FACEBOOK_APP_SECRET ?? ''); ?>" class="admin-input" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxx">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 p-3 rounded-lg text-sm" style="background:color-mix(in srgb,#1877F2 8%,transparent); border:1px solid color-mix(in srgb,#1877F2 20%,transparent)">
                                                <strong>URI de redirection à enregistrer dans Facebook Developers :</strong><br>
                                                <code class="text-xs" style="word-break:break-all"><?php echo htmlspecialchars($base_oauth . '/oauth-callback.php?provider=facebook'); ?></code>
                                            </div>
                                        </div>
                                    </div>


                                    <hr class="border-primary">
                                    <div class="admin-card-title mt-6 mb-4 text-lg">Cloudflare Turnstile (Anti-Spam)</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Site Key</label>
                                                <div class="controls">
                                                    <input type="text" name="cloudflare_site_key" value="<?php echo $cloudflare_site_key ?? ''; ?>" class="admin-input" placeholder="1x000... (Clé de site)"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Secret Key</label>
                                                <div class="controls">
                                                    <input type="text" name="cloudflare_secret_key" value="<?php echo $cloudflare_secret_key ?? ''; ?>" class="admin-input" placeholder="1x000... (Clé secrète)"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="border-primary">
                                    <div class="admin-card-title mt-6 mb-4 text-lg">Confiva Logistics (Livraison)</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Clé API d'accès unique</label>
                                                <div class="controls">
                                                    <input type="text" name="confiva_api_key" value="<?php echo $confiva_api_key ?? ''; ?>" class="admin-input" placeholder="Collez votre clé API Confiva ici">
                                                    <small class="text-muted text-xs mt-1">Nécessaire pour l'envoi automatique des colis de commande.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="border-primary">
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Tagmanager head</label>
                                        <div class="controls">
                                            <textarea name="tagmanager_head" class="admin-input" rows="5"> <?php echo $tagmanager_head; ?> </textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Tagmanager body</label>
                                        <div class="controls">
                                            <textarea name="tagmanager_body" class="admin-input" rows="5"> <?php echo $tagmanager_body; ?> </textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Titre site par défaut</label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo $titre_page; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                                                        
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Map</label>
                                        <div class="controls">
                                            <textarea name="map" class="admin-input" rows="3"><?php echo $map; ?></textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Footer</label>
                                                <div class="controls">
                                                  <textarea id="editor1" name="texte_footer" class="admin-input" rows="3"><?php echo $texte_footer; ?></textarea>
                                                </div>
                                            </div>
                                            <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                            <div class="form-group">
                                                <label>Footer anglais</label>
                                                <div class="controls">
                                                  <textarea id="editor11" name="texte_footeren" class="admin-input" rows="3"><?php echo $texte_footeren; ?></textarea>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>                          
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Google analytics</label>
                                        <div class="controls">
                                            <textarea name="analytics" class="admin-input" rows="5"><?php echo $analytics; ?></textarea></div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Copyright backoffice</label>
                                        <div class="controls">
                                            <input type="text" name="copyright_bo" value="<?php echo $copyright_bo; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Version</label>
                                        <div class="controls">
                                            <input type="text" name="version" value="<?php echo $version; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Clé du site</label>
                                        <div class="controls">
                                            <input type="text" name="cle" value="<?php echo $cle; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Clé secrète</label>
                                        <div class="controls">
                                          <input type="text" name="secret" value="<?php echo $secret; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>  
                                    <?php } ?>
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Clé </label>
                                        <div class="controls">
                                            <input type="text" name="key_api" value="<?php echo $key_api; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Portfeuille</label>
                                        <div class="controls">
                                          <input type="text" name="wallet" value="<?php echo $wallet; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                     <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <label>URL paiement</label>
                                        <div class="controls">
                                          <input type="text" name="url_payment" value="<?php echo $url_payment; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Copyright front office</label>
                                        <div class="controls">
                                            <input type="text" name="copyright" value="<?php echo $copyright; ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div> 
                                             

                                    <hr class="border-primary">
									<div class="admin-card-title mt-6 mb-4 text-lg">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;display:inline;vertical-align:middle;color:var(--color-primary);margin-right:6px;">
											<path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2Zm4.928 7.279-1.666 7.85c-.123.55-.452.685-.916.426l-2.5-1.843-1.207 1.161c-.133.132-.245.244-.5.244l.178-2.527 4.6-4.158c.2-.178-.043-.276-.307-.098l-5.685 3.58-2.45-.763c-.533-.167-.543-.534.112-.789l9.558-3.688c.443-.16.83.109.683.505Z"/>
										</svg>
										Notifications Telegram &amp; n8n
									</div>
                                    <div style="background:color-mix(in srgb, var(--color-primary) 5%, transparent); border:1px dashed color-mix(in srgb, var(--color-primary) 40%, transparent); border-radius:0.75rem; padding:1rem 1.25rem; margin-bottom:1.5rem; font-size:0.85rem; color:var(--color-text-secondary);">
                                        <strong>Configuration step-by-step :</strong><br>
                                        1. <strong>Créer un bot</strong> sur Telegram → parler à <code>@BotFather</code>, taper <code>/newbot</code> et copier le Token.<br>
                                        2. <strong>Obtenir votre Chat ID</strong> → parler à <code>@userinfobot</code> et copier l'ID.<br>
                                        3. <strong>N8N (optionnel) :</strong> importer le fichier <code>n8n_telegram_workflow.json</code> puis activer le workflow et copier son URL de webhook ici.
                                    </div>
									<div class="row">
									 <div class="col-md-6">
									  <div class="form-group">
										<label>Token du Bot Telegram <small style="color:var(--color-text-muted)">(ex: 123456:ABC-DEF...)</small></label>
										<div class="controls">
											<input type="text" name="telegram_bot_token" value="<?php echo htmlspecialchars($telegram_bot_token ?? ''); ?>" class="admin-input" placeholder="123456789:AAFsxPVV...">
										</div>
									  </div>
									 </div>
									 <div class="col-md-6">
									  <div class="form-group">
										<label>Chat ID Telegram <small style="color:var(--color-text-muted)">(votre identifiant)</small></label>
										<div class="controls">
											<input type="text" name="telegram_chat_id" value="<?php echo htmlspecialchars($telegram_chat_id ?? ''); ?>" class="admin-input" placeholder="-100123456789">
										</div>
									  </div>
									 </div>
									</div>
									<div class="row">
									 <div class="col-md-12">
									  <div class="form-group">
										<label>URL Webhook n8n <small style="color:var(--color-text-muted)">(Commandes)</small></label>
										<div class="controls">
											<input type="text" name="n8n_webhook_url" value="<?php echo htmlspecialchars($n8n_webhook_url ?? ''); ?>" class="admin-input" placeholder="https://votre-n8n.com/webhook/offipro-new-order">
										</div>
									  </div>
									 </div>
									</div>
									<div class="row">
									 <div class="col-md-12">
									  <div class="form-group">
										<label>URL Webhook n8n Mailing <small style="color:var(--color-text-muted)">(Gestion des emails client)</small></label>
										<div class="controls">
											<input type="text" name="n8n_webhook_mailing" value="<?php echo htmlspecialchars($n8n_webhook_mailing ?? ''); ?>" class="admin-input" placeholder="https://votre-n8n.com/webhook/facb5... (vide = désactivé)">
										</div>
									  </div>
									 </div>
									</div>

                                    <hr class="border-primary">
                                    <div class="admin-card-title mt-6 mb-4 text-lg flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.25rem;height:1.25rem;color:var(--color-primary)">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                        </svg>
                                        Configuration Partage Réseaux Sociaux
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Token / Scripts de partage</label>
                                                <p class="text-xs text-muted mb-1">Si vous avez des tokens ou des configurations de partage pour vos réseaux sociaux, collez-les ici.</p>
                                                <div class="controls">
                                                    <textarea name="social_share_token" class="admin-input" rows="4"><?php echo htmlspecialchars($social_share_token ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=setting'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

