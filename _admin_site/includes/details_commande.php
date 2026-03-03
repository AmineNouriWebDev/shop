<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <?php 
                    $id=sanitize($_GET['id']);
                    $idc= isset($_GET['idc']) ? sanitize($_GET['idc']) : '';
                    ?>
                    <div class="col-md-12 mb-4">
                        <div class="text-right">
                            <a href="index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>" class="btn btn-info"> Retour à la liste </a>
                        </div>
                    </div>
                    <div class="col-md-12" id="divToPrint">
                        <div class="card card-body printableArea">
                            <h3><b>COMMANDE</b> <?php if(cmd_expressCommande($id) !='') echo " | <span class='badge badge-success'>Commande express</span>"; ?> <span class="pull-right">#<?php echo numcommande($id);?></span></h3>
                            <hr class="w-100">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            
                                            <p class="text-muted m-l-5"><img src="../media/site/<?php echo $logo; ?>" class="img-fluid" style="max-width:150px"></p>
                                        
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>Client</h3>
                                            <h4 class="font-bold"><?php echo clientCommande($id);?></h4>
                                            <p class="text-muted m-l-30"><?php echo adresseCommande($id).' '.cpCommande($id).' , '.villeCommande($id);?></p>
                                            <p class="text-muted m-l-30"><?php echo telCommande($id);?></p>
                                            <p class="text-muted m-l-30"><?php echo emailCommande($id);?></p>
                                            <p><b>Moyen de paiement :</b> <?php echo moyen_paiementCommande($id);?></p>
                                            <p class="m-t-30"><b>Date de création:</b> <i class="fa fa-calendar"></i> <?php echo dateCommande($id);?></p>
                                            <p class="text-muted m-l-30"><?php echo etatCommande($id);?></p>
                                            <?php if(datePaiementCommande($id)){ ?>
                                            <p><b>Date Paiement :</b> <i class="fa fa-calendar"></i> <?php echo datePaiementCommande($id);?></p>
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
                                                    <th>Description</th>
                                                    <th>Quantité</th>
                                                    <th>Prix unitaire</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php

                                            $requete_cmd = 'SELECT * FROM `ligne_commande` WHERE `idcommande`="'.$id.'"';  

                                           $resultat_cmd = executeRequete($requete_cmd);

                                           $i=1;

                                           while ($datacmd = mysqli_fetch_array($resultat_cmd))  {

                                              ?>

                                              <tr style="font-size: 14px;">

                                              <td class="text-center"><?php echo $i;?></td>

                                              <td class="w-40"><?php 

                                              $detailscmd = "";

                                              if($datacmd['id_produit']!="") $detailscmd.= titreProduits($datacmd['id_produit'])."";
                                              

                                               echo $detailscmd;     

                                              ?>

                                              </td>

                                              <td><?php 

                                              $benefcmd=afficheChamp($datacmd['quantite'])."";

                                               echo $benefcmd;     

                                              ?>

                                              </td>

                                              <td class="text-end"><?php echo afficheChamp($datacmd['prix'])." TND";?></td>

                                            </tr>

                                        <?php } ?>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <p>Sous-Total : <?php echo soustotalCommande($id);?></p>
                                        <p>Livraison : <?php echo fraisCommande($id).' TND';?></p>
                                        <hr>
                                        <h3><b>Total :</b> <?php echo totalcommande($id);?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="text-right">
                            <button type="button" onclick="printSection('divToPrint')" class="btn btn-inverse"> 
                                <i class="fa fa-print me-2"></i> Imprimer
                            </button>
                            <a href="index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>" class="btn btn-info"> Retour à la liste </a>
                        </div>
                    </div>
                </div>

<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$id_commande			= formReception($_GET['id']);
	$etat	        		= formReception($_POST['etat']);
	$commentaire 			= formReception($_POST['commentaire']);
	$date       			= date('Y-m-d H:i:s');
	 if(isset($_POST['notify'])) { $notify  ='1'; } else { $notify  ='0'; }
     
	$req     = "UPDATE `commandes` set `etat`='".$etat."' WHERE `id`='".$id_commande."'" ;
	$res     = executeRequete($req);	

    $req2 = "INSERT INTO `historique_etat_commande`(`idcommande`, `idetat`,`date`, `commentaire`,`notif_client`) VALUES ('". $id_commande ."','". $etat ."','". $date ."','". $commentaire ."','".$notify."')";
    $res2 = executeRequete($req2);
    
    $cmd_exp = cmd_expressCommande($id_commande);
    	
    if(isset($_POST['notify'])) { 
        if($notify  ='1') {
            
        		$headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
                // En-ttes additionnels
                $headers .= 'From: '.$nom_site.' <info@technoplus.tn>'. "\r\n";
                $to = emailCommande($id_commande);
        	    $sujet = str_replace('%%NCMD%%',$id_commande,sujetEmail(10));
        	    
    		    $message_envoi = str_replace('%%NCMD%%',$id_commande,messageEmail(10));
    		    $message_envoi = str_replace('%%ETATCMD%%',etat_commandes($etat),$message_envoi);
    		    $message_envoi = str_replace('%%CMNT%%',$commentaire,$message_envoi);
        		
        		
                // Envoi
                // Envoi
                //mail($to, $sujet, $message_envoi, $headers, "-f info@technoplus.tn");
                if($_SERVER['SERVER_NAME'] != 'localhost') {
                    @mail($to, $sujet, $message_envoi, $headers, "-f info@technoplus.tn");
                }
            
	    }
        
    }
	  
	$msg="Historique ajouté avec succès.";
	
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $msg;?>');
		window.location = 'index.php?r=dcommande&id=<?php echo $id_commande; ?>';
	-->
	</script>
	<?php } ?> 
	            <div class="row">
                    <div class="col-md-12">
                        
                        <div class="card card-body">
                            
                            <h3>Historique d'état de commande <span class="">N° <?php echo numcommande($id);?></span></h3>
                            <div class="table-responsive">
                                <table  class="table table-hover color-table info-table table-bordered" cellspacing="0" width="100%">
        							<thead>
        								<tr>
        									<th class="left">Etat commande</th>
        									<th class="selected last">Client notifié</th>
        									<th class="selected last">Commentaire</th>
        									<th class="selected last">Date</th>
        								</tr>
        							</thead>
        							<tbody>
                                        <?php		
        
                                        $req = "SELECT * FROM `historique_etat_commande` WHERE idcommande='".$_GET['id']."' ORDER BY `id`";
                                        $res = executeRequete($req);
                                        $total= mysqli_num_rows($res);
                                        if($total){
                                        while ($data = mysqli_fetch_array($res))
                                        {
                                        	
                                          
                                        ?>   
        							    <tr>
        									<td class="price"><?php echo etat_commandes($data['idetat']); ?> </td>
        									<td class="price"><?php echo notificationCommande($data['id']); ?> </td>
        									<td class="price"><?php echo afficheChamp($data['commentaire']); ?> </td>
        									<td class="price"><?php echo afficheChamp($data['date']); ?> </td>
        								</tr>
        								
                                        <?php }}else{ ?>
                                        <tr>
        									<td colspan="4">Aucun mise à jour n'a été effectué ! </td>
        								</tr>
                                        <?php }?>
        							</tbody>
        						</table>
        					</div>
                        </div>
                        <div class="card card-body">
                                <form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">
                                    <div class="row">
                                     <div class="col-md-4">
                                       <div class="form-group">
                                        <h5>Etat *:</h5>
                                        <div class="controls">
                                            <select name="etat" class="form-control">
                                              <?php		
                                               $req1 = "SELECT * FROM `etat_commandes` ORDER BY `id`";	
                                               $res1=executeRequete($req1);
                                               while ($data1 = mysqli_fetch_array($res1)) {		
                                              ?> 
                                              <option value="<?php echo $data1['id']; ?>" <?php if(etatCommande($id) == $data1['id']) { ?>selected="selected" <?php } ?>><?php echo afficheChamp($data1['etat']); ?></option>  
                                              <?php  } ?>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div> 

                                    <div class="row">
            							<div class="col-md-12">
                                            <div class="form-group d-flex">
                                                <h5>Notification client :</h5>
                    							<div class="form-check">
                                                    <input name="notify" value="1"  type="checkbox" class="form-check-input" style="margin-left: 10px; position: relative;margin-top: 0;opacity: 1;left: 0;">
                    							</div>
                							</div>
            							</div>
            						</div>
                                                                            
                                    <div class="row">
                                     <div class="col-md-12">
                                       <div class="form-group">
                                        <h5>Commentaires :</h5>
                                        <div class="controls">
            								<textarea rows="4" name="commentaire" class="form-control"></textarea>
                                        </div>
                                    </div>
                                     </div>
                                    </div> 
                                        
                                        
            							<div class="buttons">
                                            <button type="submit" name="submit" class="btn btn-info">Enregistrer</button>
                                            <button type="reset" class="btn btn-inverse" name="reset2" onclick="location.href='index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>'">Annuler</button>
            								<input type="hidden" name="action" value="ajt" />
            							</div>
        					</form>
                    </div>
                </div>
            </div>
                
                
                
 
        <script type="text/javascript">
            function printSection(el){
                var getFullContent = document.body.innerHTML;
                var printsection = document.getElementById(el).innerHTML;
                document.body.innerHTML = printsection;
                window.print();
                document.body.innerHTML = getFullContent;
            }
        </script>