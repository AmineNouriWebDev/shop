<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <?php 
                    $id=sanitize($_GET['id']);
                    $idc= isset($_GET['idc']) ? sanitize($_GET['idc']) : '';

                    $req_date = executeRequete("SELECT date FROM commandes WHERE id='".$id."'");
                    $d_date = mysqli_fetch_array($req_date);
                    $doc_year = date("Y", $d_date['date']);
                    $doc_num = $doc_year . sprintf("%06d", $id);

                    $res_legal = executeRequete("SELECT matricule_fiscale, rne, registre_commerce, banque, rib, swift, code_douane FROM site_configuration");
                    $legal_data = mysqli_fetch_array($res_legal);
                    ?>
                    <div class="col-md-12 mb-4">
                        <div class="text-right">
                            <a href="index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>" class="admin-btn admin-btn-primary"> Retour à la liste </a>
                        </div>
                    </div>
                    <div class="col-md-12" id="divToPrint">
                        <div class="admin-card printableArea" style="padding: 1.5rem;">
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
                                <h3 style="margin:0; font-weight:600; color:var(--text-primary); font-size: 1.5rem;"><span id="dynamicDocTitle">COMMANDE</span> <?php if(cmd_expressCommande($id) !='') echo " <span class='badge badge-success' style='background:#10b981; margin-left:10px; font-size:0.875rem;'>Express</span>"; ?></h3>
                                <span style="font-size:1.25rem; font-weight:700; color:var(--color-primary);">#<?php echo $doc_num; ?></span>
                            </div>
                            <hr class="w-100">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                                        <div>
                                            <img src="../media/site/<?php echo $logo; ?>" class="img-fluid" style="max-width:180px">
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
                                            <h4 class="font-bold" style="font-size: 11pt; margin-top: 5px;"><?php echo clientCommande($id);?></h4>
                                            <p class="text-muted m-0"><?php echo adresseCommande($id).' '.cpCommande($id).' , '.villeCommande($id);?></p>
                                            <p class="text-muted m-0"><?php echo telCommande($id);?></p>
                                            <p class="text-muted m-0"><?php echo emailCommande($id);?></p>
                                            <p style="margin-top: 10px; margin-bottom: 0;"><b>Moyen de paiement :</b> <?php echo moyen_paiementCommande($id);?></p>
                                            <p class="text-muted m-0"><b>Date de création:</b> <i class="fa fa-calendar print-hide"></i> <?php echo dateCommande($id);?></p>
                                            <p class="text-muted m-0 print-hide"><?php echo etatCommande($id);?></p>
                                            <?php if(datePaiementCommande($id)){ ?>
                                            <p class="m-0"><b>Date Paiement :</b> <i class="fa fa-calendar print-hide"></i> <?php echo datePaiementCommande($id);?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="admin-table">
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
                                              
                                              if(!empty($datacmd['nom_produit'])) {
                                                  $detailscmd = $datacmd['nom_produit'];
                                              } else if($datacmd['id_produit']!="") {
                                                  $detailscmd = titreProduits($datacmd['id_produit']);
                                              }

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
                    <div class="col-md-12 mb-4">
                        <div class="text-right">
                            <button type="button" onclick="printDocument('Facture')" class="admin-btn admin-btn-ghost"> 
                                <i class="fa fa-print me-2"></i> Facture
                            </button>
                            <button type="button" onclick="printDocument('Bon de Commande')" class="admin-btn admin-btn-ghost"> 
                                <i class="fa fa-print me-2"></i> Bon de Commande
                            </button>
                            <button type="button" onclick="printDocument('Bon de Livraison')" class="admin-btn admin-btn-ghost"> 
                                <i class="fa fa-print me-2"></i> Bon de Livraison
                            </button>
                            <a href="index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>" class="admin-btn admin-btn-primary"> Retour à la liste </a>
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
            
        // Remplacement de la fonction mail native par le webhook n8n
        $template_id = ($etat == 9) ? 11 : 10; // 11: Paiement, 10: Mise à jour classique

        $to = emailCommande($id_commande);
        
        $sujet = str_replace('%%NCMD%%', numcommande($id_commande), sujetEmail($template_id));
        
        $message_envoi = str_replace('%%NCMD%%', numcommande($id_commande), messageEmail($template_id));
        $message_envoi = str_replace('%%ETATCMD%%', etat_commandes($etat), $message_envoi);
        $message_envoi = str_replace('%%CMNT%%', $commentaire, $message_envoi);
        
        // Envoi asynchrone sécurisé Cloud-to-Cloud via Webhook
        $payload_n8n = [
            'event'          => 'order_status_update',
            'order_id'       => $id_commande,
            'customer_email' => $to,
            'email_subject'  => $sujet,
            'email_html'     => $message_envoi
        ];
        envoiEmail_n8n($payload_n8n);
            
	    }
        
    }
	  
	$msg="Historique ajouté avec succès.";
	phpToastRedirect($msg, 'index.php?r=dcommande&id='.$id_commande, 'success');
} ?>
	            <div class="row">
                    <div class="col-md-12">
                        
                        <div class="admin-card" style="padding: 1.5rem;">
                            
                            <div class="admin-card-header">
								<div class="admin-card-title" style="margin-bottom:0px;">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
									</svg>
									Historique d'état de commande N° <?php echo numcommande($id);?>
								</div>
                            </div>
                            <div class="table-responsive">
                                <table  class="admin-table" cellspacing="0" width="100%">
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
                        <div class="admin-card" style="padding: 1.5rem;">
                                <form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">
                                    <div class="row">
                                     <div class="col-md-4">
                                       <div class="admin-form-group">
                                        <label>Etat *:</label>
                                        <div class="controls">
                                            <select name="etat" class="admin-input">
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
                                                <label>Notification client :</label>
                    							<div class="form-check">
                                                    <input name="notify" value="1"  type="checkbox" class="form-check-input" style="margin-left: 10px; position: relative;margin-top: 0;opacity: 1;left: 0;">
                    							</div>
                							</div>
            							</div>
            						</div>
                                                                            
                                    <div class="row">
                                     <div class="col-md-12">
                                       <div class="admin-form-group">
                                        <label>Commentaires :</label>
                                        <div class="controls">
            								<textarea rows="4" name="commentaire" class="admin-input"></textarea>
                                        </div>
                                    </div>
                                     </div>
                                    </div> 
                                        
                                        
            							<div class="buttons">
                                            <button type="submit" name="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                            <button type="reset" class="admin-btn admin-btn-ghost" name="reset2" onclick="location.href='index.php?r=commandes<?php if(isset($_GET['idc'])) echo '&id='.$idc; ?>'">Annuler</button>
            								<input type="hidden" name="action" value="ajt" />
            							</div>
        					</form>
                    </div>
                </div>
            </div>
                
                
                
 
        <script type="text/javascript">
            function printDocument(docType) {
                var titleSpan = document.getElementById('dynamicDocTitle');
                var originalTitle = titleSpan.innerHTML;
                
                titleSpan.innerHTML = docType.toUpperCase();
                
                var printsection = document.getElementById('divToPrint').innerHTML;
                
                titleSpan.innerHTML = originalTitle;
                
                var getFullContent = document.body.innerHTML;
                
                document.body.innerHTML = printsection;
                window.print();
                
                document.body.innerHTML = getFullContent;
                
                // Recharger la page pour reconnecter les listeners JavaScript perdus (sécurité d'interface)
                window.location.reload();
            }
        </script>
