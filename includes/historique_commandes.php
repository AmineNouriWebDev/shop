
<table class="table table-bordered table-responsive-lg table-hover" id="commandes">
  <thead>
    <tr>
      <th style="width: 17%">N° commande</th>
      <th  style="width: 28%">Date commande</th>
      <th style="width: 20%">Total</th>
      <th  style="width: 20%">Etat</th>
      <th  style="width: 15%"></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    
    $idclient= $_SESSION['client_id'];
      $requete11= 'SELECT * FROM `commandes` WHERE `idclient`="'.$idclient.'" ORDER BY `ID` DESC ';
      $resultat11 = executeRequete($requete11);
      $num11 = mysqli_num_rows($resultat11);
      if ($num11 == 0 ) {
      ?>
  	<tr>
      <td colspan="5">Aucune commande pour le moment</td>
    </tr>
    <?php 
      }
      if ($num11 > 0 ) { 
        while ($data11 = mysqli_fetch_array($resultat11))  {
      ?>
      <tr>
      <td><?php echo '#CMD-'.numCommande($data11['id']);?></td>
      <td><?php echo dateCommande($data11['id']);?></td>
      <td><?php echo totalCommande($data11['id']);?></td>
      <td style="text-align: center;"><?php echo etatCommande($data11['id'])."</span>";?>
       </td>
      <td>
        <?php if($data11['etat'] != 9){ if($data11['moyen_paiement'] == 10){
            $urlOg  = "";
		    $urlOg .= qteCommande($data11['id']).' x '.produitCommande($data11['id'])." / ";
		    $urlOg = rtrim($urlOg," / ");
		    //$payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode(str_replace('%%lien_produit%%',$urlOg,$message_cmd_whatsapp));
       /* if($payment_link !=""){
        $payment_link = $data11['lien_paiement'];
        }else{
        */
          $urlOg .= qteCommande($data11['id']).' x '.produitCommande($data11['id'])." / ";
          $urlOg = rtrim($urlOg," / ");
          $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode(str_replace('%%lien_produit%%',$urlOg,$message_cmd_whatsapp));
        //}
        ?>
        <button class="btn btn-sm btn-danger" style="margin-top: 10px;" data-toggle="tooltip" data-placement="top" title="Finaliser le paiement" onclick="window.open('<?php echo $payment_link;?>', '_blank');"><i class="fa fa-credit-card"></i> </button>
        <?php } } ?>
        <a class="btn btn-sm btn-infos" style="margin-top: 10px;" title="Détails commande" href="<?php echo lienDeatilCommandes($data11['id']);  ?>"><i class="fa fa-search text-inverse m-r-10"></i> </a>
        
      </td>
    </tr>
    <?php
      }
    }
    ?>

  </tbody>
</table>
<div class="modal fade" id="bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paiement par virement bancaire </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo messageEmail(8);?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
