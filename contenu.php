<?php
include("include.php");
if(isset($_GET['link']) && $_GET['link'] != '' ){
$link=sanitize($_GET['link']);
$type = isset($_GET['type']) ? sanitize($_GET['type']) : '';
$requete = "SELECT * FROM `site_menu` WHERE `link` = '".$link."'";
//echo $requete;
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if($data && isset($data['id']) && $data['id']!=""){
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
}
?>
<!DOCTYPE html>
<html lang="fr" class="">
<head>
	<?php include('includes/script-header.php');?>
    <style>
      *, *::before, *::after{box-sizing:border-box;} 
      body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);min-height:100vh;display:flex;flex-direction:column;}
      
      .cx-wrap { flex:1; padding: 3rem 1rem; width: 100%; max-width: 1100px; margin: 0 auto; }
      .cx-surface { background: var(--shop-surface); border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid var(--shop-border, #E0DEFF); }
      html.dark .cx-surface { border-color: var(--shop-border, #323248); background: color-mix(in srgb, var(--shop-surface) 95%, black); }

      /* Rich text content styling */
      .rich-content { line-height: 1.8; color: var(--shop-text-secondary); font-size: 1.05rem; }
      .rich-content h1, .rich-content h2, .rich-content h3, .rich-content h4 { color: var(--shop-text-primary); font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; }
      .rich-content p { margin-bottom: 1.25rem; }
      .rich-content ul, .rich-content ol { margin-bottom: 1.25rem; padding-left: 1.5rem; }
      .rich-content li { margin-bottom: 0.5rem; }
      .rich-content a { color: var(--shop-primary); text-decoration: none; font-weight: 500; }
      .rich-content a:hover { text-decoration: underline; }
      .rich-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
      .rich-content th, .rich-content td { border: 1px solid var(--shop-border); padding: 0.75rem; text-align: left; }
      .rich-content th { background: var(--shop-bg-alt); color: var(--shop-text-primary); font-weight: 600; }
      .rich-content img { max-width: 100%; height: auto; border-radius: 0.75rem; margin: 1.5rem 0; }
    </style>
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
            <div class="container-fluid p-0">
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

        <!-- Content Area -->
        <div class="cx-surface mt-2">
            <h1 class="mb-4 text-center" style="font-size: 2.25rem; font-weight: 800; color: var(--shop-text-primary); letter-spacing: -0.02em;">
                <?php echo $titre; ?>
            </h1>
            <hr class="mb-5" style="border-color: var(--shop-border); opacity: 0.6;">
            
            <div class="rich-content text-start">
                <?php echo $contenu; ?>
            </div>
        </div>
    </main>

    <?php include('includes/footer-tw.php');?>
 	<?php include('includes/script-footer.php');?>
	
</body>
</html>