<?php
include("include.php");
$requete = "SELECT * FROM `site_menu` WHERE `id` = '7'";
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
<!DOCTYPE html>
<html lang="fr" class="">
<head>
	<?php include('includes/script-header.php');?>
    <style>
      *, *::before, *::after{box-sizing:border-box;} 
      body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);min-height:100vh;display:flex;flex-direction:column;}
      
      /* Cloudflare Turnstile */
      .cf-turnstile iframe { max-width: 100%!important; }
      
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
    
    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
	<?php include('includes/feedback.php');?>
	<?php include('includes/header-tw.php');?>
	
	<?php 
	$variable2='<li class="breadcrumb-item text-secondary" aria-current="page">'.$titre.'</li>';
    ?>
    
    <main class="cx-wrap">
        <!-----------------------Breadcrumb------------------->
        <div class="single-product-area mt-0 mb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-light d-inline-flex px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.85rem; font-weight: 500;">
                                 <li class="breadcrumb-item"><a href="<?php echo lienAccueil();?>" class="text-secondary text-decoration-none"><i class="fa fa-home"></i> Accueil</a></li>
                                    <?php echo $variable2;?>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?php include("includes/contact.php"); ?>
    </main>

    <?php include('includes/footer-tw.php');?>
 	<?php include('includes/script-footer.php');?>
	
</body>
</html>