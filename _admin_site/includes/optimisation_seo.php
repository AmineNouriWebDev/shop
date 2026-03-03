
<?php 

    $req  = "SELECT * FROM `optimisation_seo` WHERE 1";
    $res  = executeRequete($req);
    $numR = mysqli_num_rows($res);
    
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$title_categ 		= formReception($_POST['title_categ']);
	$description_categ 	= formReception($_POST['description_categ']);
	$keywords_categ     = formReception($_POST['keywords_categ']);
	$title_scateg 		= formReception($_POST['title_scateg']);
	$description_scateg = formReception($_POST['description_scateg']);
	$keywords_scateg    = formReception($_POST['keywords_scateg']);
	$title_prod         = formReception($_POST['title_prod']);
	$description_prod	= formReception($_POST['description_prod']);
	$keywords_prod 	 	= formReception($_POST['keywords_prod']);
	$title_marque       = formReception($_POST['title_marque']);
	$description_marque	= formReception($_POST['description_marque']);
	$keywords_marque 	= formReception($_POST['keywords_marque']);
	
    if($numR > 0 ){
	    $requete = 'UPDATE `optimisation_seo` SET	`title_categ` = "'. $title_categ .'", `description_categ` = "'. $description_categ .'",`keywords_categ` = "'. $keywords_categ .'",`title_scateg` = "'. $title_scateg .'",
	    `description_scateg` = "'. $description_scateg .'",`keywords_scateg` = "'. $keywords_scateg .'",`title_prod` = "'. $title_prod .'",`description_prod` = "'. $description_prod .'",`keywords_prod` = "'. $keywords_prod .'",
	    `title_marque` = "'. $title_marque .'" , `description_marque` = "'. $description_marque .'",`keywords_marque` = "'. $keywords_marque .'"';
	    $resultat = executeRequete($requete);
    }else{
        $requete = 'INSERT INTO `optimisation_seo` (`title_categ`,`description_categ`,`keywords_categ`,`title_prod`,`description_prod`,`keywords_prod`,`title_marque`,`description_marque`,`keywords_marque`) 
        VALUES
        ( "'. $title_categ .'", "'. $description_categ .'", "'. $keywords_categ .'", "'. $title_prod .'",  "'. $description_prod .'","'. $keywords_prod .'", "'. $title_marque .'",  "'. $description_marque .'","'. $keywords_marque .'")';
	    $resultat = executeRequete($requete);
    }	
	$msg="Optimisations SEO mis à jour avec succès.";
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $msg;?>');
		window.location = 'index.php?r=optimisationSeo';
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
                                <h4 class="card-title">Optimisations SEO</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Title catégorie </h5>
                                                <div class="controls">
                                                    <input type="text" name="title_categ" value="<?php echo $title_categ; ?>" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Description catégorie</h5>
                                                <div class="controls">
                                                    <textarea name="description_categ" class="form-control" rows="5"> <?php echo $description_categ; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Keywords catégorie</h5>
                                                <div class="controls">
                                                    <textarea name="keywords_categ" class="form-control" rows="5"> <?php echo $keywords_categ; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Title sous catégorie </h5>
                                                <div class="controls">
                                                    <input type="text" name="title_scateg" value="<?php echo $title_scateg; ?>" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Description sous catégorie</h5>
                                                <div class="controls">
                                                    <textarea name="description_scateg" class="form-control" rows="5"> <?php echo $description_scateg; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Keywords sous catégorie</h5>
                                                <div class="controls">
                                                    <textarea name="keywords_scateg" class="form-control" rows="5"> <?php echo $keywords_scateg; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Title produit </h5>
                                                <div class="controls">
                                                    <input type="text" name="title_prod" value="<?php echo $title_prod; ?>" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Description produit</h5>
                                                <div class="controls">
                                                    <textarea name="description_prod" class="form-control" rows="5"> <?php echo $description_prod; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Keywords produit</h5>
                                                <div class="controls">
                                                    <textarea name="keywords_prod" class="form-control" rows="5"> <?php echo $keywords_prod; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Title marque </h5>
                                                <div class="controls">
                                                    <input type="text" name="title_marque" value="<?php echo $title_marque; ?>" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Description marque</h5>
                                                <div class="controls">
                                                    <textarea name="description_marque" class="form-control" rows="5"> <?php echo $description_marque; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Keywords marque</h5>
                                                <div class="controls">
                                                    <textarea name="keywords_marque" class="form-control" rows="5"> <?php echo $keywords_marque; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                             
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=optimisationSeo'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
