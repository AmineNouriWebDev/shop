<?php

	//session_start();
	include("include.php");
	
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '14'";
    //echo $requete;
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if($data['id']!=""){
        $id=afficheChamp($data['id']);
        $titre=afficheChamp($data['titre']);		        
        $contenu=afficheChamp($data['contenu']);
        $description_page=afficheChamp($data['description']);
        $title_page=afficheChamp($data['titre_page']);
        $keywords_page=afficheChamp($data['keywords']);


    }else{
        $url = current_url();
        $date = timestampTD(date("d/m/Y H:i:s"));
        executeRequete("INSERT INTO `pages_introuvables`(`url_page`, `date`) VALUES ('".$url."','".$date."')");
        ?>
	<script language="javascript">
	<!--
		window.location = '/error404.html';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
    }

	if(isset($_POST['action']) && $_POST['action']=="add" ){



		$nom=sanitize($_POST['nom']);
		
		$prenom=sanitize($_POST['prenom']);

		$email=sanitize($_POST['email']);

		$tel=sanitize($_POST['phone']);

		$password=sanitize($_POST['password']);

		$confirm_password=sanitize($_POST['confirm_password']);

		//exit;

		if($password!=$confirm_password){ // mot de passe non identiques erreur

			$erreur="Les mot de passe et sa confirmation ne sont pas identiques!";

		}else
		{ // mots de passes identiques c'est ok

			$req="SELECT * FROM `clients` where `email` ='".$email."'";    

			$res=executeRequete($req);

			$data1 = mysqli_fetch_array($res);

			if(isset($data1['id']) && $data1['id']!=""){ // compte existe avec l'adresse email 

			  $erreur="Un compte existe déjà avec cette adresse e-mail!";

			}

			else{ // inscription

			  $date_creation=time();

			  $confirm_key=random(40);

			  $req="INSERT INTO `clients`(`nom`,`prenom`,`email`,`tel`,`password`,`date_creation`,`etat`) VALUES('".$nom."','".$prenom."','".$email."','".$tel."','".$password."','".$date_creation."','1')";

      //echo $req; exit;

			  executeRequete($req);
			  global $connexion;
			  $new_id = mysqli_insert_id($connexion);

			  // envoi email
            $email_contacts = explode(';',$email_contact);
            
		    foreach($email_contacts as $emc){
		        
			  $headers  = 'MIME-Version: 1.0' . "\r\n";

			  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			  $headers .= 'From: '.$nomSite.' <'.$emc.'>'. "\r\n";


			  $clientmail=$prenom." ".$nom;

			  $sujetmail=sujetEmail(4);

			  $linkconfirm=lienConfirminscription($confirm_key);

			  $messagemail=str_replace("%%NOMCLT%%",$clientmail,messageEmail(4));

			  //$messagemail=str_replace("%%LINKCONFIRM%%",$linkconfirm,$messagemail);
            
              if ($_SERVER['SERVER_NAME'] != 'localhost') {
			      @mail($email, $sujetmail, $messagemail, $headers, "-f ".$emc."");
              }
            

			  $sujetmailadmin=sujetEmail(7);

			  $detailsclt="Nom :".$prenom." ".$nom."<br />";

			  $detailsclt.="Tél :".$tel."<br />";

			  $detailsclt.="E-mail :".$email."<br />";

			  $messagemailadmin=str_replace("%%DETAILSCLT%%",$detailsclt,messageEmail(7));
		        
		        // Alerte client 
		    

              if ($_SERVER['SERVER_NAME'] != 'localhost') {
			      @mail($emc, $sujetmailadmin, $messagemailadmin, $headers, "-f ".$emc."");
              }

		    }



              $sess_id = md5(microtime());
              
              // Update sess_id in DB
              $strSQL1 = "UPDATE `clients` SET sess_id='".$sess_id."' WHERE id='".$new_id."'";
              executeRequete($strSQL1);

              // Set SESSION variables (Auto-login)
              $_SESSION['client_id'] = $new_id; 
              $_SESSION['client_login'] = $email;
              $_SESSION['client_nom'] = $nom;
              $_SESSION['sess_id'] = $sess_id;
              
              // Redirect
              ?>
                <script language="javascript">
                  window.location = '<?php echo lienCompte();?>';
                </script>
              <?php
              exit;


			}

		}

	}
	?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <?php include('includes/script_panier.php'); ?>
  <title><?php echo htmlspecialchars($title_page ?? 'Inscription'); ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--shop-bg-base);
      color: var(--shop-text-primary);
      min-height: 100vh;
      display: flex; flex-direction: column;
    }
    /* ── Login Layout ────────────────────────────────── */
    .cx-wrap {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }
    .cx-card {
      width: 100%;
      max-width: 900px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,.12);
    }
    @media (max-width: 640px) { .cx-card { grid-template-columns: 1fr; } }

    /* ── Left promo panel ────────────────────────────── */
    .cx-promo {
      background: linear-gradient(145deg, #3B1FA0 0%, var(--shop-primary, #5A31F4) 50%, #7B52F4 100%);
      padding: 3rem 2rem;
      display: flex; flex-direction: column;
      align-items: flex-start; justify-content: center;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .cx-promo::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(255,255,255,.06);
    }
    .cx-promo::after {
      content: '';
      position: absolute;
      bottom: -40px; left: -40px;
      width: 170px; height: 170px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
    }
    .cx-promo-logo { max-height: 40px; margin-bottom: 2rem; filter: brightness(0) invert(1); }
    .cx-promo h2 { font-size: 1.5rem; font-weight: 700; margin: 0 0 0.75rem; line-height: 1.3; }
    .cx-promo p  { font-size: 0.9rem; opacity: 0.85; margin: 0 0 2rem; line-height: 1.6; }
    .cx-promo-btn {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.625rem 1.25rem;
      background: rgba(255,255,255,.18);
      border: 1.5px solid rgba(255,255,255,.35);
      border-radius: 0.875rem;
      color: white;
      font-size: 0.875rem;
      font-weight: 600;
      text-decoration: none;
      backdrop-filter: blur(8px);
      transition: background 200ms ease;
    }
    .cx-promo-btn:hover { background: rgba(255,255,255,.28); color: white; text-decoration: none; }
    @media (max-width: 640px) { .cx-promo { padding: 2rem 1.5rem; } }

    /* ── Right form panel ────────────────────────────── */
    .cx-form-panel {
      background: var(--shop-surface);
      padding: 2.5rem 2.5rem;
      display: flex; flex-direction: column; justify-content: center;
    }
    @media (max-width: 640px) { .cx-form-panel { padding: 2rem 1.5rem; } }
    .cx-form-panel h1 {
      font-size: 1.375rem; font-weight: 700;
      margin: 0 0 0.375rem;
      color: var(--shop-text-primary);
    }
    .cx-subtitle { font-size: 0.875rem; color: var(--shop-text-secondary); margin: 0 0 2rem; }
    .cx-error {
      padding: 0.75rem 1rem;
      background: color-mix(in srgb, #ef4444 10%, transparent);
      border: 1px solid color-mix(in srgb, #ef4444 30%, transparent);
      border-radius: 0.75rem;
      color: #dc2626;
      font-size: 0.875rem;
      margin-bottom: 1.25rem;
    }
    .cx-success {
      padding: 0.75rem 1rem;
      background: color-mix(in srgb, #22c55e 10%, transparent);
      border: 1px solid color-mix(in srgb, #22c55e 30%, transparent);
      border-radius: 0.75rem;
      color: #16a34a;
      font-size: 0.875rem;
      margin-bottom: 1.25rem;
    }    
    .cx-label {
      display: block;
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--shop-text-secondary);
      margin-bottom: 0.375rem;
    }
    /* Base surface for panels */
    .cx-surface { background: var(--shop-surface, #fff); border-color: var(--shop-border, #E0DEFF) !important; color: var(--shop-text-primary, #120B2E); }
    .cx-border { border-color: var(--shop-border, #E0DEFF) !important; }

    /* Dark Mode Overrides */
    html.dark .cx-surface { background: var(--shop-surface, #1e1e2d); border-color: var(--shop-border, #323248) !important; color: var(--shop-text-primary, #ffffff); }
    html.dark .cx-border { border-color: var(--shop-border, #323248) !important; }
    
    .cx-input {
      width: 100%;
      height: 44px;
      padding: 0 0.875rem;
      border: 1.5px solid var(--shop-border, #E0DEFF);
      border-radius: 0.75rem;
      background: var(--shop-bg-base);
      color: var(--shop-text-primary);
      font-size: 0.9rem;
      font-family: inherit;
      outline: none;
      transition: border-color 200ms ease, box-shadow 200ms ease;
      margin-bottom: 1rem;
    }
    
    html.dark .cx-input { border-color: var(--shop-border, #323248); }
    .cx-input:focus {
      border-color: var(--shop-primary);
      box-shadow: 0 0 0 3px color-mix(in srgb, var(--shop-primary) 15%, transparent);
    }
    
    /* Grid layout for inputs */
    .cx-input-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
    }
    @media (max-width: 480px) { .cx-input-row { grid-template-columns: 1fr; gap: 0; } }
    
    .cx-btn {
      width: 100%;
      height: 46px;
      background: var(--shop-primary);
      color: white;
      border: none;
      border-radius: 0.875rem;
      font-size: 0.9375rem;
      font-weight: 700;
      cursor: pointer;
      font-family: inherit;
      transition: background 200ms ease, transform 150ms ease, box-shadow 200ms ease;
      margin-top: 0.25rem;
    }
    .cx-btn:hover {
      background: var(--shop-primary-hover);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px color-mix(in srgb, var(--shop-primary) 35%, transparent);
    }
    .cx-footer-links {
      display: flex; align-items: center; justify-content: space-between;
      margin-top: 1.25rem;
      font-size: 0.8125rem;
    }
    .cx-footer-links a { color: var(--shop-primary); text-decoration: none; font-weight: 500; }
    .cx-footer-links a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>

  <main class="cx-wrap">
    <div class="cx-card">

      <!-- Left: Promo -->
      <div class="cx-promo" style="flex-direction: column-reverse; justify-content: center; padding-top: 2rem;">
        <img src="media/site/<?php echo $logo; ?>" alt="" class="cx-promo-logo" style="margin-bottom: 0; margin-top: 2rem;">
        <div>
            <h2>Avez-vous déjà un compte ?</h2>
            <p>Connectez-vous pour profiter d'un paiement encore plus rapide et suivre vos commandes.</p>
            <a href="<?php echo lienConnexion(); ?>" class="cx-promo-btn">
              Se connecter →
            </a>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="cx-form-panel">
        <h1>Créer un compte</h1>
        <p class="cx-subtitle">Remplissez les informations ci-dessous</p>

        <?php if (isset($erreur) && $erreur): ?>
          <div class="cx-error"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <?php if (isset($success_msg) && $success_msg): ?>
          <div class="cx-success"><?php echo $success_msg; ?> <br><a href="<?php echo lienConnexion(); ?>" style="color: inherit; font-weight: bold;">Cliquez ici pour vous connecter.</a></div>
        <?php endif; ?>

        <form action="<?php echo lienInscription(); ?>" method="post">
          <div class="cx-input-row">
              <div>
                  <label class="cx-label" for="cx-nom">Nom</label>
                  <input class="cx-input" type="text" name="nom" id="cx-nom" placeholder="Votre nom" required>
              </div>
              <div>
                  <label class="cx-label" for="cx-prenom">Prénom</label>
                  <input class="cx-input" type="text" name="prenom" id="cx-prenom" placeholder="Votre prénom" required>
              </div>
          </div>
          
          <div class="cx-input-row">
              <div>
                  <label class="cx-label" for="cx-email">Email</label>
                  <input class="cx-input" type="email" name="email" id="cx-email" placeholder="Mail" required>
              </div>
              <div>
                  <label class="cx-label" for="cx-tel">Téléphone</label>
                  <input class="cx-input" type="text" name="phone" id="cx-tel" placeholder="Tél" required>
              </div>
          </div>

          <label class="cx-label" for="cx-pass">Mot de passe</label>
          <input class="cx-input" type="password" name="password" id="cx-pass" placeholder="••••••••" required>

          <label class="cx-label" for="cx-confirm">Confirmer mot de passe</label>
          <input class="cx-input" type="password" name="confirm_password" id="cx-confirm" placeholder="••••••••" required>

          <input type="hidden" name="action" value="add">
          <button type="submit" class="cx-btn">S'inscrire</button>
        </form>

        <div class="cx-footer-links" style="justify-content: center;">
          <a href="<?php echo lienforget(); ?>">Mot de passe oublié ?</a>
        </div>
      </div>

    </div>
  </main>

  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>