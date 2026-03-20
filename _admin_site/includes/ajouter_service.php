<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$titre			    = formReception($_POST['titre']);
	$titreen		    = formReception($_POST['titreen']);
	$contenu			= formReception($_POST['contenu']);
	$contenuen			= formReception($_POST['contenuen']);
	$ancre  			= formReception($_POST['ancre']);
	$ancreen			= formReception($_POST['ancreen']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
	$auteur             = auteur_id();
	
	if($_POST['lien'] != '') $lien = formReception($_POST['lien']); else $lien= nett(formReception($_POST['titre']));
	if($_POST['lienen'] != '') $lienen = formReception($_POST['lienen']); else $lienen= nett(formReception($_POST['titreen']));
	
	$requete = 'INSERT INTO `services` (`titre`, `titreen`, `contenu`, `contenuen`, `ancre`, `ancreen`, `lien`, `lienen`, `ordre`, `etat`, `auteur`, `datecreation`) VALUES ("'. $titre .'","'. $titreen .'", "'. $contenu .'","'. $contenuen .'", "'. $ancre .'","'. $ancreen .'", "'. $lien .'","'. $lienen .'", "'. $ordre .'", "'. $etat .'","'. $auteur .'", "'. $datec .'")';
	$result  = mysqli_query($connexion, $requete);	
	$idb     = mysqli_insert_id($connexion);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
			$destination = str_replace(' ', '-',  $idb."-service-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/services/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `services` set `photo`="'. $photo .'" WHERE `id` ="'.$idb.'"';
			$result = executeRequete($requete);	
		}
	}

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=services';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
}
?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter service</h4>
                          <form id="form_validation" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="" class="form-control"> 
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Contenu anglais</h5>
                                        <div class="controls">
                                          <textarea id="editor11" name="contenuen" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
								         <div><img src="" style="max-width:150px" /></div>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre anglais</h5>
                                        <div class="controls">
                                            <input type="text" name="ancreen" value="" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Lien</h5>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="" class="form-control"> 
                                                </div>
                                            </div>
                                            <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                            <div class="form-group">
                                                <h5>Lien anglais</h5>
                                                <div class="controls">
                                                    <input type="text" name="lienen" value="" class="form-control"> 
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                               
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('services',1); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="form-control">
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="col-sm-12">
                                    <button class="btn btn-primary waves-effect" type="submit">Enregistrer</button>
                                    <button class="btn btn-primary waves-effect" type="reset" onclick="location.href='index.php?r=services'">Annuler</button>
							     	<input name="action" type="hidden" id="action" value="ajt">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
      $(document).ready(function(){
	   $("#leftsidebar .menu .list li#contenu").addClass('active');
      });
   </script>