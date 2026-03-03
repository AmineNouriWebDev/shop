<?php

	session_start();


	include("include.php");


        $Request = 'SELECT * FROM `site_menu` WHERE `id` = "21" AND `etat` = "1" ';
		
    	$Result  = executeRequete($Request) ;
		
    	$Datum = mysqli_fetch_array($Result);
    	
    if($Datum['id'] !='' ){
    
    	if ($Datum['titre_page'] != '') { $title_page = afficheChamp($Datum['titre_page']);}
		
    	if ($Datum['keywords'] != '') 	{ $keywords_page = afficheChamp($Datum['keywords']);}
		
    	if ($Datum['description'] != '') { $description_page = afficheChamp($Datum['description']);}
		
        $contenu = afficheChamp($Datum['contenu']);
		
    	$titre   = afficheChamp($Datum['titre']);
		
    	$id = $Datum['id'];
    	
        $img=afficheChamp($Datum['image']);
        
        $img_entete = photoPageSite($id);
    	
    	
	    $variable2='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
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
<?php

                
if(isset($_GET['cmd'])){
                    
    $cmd = $_GET['cmd'];
                
        $requete = 'SELECT * FROM `commandes` WHERE `id` = "'.$cmd.'"  AND `idclient` = "'.$_SESSION['client_id'].'"';
        $result = executeRequete($requete);
        $num  = mysqli_num_rows($result);
        if($num) {
            
            $datacmd  = mysqli_fetch_array($result);
            $moyen_paiement = afficheChamp($datacmd['moyen_paiement']);
            $code_envoi = afficheChamp($datacmd['code_envoi']);
            $req = "SELECT * FROM `commandes` WHERE `code_envoi` = '".$code_envoi."'";
            $res = executeRequete($req);
            $datac = mysqli_fetch_array($res);
            if(isset($datac['id']) && $datac['id']!=""){
                $idc=$datac['id'];
                $ref_paiement=referencePaiementCommande($idc);
                $montant_total=totalCommandeNumerique($idc);
                $nomclient=nomClient(idclientCommande($idc));
                $prenomclient=prenomClient(idclientCommande($idc));
                $emailclient=emailClient(idclientCommande($idc));
                $telclient=telClient(idclientCommande($idc));
                $descriptioncommande=detailsURLCommande($idc);
            }
            

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <?php include('includes/script_panier.php'); ?>
  <title><?php echo htmlspecialchars($title_page ?? 'Confirmation de commande'); ?></title>
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
    .cx-wrap {
      flex: 1; display: flex; align-items: center; justify-content: center;
      padding: 3rem 1rem;
    }
    .cx-card {
      width: 100%; max-width: 600px;
      background: var(--shop-surface);
      border: 1px solid var(--shop-border, #E0DEFF);
      border-radius: 1.5rem;
      padding: 3rem 2.5rem;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0,0,0,.08);
    }
    html.dark .cx-card {
      background: var(--shop-surface, #1e1e2d);
      border-color: var(--shop-border, #323248);
    }
    .cx-icon-wrapper {
      width: 80px; height: 80px;
      margin: 0 auto 1.5rem;
      background: color-mix(in srgb, #22c55e 15%, transparent);
      color: #16a34a;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
    }
    .cx-icon-wrapper svg { width: 40px; height: 40px; }
    .cx-card h1 {
      font-size: 1.5rem; font-weight: 700;
      margin: 0 0 1rem; color: var(--shop-text-primary);
    }
    .cx-card p {
      font-size: 1rem; color: var(--shop-text-secondary);
      line-height: 1.6; margin: 0 0 2rem;
    }
    .cx-btn {
      display: inline-flex; justify-content: center; align-items: center;
      padding: 0.75rem 1.5rem;
      background: var(--shop-primary); color: white;
      border-radius: 0.875rem; font-weight: 600; text-decoration: none;
      transition: all 200ms ease;
    }
    .cx-btn:hover {
      background: var(--shop-primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px color-mix(in srgb, var(--shop-primary) 35%, transparent);
      color: white; text-decoration: none;
    }
  </style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>

  <main class="cx-wrap">
    <div class="cx-card">
      <div class="cx-icon-wrapper">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <h1>Commande confirmée !</h1>
      <p>
        <?php echo strip_tags($contenu); ?>
      </p>
      <a href="<?php echo lienCompte(); ?>" class="cx-btn">Voir mes commandes</a>
    </div>
  </main>

  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>
<?php 
}else{
    ?>
    <script>
        alert('Opération réfusée!')
        window.location='<?php echo lienCompte(); ?>';
    </script>
    <?php
}
}

?>