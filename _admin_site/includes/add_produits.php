<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php

    if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idb   = $_GET['idb'];
		supprimerListeProduits($_GET['idsc']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduits&id=<?php echo $idb; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idbloc    = formReception($_POST['id']);
	$en_promo  = formReception($_POST['en_promo']);
	$categorie = formReception($_POST['categorie']);
	$marque    = formReception($_POST['marque']);
    $idproduit = formReception($_POST['idproduit'] ?? 0);
	
		$requete = 'INSERT INTO `liste_produits` (`idbloc`,`en_promo`, `categorie`, `marque`, `idproduit`) VALUES ("'. $idbloc .'","'. $en_promo .'","'. $categorie .'","'. $marque .'","'.$idproduit.'")';
		$result = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduits&id=<?php echo $idbloc; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Détails section : <?php echo titreListeSection(typeSectionBloc($_GET['id'])); ?></h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Produit Spécifique</th>
                                                <th>En promo</th>
                                                <th>Catégorie / Règle</th>
                                                <th>Marque</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `liste_produits` WHERE `idbloc` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
                                             $nom_produit = "-";
                                             if(!empty($data['idproduit']) && $data['idproduit'] > 0) {
                                                 // Fetch exact product name
                                                 $req_p = executeRequete("SELECT titre FROM produits WHERE id='".$data['idproduit']."'");
                                                 if($row_p = mysqli_fetch_assoc($req_p)) {
                                                     $nom_produit = "<strong>".htmlspecialchars($row_p['titre'])."</strong>";
                                                 } else {
                                                     $nom_produit = "<em>Produit Introuvable</em>";
                                                 }
                                             }
								         ?>
                                            <tr>
                                                <td><?php echo $nom_produit; ?></td>
                                                <td><?php if($data['en_promo'] == 0) echo 'Non'; else echo 'Oui'; ?></td>
                                                <td><?php echo titreCategBlog($data['categorie']); ?></td>
                                                <td><?php echo raisonByLinkMarque($data['marque']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=editproduits&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=addproduits&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucune détail trouvée</td>
                                        </tr>
                                        <?php } ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter détail</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
									<div class="form-group">
                                        <label class="control-label">En promo</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="en_promo" type="radio" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="en_promo" type="radio" checked value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Produit Spécifique (Recherche Live)</h5>
                                                <div class="controls position-relative">
                                                    <input type="text" id="live_search_produit" class="form-control" autocomplete="off" placeholder="Tapez le nom du produit... (Laissez vide pour sélectionner une catégorie)">
                                                    <input type="hidden" name="idproduit" id="idproduit_hidden" value="0">
                                                    <div id="live_search_results" style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid #ccc; max-height:200px; overflow-y:auto; z-index:100; display:none; border-radius:4px; box-shadow:0 4px 10px rgba(0,0,0,0.1);"></div>
                                                </div>
                                                <small class="text-muted">Si vous sélectionnez un produit précis, la catégorie/marque ci-dessous servent de solution de repli. <b>Il est préférable de laisser les champs de catégorie vides si vous choisissez un produit.</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Catégorie</h5>
											<div class="controls">
												<select name="categorie" id="select1" class="form-control">
												
													
													<option value="">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" >--> <?php echo afficheChamp1($data1['titre']); ?></option>
        	                                      <?php 
        	                                       } 
        	                                     } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Marque</h5>
											<div class="controls">
												<select name="marque" id="select2" class="form-control">
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `marques` WHERE `etat` = "1" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['link']; ?>"><?php echo afficheChamp($data['raison']); ?></option>
                                                <?php 
        	                                        } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <input name="action" type="hidden" id="action" value="ajt">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('live_search_produit');
    const hiddenInput = document.getElementById('idproduit_hidden');
    const resultsContainer = document.getElementById('live_search_results');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        hiddenInput.value = "0";

        if(query.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetch('ajax_search_products.php?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                if(data.length === 0) {
                    resultsContainer.innerHTML = '<div style="padding:15px; color:#999; text-align:center;">Aucun produit trouvé.</div>';
                } else {
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.style.display = 'flex';
                        div.style.alignItems = 'center';
                        div.style.padding = '10px 15px';
                        div.style.cursor = 'pointer';
                        div.style.borderBottom = '1px solid #f0f0f0';
                        div.style.transition = 'background 0.2s';
                        
                        const img = item.photo ? `<img src="../${item.photo}" style="width:40px; height:40px; object-fit:contain; margin-right:12px; border-radius:4px; background:#fff; border:1px solid #eee;">` : `<div style="width:40px; height:40px; margin-right:12px; background:#f5f5f5; border-radius:4px;"></div>`;
                        
                        div.innerHTML = `
                            ${img}
                            <div style="flex:1; min-width:0;">
                                <div style="font-weight:600; font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#333;">${item.titre}</div>
                                <div style="font-size:12px; color:var(--info); font-weight:bold;">${item.prix}</div>
                            </div>
                            <div style="color:#bbb; font-size:12px;"><i class="fa fa-plus-circle"></i></div>
                        `;
                        
                        div.addEventListener('mouseover', () => div.style.backgroundColor = '#f8f9fa');
                        div.addEventListener('mouseout', () => div.style.backgroundColor = 'transparent');
                        
                        div.addEventListener('click', () => {
                            searchInput.value = item.titre;
                            hiddenInput.value = item.id;
                            resultsContainer.style.display = 'none';
                            // Submit the form immediately to "add to table"
                            searchInput.closest('form').submit();
                        });
                        resultsContainer.appendChild(div);
                    });
                }
                resultsContainer.style.display = 'block';
            })
            .catch(err => {
                console.error(err);
                resultsContainer.innerHTML = '<div style="padding:10px; color:red;">Erreur de chargement.</div>';
            });
        }, 300);
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if(!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.style.display = 'none';
        }
    });
});
</script>