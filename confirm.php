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

<html lang="en">

<head>

	<?php include('includes/script-header.php');?>
    <?php include('includes/script_panier.php');?>
	
	<link rel="stylesheet" href="dist/scss/style.css" />
	
</head>

<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>
	
	<?php include('includes/confirm.php');?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
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