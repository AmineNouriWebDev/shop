<?php
function supprimerVilles($id){
    $requete = 'SELECT * FROM `villes` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    executeRequete("DELETE FROM `villes` WHERE `id` = '".$id."'");
    return true;
}

function nomVilles($id) {
	$requete = 'SELECT * FROM `villes` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nom_ville']);
}
function numeroVilles($id)
{
	$requete = 'SELECT * FROM `villes` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['numero']);
}


function Villes($id) {
    
    $Config = executeRequete("select `tel` from `site_configuration`");
    $telConfig = mysqli_fetch_array($Config);
	    $requete ="SELECT * FROM `villes` WHERE `id` = '".$id."' ";
        $resultat = executeRequete($requete);
        while($data = mysqli_fetch_array($resultat)){
        ?>
        <li>
			<a href="javascript:void(0);"  data-toggle="modal" data-target="#callForm" class="">
				Dépannage remorquage <?php echo ucwords($data['nom_ville']); ?> (<?php echo afficheChamp($data['numero']); ?>)
			</a>
            <!-- Modal -->
                        <div class="modal" id="callForm">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body text-center">
                                <a href="tel:<?php echo $telConfig['tel'] ;?>" class="btn  btn-block btn-header">Appelez le <?php echo implode(' ', str_split($telConfig['tel'],3));?></a>
			                  </div>
                              <div class="modal-footer">
                                <!--<p>*Le coût de l'appel est (2,99 € /appel + 2,99 € /min )</p>-->
                              </div>
                            </div>
                          </div>
                        </div>
            
		</li>
        <?php 
    }
}


?>