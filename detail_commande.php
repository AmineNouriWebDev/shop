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

    $req_date = executeRequete("SELECT date FROM commandes WHERE id='".$cmdId."'");
    $d_date = mysqli_fetch_array($req_date);
    $doc_year = date("Y", $d_date['date']);
    $doc_num = $doc_year . sprintf("%06d", $cmdId);

    $res_legal = executeRequete("SELECT matricule_fiscale, rne, registre_commerce, banque, rib, swift, code_douane FROM site_configuration");
    $legal_data = mysqli_fetch_array($res_legal);
    
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
	<?php include('includes/script_panier.php'); ?>
	<link rel="stylesheet" href="dist/scss/style.css" />
	<link rel="stylesheet" href="dist/css/print.css" media="print"/>
	<style>*, *::before, *::after{box-sizing:border-box;} body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);}</style>
</head>
<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/header-tw.php');?>

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
                            <style>
                                @media print {
                                    #printFooterLegal {
                                        display: block !important;
                                        position: fixed;
                                        bottom: 0;
                                        left: 0;
                                        width: 100%;
                                        text-align: center;
                                        font-size: 11px;
                                        color: #555;
                                        border-top: 1px solid #ddd;
                                        padding-top: 10px;
                                    }
                                    .print-hide { display: none !important; }
                                    .invoice-header-right { text-align: right; }
                                }
                            </style>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 1rem;">
                                <h3 style="margin:0; font-weight:600; color:var(--text-primary); font-size: 1.5rem;" id="dynamicDocTitle">COMMANDE</h3>
                                <span style="font-size:1.25rem; font-weight:700; color:var(--color-primary);">#<?php echo $doc_num; ?></span>
                            </div>
                            <hr class="w-100">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                                        <div>
                                            <img src="<?php echo $chemin_absolu; ?>media/site/<?php echo $logo; ?>" class="img-fluid" style="max-width:180px">
                                        </div>
                                        <div class="invoice-header-right">
                                            <h2 style="font-weight: bold; font-size: 16pt; margin-bottom: 5px;"><?php echo htmlspecialchars($nom_site); ?></h2>
                                            <p style="margin: 0; font-size: 10pt; color: #555;"><?php echo htmlspecialchars($adresse); ?></p>
                                            <p style="margin: 0; font-size: 10pt; color: #555;">Tél : <?php echo htmlspecialchars($tel); ?> <?php if(!empty($gsm)) echo ' / '.htmlspecialchars($gsm); ?></p>
                                            <p style="margin: 0; font-size: 10pt; color: #555;">Email : <?php echo htmlspecialchars($email_contact); ?></p>
                                            <p style="margin: 0; font-size: 10pt; color: #555;"><?php echo htmlspecialchars($chemin_absolu); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; padding: 15px; border: 1px solid #eee; background: #fafafa;">
                                        <div style="flex: 1; font-size: 10pt; color: #333; line-height: 1.6;">
                                            <?php if(!empty($legal_data['matricule_fiscale'])){ ?>
                                                <div style="font-size: 11pt; font-weight: bold; margin-bottom: 4px;">Matricule Fiscal : <?php echo afficheChamp($legal_data['matricule_fiscale']); ?></div>
                                            <?php } ?>
                                            <?php if(!empty($legal_data['rne'])){ ?>
                                                <div>Identifiant Unique (RNE) : <?php echo afficheChamp($legal_data['rne']); ?></div>
                                            <?php } ?>
                                            <?php if(!empty($legal_data['registre_commerce'])){ ?>
                                                <div>Registre de Commerce : <?php echo afficheChamp($legal_data['registre_commerce']); ?></div>
                                            <?php } ?>
                                            <?php if(!empty($legal_data['code_douane'])){ ?>
                                                <div>Code en douane : <?php echo afficheChamp($legal_data['code_douane']); ?></div>
                                            <?php } ?>
                                        </div>
                                        <div style="flex: 1; text-align: right;">
                                            <h3 style="margin-top: 0; font-size: 12pt; color: #333; border-bottom: 2px solid #ddd; padding-bottom: 5px; display: inline-block;">Client</h3>
                                            <h4 class="font-bold" style="font-size: 11pt; margin-top: 5px;"><?php echo ucwords(clientCommande($cmdId)); ?></h4>
                                            <p class="text-muted m-0">E-mail : <?php echo emailClient(idclientCommande($cmdId));?></p>
                                            <p class="text-muted m-0">Adresse : <?php echo $adresseCmd.' '.$cpCmd.' , '.$villeCmd;?></p>
                                            <p class="text-muted m-0">Téléphone : <?php echo telCommande($data['id']);?></p>
                                            <p style="margin-top: 10px; margin-bottom: 0;"><b>Moyen de paiement :</b> <?php echo moyen_paiementCommande($cmdId);?></p>
                                            <p class="text-muted m-0"><b>Date de création :</b> <i class="fa fa-calendar print-hide"></i> <?php echo dateCommande($cmdId);?></p>
                                            <p class="text-muted m-0 print-hide">État : <?php echo etatCommande($cmdId);?></p>
                                            <?php if(datePaiementCommande($cmdId)){ ?>
                                            <p class="m-0"><b>Date de paiement :</b> <i class="fa fa-calendar print-hide"></i> <?php echo datePaiementCommande($cmdId);?></p>
                                            <?php } ?>
                                        </div>
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
                                </div>
                            </div>
                            
                            <div id="printFooterLegal" style="display: none;">
                                <?php 
                                $banqueOptions = [];
                                if(!empty($legal_data['banque'])) $banqueOptions[] = "Banque : ".afficheChamp($legal_data['banque']);
                                if(!empty($legal_data['rib'])) $banqueOptions[] = "RIB / IBAN : ".afficheChamp($legal_data['rib']);
                                if(!empty($legal_data['swift'])) $banqueOptions[] = "Code SWIFT : ".afficheChamp($legal_data['swift']);
                                
                                if(!empty($banqueOptions)) {
                                    echo implode(" &nbsp;|&nbsp; ", $banqueOptions);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-5 print-hide">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <div class="text-right">
                                <a href="<?php echo lienCompte(); ?>" class="btn btn-secondary mr-2">Retour au compte</a>
                                <button type="button" onclick="printDocument('Facture')" class="btn btn-outline" style="background: #e91e63;color: #fff; border:none; margin-right: 5px;"> 
                                    <i class="fa fa-print me-2"></i> Facture
                                </button>
                                <button type="button" onclick="printDocument('Bon de Commande')" class="btn btn-outline" style="background: #3f51b5;color: #fff; border:none; margin-right: 5px;"> 
                                    <i class="fa fa-print me-2"></i> Bon de Commande
                                </button>
                                <button type="button" onclick="printDocument('Bon de Livraison')" class="btn btn-outline" style="background: #009688;color: #fff; border:none;"> 
                                    <i class="fa fa-print me-2"></i> Bon de Livraison
                                </button>
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
    <?php include('includes/footer-tw.php');?>


 	 <?php include('includes/script-footer.php');?>

    <script type="text/javascript">
        function printDocument(docType) {
            var titleSpan = document.getElementById('dynamicDocTitle');
            var originalTitle = titleSpan.innerHTML;
            
            titleSpan.innerHTML = docType.toUpperCase();
            
            var printsection = document.querySelector('.printableArea').innerHTML;
            
            titleSpan.innerHTML = originalTitle;
            
            var getFullContent = document.body.innerHTML;
            
            document.body.innerHTML = printsection;
            window.print();
            
            document.body.innerHTML = getFullContent;
            
            window.location.reload();
        }
    </script>

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