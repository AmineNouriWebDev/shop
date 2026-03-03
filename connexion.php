<?php
session_start();
include("include.php");
require_once "User.class.php";

$requete  = "SELECT * FROM `site_menu` WHERE `id` = '13'";
$resultat = executeRequete($requete);
$data     = mysqli_fetch_array($resultat);
if ($data['id'] != "") {
    $id               = afficheChamp($data['id']);
    $titre            = afficheChamp($data['titre']);
    $contenu          = afficheChamp($data['contenu']);
    $description_page = afficheChamp($data['description']);
    $title_page       = afficheChamp($data['titre_page']);
    $keywords_page    = afficheChamp($data['keywords']);
} else {
    $url  = current_url();
    $date = timestampTD(date("d/m/Y H:i:s"));
    executeRequete("INSERT INTO `pages_introuvables`(`url_page`, `date`) VALUES ('" . $url . "','" . $date . "')");
    header('Location: /error404.html'); exit;
}

if (isset($_POST['action']) && $_POST['action'] == "login") {
    if ($_POST['login'] == "" || $_POST['password'] == "") {
        $erreur = "Les champs Adresse e-mail et mot de passe sont obligatoires.";
    } else {
        $login    = sanitize($_POST['login']);
        $password = sanitize($_POST['password']);
        $req      = "SELECT * FROM `clients` where `email` ='" . $login . "' AND `password`='" . $password . "'";
        $res      = executeRequete($req);
        $data1    = mysqli_fetch_array($res);
        if (isset($data1['id']) && $data1['id'] != "") {
            if ($data1['etat'] == 0) {
                $erreur = "Vous n'avez pas encore validé votre compte!";
            } else {
                $sess_id  = md5(microtime());
                $idclient = $data1['id'];
                $_SESSION['client_id']    = $data1['id'];
                $_SESSION['client_login'] = $data1['email'];
                $_SESSION['client_nom']   = $data1['nom'];
                $_SESSION['sess_id']      = $sess_id;
                executeRequete("UPDATE `clients` SET sess_id='" . $sess_id . "' WHERE id='" . $idclient . "'");
                $redir = (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart']) && count($_SESSION['panier']['idcart']) > 0)
                    ? lienPanier() : lienCompte();
                header('Location: ' . $redir); exit;
            }
        } else {
            $erreur = "Vos accès sont invalides! Merci de réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <?php include('includes/script_panier.php'); ?>
  <title><?php echo htmlspecialchars($title_page ?? 'Connexion'); ?></title>
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
      margin-bottom: 1rem;
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
    .cx-divider {
      display: flex; align-items: center; gap: 0.75rem;
      margin: 1.25rem 0;
      color: var(--shop-text-disabled);
      font-size: 0.8125rem;
    }
    .cx-divider::before, .cx-divider::after {
      content: ''; flex: 1; height: 1px; background: var(--shop-border);
    }
  </style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>

  <main class="cx-wrap">
    <div class="cx-card">

      <!-- Left: Promo -->
      <div class="cx-promo">
        <img src="media/site/<?php echo $logo; ?>" alt="" class="cx-promo-logo">
        <h2>Bienvenue dans votre espace client</h2>
        <p>Gérez vos commandes, suivez vos livraisons et accédez à vos offres exclusives.</p>
        <a href="<?php echo lienInscription(); ?>" class="cx-promo-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
          Créer un compte
        </a>
      </div>

      <!-- Right: Form -->
      <div class="cx-form-panel">
        <h1>Connexion</h1>
        <p class="cx-subtitle">Accédez à votre espace personnel</p>

        <?php if (isset($erreur) && $erreur): ?>
          <div class="cx-error"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <form action="<?php echo lienConnexion(); ?>" method="post">
          <label class="cx-label" for="cx-email">Adresse e-mail</label>
          <input class="cx-input" type="email" name="login" id="cx-email" placeholder="vous@email.com" required autocomplete="email">

          <label class="cx-label" for="cx-pass">Mot de passe</label>
          <input class="cx-input" type="password" name="password" id="cx-pass" placeholder="••••••••" required autocomplete="current-password">

          <input type="hidden" name="action" value="login">
          <button type="submit" class="cx-btn">Se connecter</button>
        </form>

        <div class="cx-footer-links">
          <a href="<?php echo lienforget(); ?>">Mot de passe oublié ?</a>
          <a href="<?php echo lienInscription(); ?>">Créer un compte →</a>
        </div>
      </div>

    </div>
  </main>

  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>