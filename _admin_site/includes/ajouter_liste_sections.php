<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$titre			    = formReception($_POST['titre']);
	$etat 	            = formReception($_POST['etat']);
	
	$requete = 'INSERT INTO `liste_sections` (`titre`, `etat`) VALUES ("'. $titre .'",  "'. $etat .'")';
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
                <div class="admin-card">
                        <div class="admin-card-header">
                            <div class="admin-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.75 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Ajouter section
                            </div>
                        </div>
                        <div class="admin-card-body">
                          <form id="form_validation" method="POST" enctype="multipart/form-data">
                                <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="admin-form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="col-sm-12">
                                    <button class="admin-btn admin-btn-primary" type="submit">Enregistrer</button>
                                    <button class="admin-btn admin-btn-primary" type="reset" onclick="location.href='index.php?r=listeSection'">Annuler</button>
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

