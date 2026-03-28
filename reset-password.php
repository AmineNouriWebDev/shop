<?php
include("include.php");
$erreur = "";
if(isset($_POST['action']) && $_POST['action']=="reset" ){
  
  $turnstile_valid = true;
  if (!empty($cloudflare_secret_key)) {
      $turnstile_response = $_POST['cf-turnstile-response'] ?? '';
      $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
      $data_cf = [
          'secret' => $cloudflare_secret_key,
          'response' => $turnstile_response,
          'remoteip' => $_SERVER['REMOTE_ADDR']
      ];
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $verify_url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_cf));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($curl);
      curl_close($curl);
      $response_keys = json_decode($result, true);
      if(empty($response_keys) || empty($response_keys['success'])) {
          $turnstile_valid = false;
      }
  }

  if (!$turnstile_valid) {
      $erreur = "La vérification anti-spam a échoué. Veuillez réessayer.";
  } elseif($_POST['password'] == "" || $_POST['confirm_password'] == "") {
      $erreur ="Tous les champs sont obligatoires.";
  } elseif($_POST['password'] !== $_POST['confirm_password']) {
      $erreur = "Les mots de passe ne correspondent pas.";
  } else {
      $token_post = sanitize($_POST['token']);
      $email_post = sanitize($_POST['email']);
      $password = sanitize($_POST['password']);
      $mpc = md5($password);
      
      $req = "SELECT * FROM `clients` WHERE `email` = '".$email_post."' AND `confirm_key` = '".$token_post."'";
      $res = executeRequete($req);
      $data1 = mysqli_fetch_array($res);
      if($data1 && $data1['id'] != "" && $token_post != ""){
          $update_req = "UPDATE `clients` SET `password`='".$password."', `mpc`='".$mpc."', `confirm_key`='' WHERE `id`='".$data1['id']."'";
          executeRequete($update_req);
          
          $msg = "Votre mot de passe a été réinitialisé avec succès.";
          ?>
          <script language="javascript">
            alert('<?php echo addslashes($msg);?>');
            window.location = '<?php echo lienConnexion();?>';
          </script>
          <?php
          exit;
      } else {
          $erreur = "Le lien de réinitialisation est invalide ou a expiré.";
      }
  }
}

// Verification GET before displaying form
$valid_token = false;
$token = sanitize($_GET['token'] ?? $_POST['token'] ?? '');
$email_q = sanitize($_GET['email'] ?? $_POST['email'] ?? '');

if($token != "" && $email_q != "") {
    $req = "SELECT * FROM `clients` WHERE `email` = '".$email_q."' AND `confirm_key` = '".$token."'";
    $res = executeRequete($req);
    $data1 = mysqli_fetch_array($res);
    if($data1 && $data1['id'] != "") {
        $valid_token = true;
    } else {
        $erreur = "Ce lien de réinitialisation est invalide ou a déjà été utilisé.";
    }
} else {
    $erreur = "Lien de réinitialisation invalide ou introuvable.";
}
$requete = "SELECT * FROM `site_menu` WHERE `id` = '15'";
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
  <title><?php echo htmlspecialchars($title_page ?? 'Mot de passe oublié'); ?></title>
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
    /* ── Layout ────────────────────────────────── */
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
    .cx-label {
      display: block;
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--shop-text-secondary);
      margin-bottom: 0.375rem;
    }
    .cx-input {
      width: 100%;
      height: 44px;
      padding: 0 0.875rem;
      border: 1.5px solid var(--shop-border);
      border-radius: 0.75rem;
      background: var(--shop-bg-base);
      color: var(--shop-text-primary);
      font-size: 0.9rem;
      font-family: inherit;
      outline: none;
      transition: border-color 200ms ease, box-shadow 200ms ease;
      margin-bottom: 1.25rem;
    }
    .cx-input:focus {
      border-color: var(--shop-primary);
      box-shadow: 0 0 0 3px color-mix(in srgb, var(--shop-primary) 15%, transparent);
    }
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
    }
    .cx-btn:hover {
      background: var(--shop-primary-hover);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px color-mix(in srgb, var(--shop-primary) 35%, transparent);
    }
    .cx-footer-links {
      display: flex; align-items: center; justify-content: center;
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

    <?php include('includes/reset-password.php'); ?>
  </main>

  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>