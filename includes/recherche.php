
	<div class="main main-content-wrapper d-flex clearfix" >
    
        <div class="shop_sidebar_area">
		
    			<h4 class="mb-4"> <i class="fa fa-filter"></i> Filter par</h4>
            
            <div class="shop_sidebar_area_section">
                
                <!-- ##### Single Widget ##### -->
                <div class="widget price mb-4">
                    <!-- Widget Title -->
                    <h6 class="widget-title mb-3">Prix</h6>
    
                    <div class="widget-desc">
                        <div class="slider-range">
                            <?php
                            if ((isset($_GET['categorie']) && $_GET['categorie'] != '')){ 
                            $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits` WHERE categorie="'.idCategBlog($_GET['categorie']).'" || idparent_categ="'.idCategBlog($_GET['categorie']).'"';
                            $resprice = executeRequete($reqprice);
                            $dataprice = mysqli_fetch_array($resprice);
                        	}else{
                            $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits`';
                            $resprice = executeRequete($reqprice);
                            $dataprice = mysqli_fetch_array($resprice);
                        	}
                            ?>	
        					<input type="hidden" id="hidden_minimum_price" value="<?php echo $dataprice['min']; ?>" />
                            <input type="hidden" id="hidden_maximum_price" value="<?php echo $dataprice['max']; ?>" />
                            <p id="price_show"><?php echo $dataprice['min']; ?> DT - <?php echo $dataprice['max']; ?> DT</p>
                            <div id="price_range"></div>
                        </div>
                    </div>
                </div>
    			
    
                <!-- ##### Single Widget ##### -->
                <div class="widget brands mb-4">
                    <!-- Widget Title -->
                    <h6 class="widget-title mb-3">Catégories</h6>
    
                    <!--  Catagories  -->
                    <div class="widget-desc">
                            <?php
                            
                            if(isset($_GET['link']) && $_GET['link'] != '' ){
                                
                                $link=  sanitize($_GET['link']);
                                
                    	        $req = 'SELECT DISTINCT id,titre,link,type FROM `categories_blog` WHERE `etat` = "1" AND  `link` = "'.$link.'" ORDER BY `ordre` ASC';
                    	        $res = executeRequete($req);
                    	        
                            }elseif(isset($_GET['marque']) && $_GET['marque'] != '' ){
                                
                                $categ = isset($_GET['categorie']) ? $_GET['categorie'] :'';
                                
                    	        $req = 'SELECT DISTINCT ctg.id,ctg.titre,ctg.link,ctg.type FROM `categories_blog` ctg  WHERE ctg.etat = "1" AND ctg.link = "'.$categ.'"  ORDER BY ctg.ordre ASC';
                    	        //echo $req;
                    	        $res = executeRequete($req);
                    	        
                            }elseif(isset($_POST['recherche']) && $_POST['recherche'] != '' ){
                            
                                $idcateg=  categorieBySearchProduits(str_replace (" ","%",$_POST['recherche']));
                                
                    	        $req = 'SELECT DISTINCT id,titre,link,type FROM `categories_blog` WHERE `etat` = "1" AND  `id` = "'.$idcateg.'" ORDER BY `ordre` ASC';
                    	        
                    	        $res = executeRequete($req);
                    	        
                            }else{
                                
                                $req = 'SELECT DISTINCT id,titre,link,type FROM `categories_blog` WHERE `etat` = "1" ORDER BY `ordre` ASC';
                    	        $res = executeRequete($req);
                    	        
                            }
                    	        while ($data1 = mysqli_fetch_array($res)) 
                    	        { 
                    	   ?>
                    	   
                    	    <!-- Single Form Check -->
                            <div class="form-check">
                                <input class="form-check-input common_selector category" type="checkbox" value="<?php echo afficheChamp($data1['id']); ?>" id="<?php echo afficheChamp1($data1['titre']); ?>"  <?php if( isset($_GET['link']) && lienCategorieEquipements($data1['link']) == lienCategorieEquipements($_GET['link']) ) echo 'checked'; ?>>
    	                        <label class="form-check-label" for="<?php echo afficheChamp1($data1['titre']); ?>"> <?php echo afficheChamp1($data1['titre']); ?> </label>
    	                       
    			                <input class="form-check-input common_selector link" type="checkbox" id="linkProd" value="<?php if(isset($_GET['link']) && $_GET['link'] != '' ){ echo afficheChamp($data1['id']); }  ?>" checked style='display:none' >
    			                <input class="form-check-input common_selector type" type="checkbox" id="typeProd" value="<?php  if(isset($_GET['promo'])){ echo ''; }else{ echo $data1['type']; } ?>" checked style='display:none' >
    			                
    	                   </div>
    	                   
    	                   <?php } ?>
                    </div>
                </div>
    
                <!-- ##### Single Widget ##### -->
                <div class="widget brands mb-4">
                    <!-- Widget Title -->
                    <h6 class="widget-title mb-3">Marques</h6>
    
                    <div class="widget-desc">
                        <?php
    					if(isset($_GET['link']) && $_GET['link'] != '' ){
    						$idCategProd = idCategBlog($_GET['link']);
    						//echo $idCategProd;
                    	    $req1 = "SELECT id,raison FROM `marques` WHERE id IN (SELECT marque FROM `produits` WHERE `categorie` = '".$idCategProd."') AND `etat`= '1' ORDER BY `ordre` ASC";
                    	    $res1 = executeRequete($req1);
                    	    
                    	}elseif(isset($_GET['marque']) && $_GET['marque'] != '' ){
                    	    
    						$mrq = sanitize($_GET['marque']);
    						
                    	    $req1 = "SELECT id,raison FROM `marques` WHERE `link` = '".$mrq."' AND `etat`= '1' ORDER BY `ordre` ASC";
                    	    $res1 = executeRequete($req1); 
                    	    
                    	}else{ 
    						$req1 = "SELECT DISTINCT id,raison FROM `marques` WHERE `etat`= '1' ORDER BY `ordre` ASC";
                    	    $res1 = executeRequete($req1);
    					}
                    	        while ($data2 = mysqli_fetch_array($res1)) 
                    	        { 
    					
    					?>
    					
                        <!-- Single Form Check -->
                        <div class="form-check">
                            <input class="form-check-input common_selector brand" type="checkbox" value="<?php echo afficheChamp($data2['id']); ?>" id="<?php echo afficheChamp($data2['raison']); ?>">
                            <label class="form-check-label" for="<?php echo afficheChamp($data2['raison']); ?>"><?php echo afficheChamp($data2['raison']); ?></label>
                        </div>
    					<?php   } ?>
                        
                    </div>
                </div>
                <!-- ##### Single Widget ##### -->
                <div class="widget brands mb-4">
                    <?php
    					
    					if(isset($_GET['link']) && $_GET['link'] != '' ){
    						 $idCategProd = idCategBlog($_GET['link']);
                        	 $req3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' AND  `idproduit` IN (SELECT id FROM `produits` WHERE `categorie` = '".$idCategProd."') GROUP BY idcarac ORDER BY `id` ASC";
                        	 //echo $req3; 
                        	 $res3 = executeRequete($req3);
    					}else{
    						 // $idCategProd = idCategBlog($_GET['link']); // Removed undefined index access
                        	 $req3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' GROUP BY idcarac ORDER BY `id` ASC";
                        	 $res3 = executeRequete($req3);
    					    
    					}
                    	 while ($data3 = mysqli_fetch_array($res3)) 
                    	   { 
                    	       $req4 = 'SELECT * FROM `caracteristique_prod`  WHERE valeur != "0" AND `idcarac`= "'.$data3['idcarac'].'" GROUP BY valeur ORDER BY `id` ASC';
                    	       //echo $req4; 
                        	   $res4 = executeRequete($req4);
                    	       $numRows = mysqli_num_rows($res4);
                    	       if($numRows > 0){
                    ?>
                    <!-- Widget Title -->
                    <h6 class="widget-title mb-3"><?php echo titreCaracteristiques($data3['idcarac']); ?></h6>
    
                    <div class="widget-desc mb-3">
                        <?php
    					
                    	        while ($data4 = mysqli_fetch_array($res4)) 
                    	        { 
                    	?>
                        <!-- Single Form Check -->
                        <div class="form-check">
                            <input class="form-check-input common_selector caracteristique" type="checkbox" value="<?php echo valeurCaracteristiques($data4['valeur']); ?>" id="<?php echo $data4['id'].'-'.nett(valeurCaracteristiques($data4['valeur'])); ?>">
                            <label class="form-check-label" for="<?php echo $data4['id'].'-'.nett(valeurCaracteristiques($data4['valeur'])); ?>"><?php echo valeurCaracteristiques($data4['valeur']); ?></label>
                        </div>
                        
                        <?php } ?>
                        
                    </div>
                    <?php } } ?>
                </div>
    
                
            </div>
    
    			<div class="line"></div>
    			 <?php $nbArticles = isset($_SESSION['panier']['idcart']) ? count($_SESSION['panier']['idcart']) : 0; ?>
    			<!-- Cart Menu -->
                <div class="cart-fav-search mb-100">
                    <a href="<?php echo lienPanier();?>" class="cart-nav" id="blocDepartementsPanier"><img src="dist/img/cart.png" alt=""> Panier <span id="lblCartCount">(<?php  if ($nbArticles) echo ''.$nbArticles.''; else echo '0'; ?>)</span></a>
                </div>
        
        </div>

        <div class="amado_product_area section-padding-40">
			<?php
			$variable2='<li class="breadcrumb-item " aria-current="page"><a href="'.lienRecherche().'">Recherche</a></li>';
			$variable3 = '';
			$variable4 = '';
			if(isset($_GET['link']) && $_GET['link'] != '' ){	
			$link=  sanitize($_GET['link']); 	
			$variable3='<li class="breadcrumb-item active" aria-current="page">'.titreCategories($link).'</li>';
			}
			if((isset($_POST['action']) && $_POST['action'] == 'search') ){	
			    $recherche=  sanitize($_POST['recherche']);
			    if($recherche !=''){ 	
			    $variable3='<li class="breadcrumb-item active" aria-current="page">'.$recherche.'</li>';
			    }
			}
			if((isset($_POST['action']) && $_POST['action'] == 'search1') ){	
			    $recherche=  sanitize($_POST['recherche']);
			    if($recherche !=''){ 	
			    $variable3='<li class="breadcrumb-item active" aria-current="page">'.$recherche.'</li>';
			    }
			}
			if(((isset($_GET['marque']) && $_GET['marque'] != '') && (isset($_GET['categorie']) && $_GET['categorie'] != ''))){
			    
			    $variable3='<li class="breadcrumb-item" aria-current="page"><a href="'.lienSearch($_GET['categorie']).'">'.$_GET['categorie'].'</a></li>';
			    
			    $variable4='<li class="breadcrumb-item active" aria-current="page">'.$_GET['marque'].'</li>';
			    
			}
			if(isset($_GET['search']) && $_GET['search'] != ''){
			    
			    $variable3='<li class="breadcrumb-item active" aria-current="page">'.$_GET['search'].'</li>';
			    
			}
			
			?>
			
			<!-----------------------Breadcrumb------------------->
			<div class="single-product-area">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb pl-0">
									 <li class="breadcrumb-item"><a href="<?php echo lienAccueil();?>">Accueil</a></li>
										<?php echo $variable2;?>
										<?php echo $variable3;?>
										<?php echo $variable4;?>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<?php
			
			if((isset($_POST['action']) && $_POST['action'] == 'search') || (isset($_GET['search']) && $_GET['search'] != '') || (isset($_POST['recherche']) && $_POST['recherche'] != '') || ((isset($_GET['marque']) && $_GET['marque'] != '') && (isset($_GET['categorie']) && $_GET['categorie'] != '')) ){	
			    $recherche=  isset($_POST['recherche']) ? sanitize($_POST['recherche']) : '';	
			?>
			<!--------------------------------------------------->
			<div class="container-fluid">
			    
			    <div class="row">
			        <div class="col-lg-7 mb-4">
    			        <form action="<?php echo lienRecherche(); ?>" method="POST" class="p-4 border border-light bg-light">
    					    <div class="form-group">
        		                <input type="text" class="form-control mb-3" name="recherche" placeholder="Rechercher..." value="<?php if((isset($_POST['action']) && $_POST['action'] == 'search1')){ echo $_POST['recherche']; } elseif((isset($_POST['action']) && $_POST['action'] == 'search')){ echo $_POST['recherche']; } else { echo  ''; }  ?>" aria-label="Text input with dropdown button">
        		                <select name="categorie" class="form-control slect2">
        		                    <option>--Sélectionnez catégorie--</option>
        		                    <?php 
        		                    $categ = '';
        		                    if(isset($_GET['search']) && $_GET['search'] != ''){
    			                            $categ     =  idCategBlog($_GET['search']);
            		                }elseif(isset($_GET['categorie']) && $_GET['categorie'] != ''){
    			                            $categ     =  idCategBlog($_GET['categorie']);
            		                }elseif(isset($_POST['categorie']) && $_POST['categorie'] != ''){
    			                            $categ     =  $_POST['categorie'];
            		                }
    					            $requete = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ';
                                    $resultat = executeRequete($requete);
    	                            $num = mysqli_num_rows($resultat);
    		                            if ($num > 0 ) { 
    			                            while ($data = mysqli_fetch_array($resultat))  {
    							    ?>
    							        <option value="<?php echo afficheChamp($data['id']); ?>" <?php if($categ == $data['id']) echo 'selected'; ?>> <?php echo afficheChamp1($data['titre']); ?></option>
    							        <?php
    							            $idpctg    = afficheChamp($data['id']);
    							            $requete1  = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$idpctg.'" ';
                                            $resultat1 = executeRequete($requete1);
    			                            while ($datasc = mysqli_fetch_array($resultat1))  {
    							        ?>
    							        <option value="<?php echo afficheChamp($datasc['id']); ?>" <?php if($categ == $datasc['id']) echo 'selected'; ?>> -- <?php echo afficheChamp1($datasc['titre']); ?></option>
    							        <?php } ?>
    							    <?php } }  ?>
        		                </select>
        		                <button type="submit" class="btn btn-acces mt-3"><i class="fa fa-search border-right pr-2 mr-2"></i> Recherche</button>
    		                </div>
                            <input type="hidden" name="action" value="search1">
    		            </form>
		            </div>
                </div>
			</div>
            <div class="container-fluid filter_data">
                
            </div>
            <?php 
			}else{ ?>
			
			<div class="container-fluid">
			    
			    <div class="row">
			        <div class="col-lg-7 mb-4">
    			        <form action="<?php echo lienRecherche(); ?>" method="POST" class="p-4 border border-light bg-light">
    					    <div class="form-group">
        		                <input type="text" class="form-control mb-3" name="recherche" placeholder="Rechercher..." value="<?php if((isset($_POST['action']) && $_POST['action'] == 'search1')){ echo addslashes($_POST['recherche']); } else { echo  ''; }  ?>" aria-label="Text input with dropdown button">
        		                <select name="categorie" class="form-control slect2">
        		                    <option>--Sélectionnez catégorie--</option>
        		                    <?php 
        		                    $categ = '';
        		                    if((isset($_POST['action']) && $_POST['action'] == 'search1')){
			                            $categ     =  sanitize($_POST['categorie']);
        		                    }
        		                    
    					            $requete = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ';
                                    $resultat = executeRequete($requete);
    	                            $num = mysqli_num_rows($resultat);
    		                            if ($num > 0 ) { 
    			                            while ($data = mysqli_fetch_array($resultat))  {
    							    ?>
    							        <option value="<?php echo afficheChamp($data['id']); ?>" <?php if($categ == $data['id']) echo 'selected'; ?> > <?php echo afficheChamp1($data['titre']); ?></option>
    							        <?php
    							            $idpctg    = afficheChamp($data['id']);
    							            $requete1  = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$idpctg.'" ';
                                            $resultat1 = executeRequete($requete1);
    			                            while ($datasc = mysqli_fetch_array($resultat1))  {
    							        ?>
    							        <option value="<?php echo afficheChamp($datasc['id']); ?>" <?php if($categ == $datasc['id']) echo 'selected'; ?> > -- <?php echo afficheChamp1($datasc['titre']); ?></option>
    							        <?php } ?>
    							    <?php } }  ?>
        		                </select>
        		                <button type="submit" class="btn btn-acces mt-3"><i class="fa fa-search border-right pr-2 mr-2"></i> Recherche</button>
    		                </div>
                            <input type="hidden" name="action" value="search1">
    		            </form>
		            </div>
                </div>
			    <div class="row">
    		        <?php if((isset($_POST['action']) && $_POST['action'] == 'search1') ){
    		                
			                $recherche =  sanitize($_POST['recherche']);
			                $categ     =  sanitize($_POST['categorie']);
			                $req = "SELECT * FROM categories_blog ctg, categories_marques cm WHERE cm.idcategorie = '$categ' && ctg.id = '$categ' ";
                            $res = executeRequete($req);
    		                while ($datactg = mysqli_fetch_array($res))  {
    		        ?>
			        <div class="col-sm-2 mb-3 marque-logo">
    		            <a href="<?php echo lienRechercheByCM(linkMarque($datactg['idmarque']),linkParentCategBlog($categ)); ?>">
    		                <div class="card">
    		                    <img src="<?php echo photoMarqueSite($datactg['idmarque']); ?>" class="img-fluid p-lg-3 p-md-2">
    		                </div>
    		            </a>
		            </div>
    		        <?php } ?>
    		        <?php } ?>
                </div>
            </div>
			    
			<?php }
			?>
        </div>
    
    
	</div>