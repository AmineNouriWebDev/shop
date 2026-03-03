<?php
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id			        = formReception($_POST['id']);
	$titre			    = formReception($_POST['titre']);
	$etat 	            = formReception($_POST['etat']);
	
	$requete = 'UPDATE `liste_sections` SET `titre`="'. $titre .'", `etat`=  "'. $etat .'" WHERE `id`="'.$id.'"';
	//echo $requete; exit;
	$result  = mysqli_query($connexion, $requete);	

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=listeSection';
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
                        <h4 class="card-title">Modifier section</h4>
                          <form id="form_validation" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreListeSection($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="form-control">
                                                <option value="1" <?php if(etatListeSection($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatListeSection($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="col-sm-12">
                                    <button class="btn btn-primary waves-effect" type="submit">Enregistrer</button>
                                    <button class="btn btn-primary waves-effect" type="reset" onclick="location.href='index.php?r=listeSection'">Annuler</button>
							     	<input name="action" type="hidden" id="action" value="mod">
                                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
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