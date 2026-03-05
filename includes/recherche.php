
	<div class="main main-content-wrapper d-flex clearfix" >
    
        <div class="shop_sidebar_area d-none d-lg-block bg-white p-4 rounded-3xl shadow-sm border mt-4 ms-3 mb-4">
    		
    			<h4 class="mb-4" style="color:var(--shop-primary);"> <i class="fa fa-filter"></i> Filter par</h4>
            
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
                    	    $req1 = "SELECT id,raison FROM `marques` WHERE id IN (SELECT marque FROM `produits` WHERE `categorie` = '".$idCategProd."' OR `idparent_categ` = '".$idCategProd."') AND `etat`= '1' ORDER BY `ordre` ASC";
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
                        	 $req3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' AND  `idproduit` IN (SELECT id FROM `produits` WHERE `categorie` = '".$idCategProd."' OR `idparent_categ` = '".$idCategProd."') GROUP BY idcarac ORDER BY `id` ASC";
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
			$variable2='<li class="breadcrumb-item text-secondary" aria-current="page"><a href="'.lienRecherche().'" class="text-decoration-none text-secondary">Recherche</a></li>';
			$variable3 = '';
			$variable4 = '';
			if(isset($_GET['link']) && $_GET['link'] != '' ){	
			$link=  sanitize($_GET['link']); 	
			$variable3='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.titreCategories($link).'</li>';
			}
			if((isset($_POST['action']) && $_POST['action'] == 'search') ){	
			    $recherche=  sanitize($_POST['recherche']);
			    if($recherche !=''){ 	
			    $variable3='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.$recherche.'</li>';
			    }
			}
			if((isset($_POST['action']) && $_POST['action'] == 'search1') ){	
			    $recherche=  sanitize($_POST['recherche']);
			    if($recherche !=''){ 	
			    $variable3='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.$recherche.'</li>';
			    }
			}
			if(((isset($_GET['marque']) && $_GET['marque'] != '') && (isset($_GET['categorie']) && $_GET['categorie'] != ''))){
			    $variable3='<li class="breadcrumb-item text-secondary" aria-current="page"><a href="'.lienSearch($_GET['categorie']).'" class="text-decoration-none text-secondary">'.titreCategories($_GET['categorie']).'</a></li>';
			    $variable4='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.$_GET['marque'].'</li>';
			}
			if(isset($_GET['search']) && $_GET['search'] != ''){
			    $variable3='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.$_GET['search'].'</li>';
			}
			
			?>
			
			<!-----------------------Breadcrumb------------------->
			<div class="single-product-area mt-4 mb-3">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb bg-light d-inline-flex px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.85rem; font-weight: 500;">
									 <li class="breadcrumb-item"><a href="<?php echo lienAccueil();?>" class="text-secondary text-decoration-none"><i class="fa fa-home"></i> Accueil</a></li>
										<?php echo $variable2;?>
										<?php echo $variable3;?>
										<?php echo $variable4;?>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>

            <!-- MOBILE FILTERS -->
            <div class="d-block d-lg-none container-fluid mb-4">
                <button class="btn w-100 d-flex justify-content-between align-items-center fw-bold px-4 py-3 shadow-sm border" id="mobileFiltersToggle" type="button"
                    style="background:#fff; border-color: var(--shop-primary,#5A31F4); border-radius: 0.75rem; color: var(--shop-primary,#5A31F4);">
                    <span><i class="fa fa-filter me-2"></i> Filtres</span>
                    <i class="fa fa-chevron-down" id="mobileFiltersChevron"></i>
                </button>
                <div id="mobileFilters" style="display:none;">
                    <div class="bg-white p-4 shadow-sm border mt-2" style="border-radius: 0.75rem; border-color: var(--shop-border, #E0DEFF)!important;">
                        <!-- Price Range Informative for mobile -->
                        <div class="mb-3 border-bottom pb-2">
                            <label class="fw-semibold small" style="color:var(--shop-text-secondary,#6B6589)">Budget</label>
                            <p class="small mb-2" id="price_show_mobile">Ajustez le curseur en haut</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid filter_data" style="min-height:200px">
                
            </div>

<script>
/* Mobile filters toggle */
(function(){
    var btn = document.getElementById('mobileFiltersToggle');
    var panel = document.getElementById('mobileFilters');
    var chevron = document.getElementById('mobileFiltersChevron');
    if(!btn || !panel) return;
    btn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var isOpen = panel.style.display !== 'none';
        panel.style.display = isOpen ? 'none' : 'block';
        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });
})();
</script>
        </div>
    
    
	</div>