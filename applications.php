<?php

	session_start();
	include("include.php");
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '22'";
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
<html lang="fr">
<head>
	<?php include('includes/script-header.php');?>
    <style>
        /* ── Core Layout System (cx-) ────────────────────────── */
        .cx-wrap {
            min-height: 100vh;
            background: var(--shop-bg-base);
            color: var(--shop-text-primary);
            padding-top: 2rem;
            transition: background 300ms ease;
        }
        .cx-surface {
            background: var(--shop-surface);
            border: 1px solid var(--shop-border);
            border-radius: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 200ms ease, box-shadow 200ms ease, background 300ms ease;
        }
        .cx-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 200ms ease;
            cursor: pointer;
            text-decoration: none !important;
            border: none;
        }
        .btn-primary-tw {
            background: var(--shop-primary);
            color: white !important;
        }
        .btn-primary-tw:hover {
            background: var(--shop-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px color-mix(in srgb, var(--shop-primary) 30%, transparent);
        }
    </style>
</head>
<body>
    <?php include('includes/header-tw.php');?>
    
    <main class="cx-wrap pb-5">
        <?php 
        $variable2='<li class="breadcrumb-item active" aria-current="page">'.titrePage(22).'</li>';
        include('includes/breadcrumb.php');
        ?>
        
        <?php include("includes/applications.php"); ?>
    </main>

    <?php include('includes/footer-tw.php');?>
 	<?php include('includes/script-footer.php');?>
</body>
</html>