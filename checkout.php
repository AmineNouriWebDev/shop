<?php

	session_start();
	include("include.php");
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '10'";
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


    }
?>
<?php 
if(isset($_SESSION['client_id'])) {
	
	$id_client = $_SESSION['client_id'];
	
	?>
<!DOCTYPE html>

<html lang="en">

<head>
	<?php include('includes/script-header.php');?>
    <?php include('includes/script_panier.php');?>
    <style>
      *, *::before, *::after{box-sizing:border-box;} 
      body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);min-height:100vh;display:flex;flex-direction:column;}
      
      .cx-wrap { flex:1; padding: 3rem 1rem; width: 100%; max-width: 1400px; margin: 0 auto; }
      .cx-surface { background: var(--shop-surface); }
      .cx-border { border: 1px solid var(--shop-border, #E0DEFF); }
      html.dark .cx-border { border-color: var(--shop-border, #323248); }

      /* Inputs */
      .cx-input {
        width: 100%; padding: 0.75rem 1rem;
        background: var(--shop-bg-base);
        border: 1.5px solid var(--shop-border, #cbd5e1);
        border-radius: 0.875rem;
        color: var(--shop-text-primary);
        font-family: inherit; font-size: 0.9375rem;
        transition: all 200ms ease;
      }
      .cx-input:focus { outline: none; border-color: var(--shop-primary); box-shadow: 0 0 0 4px color-mix(in srgb, var(--shop-primary) 15%, transparent); }
      html.dark .cx-input { background: color-mix(in srgb, var(--shop-surface) 60%, black); border-color: var(--shop-border, #3f3f4e); }

      /* Buttons */
      .cx-btn {
        display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        background: var(--shop-primary); color: white;
        border: none; border-radius: 0.875rem;
        font-weight: 600; font-size: 0.9375rem; cursor: pointer;
        transition: all 200ms ease;
      }
      .cx-btn:hover { background: var(--shop-primary-hover); transform: translateY(-2px); box-shadow: 0 6px 20px color-mix(in srgb, var(--shop-primary) 35%, transparent); color: white; }
    </style>
</head>

<body>
	<?php include('includes/feedback.php');?>
	<?php include('includes/header-tw.php');?>
	
	<?php 
	$titre = str_ireplace('Technoplus.tn', $nomSite ?? 'notre boutique', titrePage(10));
	$variable2='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
	// include('includes/breadcrumb.php');
	
	?>
    <main class="cx-wrap">
    <?php 
        include("includes/checkout.php");
    ?>
    </main>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer-tw.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>
<?php } else { ?>
    <script language="javascript">
	 <!--
	  window.location = '<?php echo lienConnexion(); ?>';
	 -->
	</script>
<?php } ?>