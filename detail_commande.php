<?php

	session_start();
	
    include("include.php");

    if(isset($_SESSION['client_id'])) { $id_client = $_SESSION['client_id'];
    
    if(isset($_GET['cmdId']) && $_GET['cmdId'] != '' ){
    
    $cmdId = sanitize($_GET['cmdId']);

    $req   = 'SELECT * FROM `commandes` WHERE `idclient`="'.$_SESSION['client_id'].'" AND `id`="'.$cmdId.'" ORDER BY `ID` DESC ';
    $res   = executeRequete($req);
    $data = mysqli_fetch_array($res);
    
    $adresseCmd = adresseCommande($data['id']);
    $villeCmd = villeCommande($data['id']);
    $cpCmd = cpCommande($data['id']); 
    
    if($cmdId == $data['id']){
        
    $requete = "SELECT * FROM ligne_commande L LEFT JOIN commandes C ON L.idcommande = C.id WHERE  L.idcommande='".$cmdId."' AND C.id='".$cmdId."' AND C.idclient='".$_SESSION['client_id']."'";
    $resultat = executeRequete($requete);
    $rowCmd   = 1;

    	$requete1 = "SELECT * FROM `site_menu` WHERE `id` = '16'";
        //echo $requete1;
        $resultat1 = executeRequete($requete1);
        $data1 = mysqli_fetch_array($resultat1);
        if($data1['id']!=""){
            $id=afficheChamp($data1['id']);
            $titre=afficheChamp($data1['titre']);		        
            $contenu=afficheChamp($data1['contenu']);
            $description_page=afficheChamp($data1['description']);
            $title_page=afficheChamp($data1['titre_page']);
            $keywords_page=afficheChamp($data1['keywords']);
    
    
        }
?>
	
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include('includes/script-header.php');?>
	<link rel="stylesheet" href="dist/scss/style.css" />
	<link rel="stylesheet" href="dist/css/print.css" media="print"/>
</head>
<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>

    <?php 
	$variable2='<li class="breadcrumb-item" aria-current="page"><a href="'.lienCompte().'">Mon compte</a></li>';
	$variable3='<li class="breadcrumb-item active" aria-current="page">'.titrePage(16).'</li>';
	include('includes/breadcrumb.php');  
    ?>

    <div class="main">
        
                    <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card card-body printableArea">
                            <h3><b>N° Commande</b> <span class="pull-right">#<?php echo $cmdId; ?></span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            <img src='<?php echo $chemin_absolu; ?>media/site/<?php echo $logo;?>' style="max-width:280px" />
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>À,</h3>
                                            <h4 class="font-bold"><?php echo ucwords(clientCommande($cmdId)); ?>,</h4>
                                            <p class="text-muted m-l-30">E-mail : <?php echo emailClient(idclientCommande($cmdId));?>,
                                                <br/> Adresse : <?php echo $adresseCmd.' '.$cpCmd.' , '.$villeCmd;?>,
                                                <br/> Téléphone : <?php echo telCommande($data['id']);?>,
                                                <br/> État de la commande : <?php echo etatCommande($cmdId);?>,
                                                <br/> Moyen de paiement : <?php echo moyen_paiementCommande($cmdId);?></p>
                                            <p class="m-t-30"><b>Date de création :</b> <i class="fa fa-calendar"></i> <?php echo dateCommande($cmdId);?></p>
                                            <?php if(datePaiementCommande($cmdId)){ ?>
                                            <p class="m-t-30"><b>Date de paiement :</b> <i class="fa fa-calendar"></i> <?php echo datePaiementCommande($cmdId);?></p>
                                            <?php } ?>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Nom produit</th>
                                                    <th class="text-right">Prix unitaire</th>
                                                    <th class="text-right">quantité</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    while($data = mysqli_fetch_array($resultat)){
                                                    if($data['id']!=""){
                                                        $id       = afficheChamp($data['id']);
                                                        $idCmd    = afficheChamp($data['idcommande']);		        
                                                        $idProd   = afficheChamp($data['id_produit']);
                                                        $subtotal = afficheChamp($data['sous_total']);
                                                        $total    = afficheChamp($data['total']);
                                                        $quantite = afficheChamp($data['quantite']);
                                                        $fraisLiv = afficheChamp($data['frais_livraison']);
                                                   
                                                
                                                ?>
                                                <tr style="font-size: 13px;">
                                                    <td class="text-center"><?php echo $rowCmd++; ?></td>
                                                    <td><?php echo titreProduits($idProd); ?></td>
                                                    <td class="text-right"><?php echo prixVenteProduits($idProd); ?> </td>
                                                    <td class="text-right"><?php echo $quantite; ?> </td>
                                                    <td class="text-right"><?php echo $prixtotal =number_format(($quantite * prixVenteProduits($idProd)), 3, '.', ''); ?> </td>
                                                </tr>
                                                <?php
                                                    }
                                                    }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <p>Sous-Total : <?php echo $subtotal.' DT';?></p>
                                        <p>Livraison : <?php echo $fraisLiv.' DT';?></p>
                                        
                                        <hr>
                                        <h3><b>Total :</b> <?php echo totalcommande($idCmd); ?></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr class="hrPrint">
                                    <div class="text-right">
                                        <a href="<?php echo lienCompte(); ?>" class="btn btn-secondary">Retour</a>
                                        <button id="print" class="btn btn-default btn-outline ecran" type="button"  onClick="javascript:window.print()" style="background: #e91e63;color: #fff;font-family: 'Montserrat';font-weight: 500"> <span><i class="fa fa-print"></i> Imprimer</span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
    
    </div>
    
    
    <!-- ======= Footer ======= -->
    <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>

</body>

</html>

    <?php
        } else{ 
    ?>
    <script language="javascript">
	 <!--
	    alert('Opération réfusée!')
	  window.location = '<?php echo lienCompte(); ?>';
	 -->
	</script>
    <?php 
        } 
        
    }
    }
    else
    { 
    ?>
    <script language="javascript">
	 <!--
	  window.location = '<?php echo lienConnexion(); ?>';
	 -->
	</script>
<?php } ?>