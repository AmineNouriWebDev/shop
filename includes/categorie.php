
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
                            if ((isset($_GET['link']) && $_GET['link'] != '')){ 
                            $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits` WHERE categorie="'.idCategBlog($_GET['link']).'" || idparent_categ="'.idCategBlog($_GET['link']).'"';
                            $resprice = executeRequete($reqprice);
                            $dataprice = mysqli_fetch_array($resprice);
                        	}elseif ((isset($_GET['promo']) )){ 
                            $reqprice = 'SELECT MIN(prix_promo) as min, MAX(prix_promo) as max FROM `produits` WHERE prix_promo !="0.000"';
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
    	                       
    
    		                
    	                   </div>
    	                   
    	                   <?php } ?>
                    </div>
                </div>
    
                <!-- ##### Single Widget ##### -->
                <div class="widget brands mb-4">
                    <!-- Widget Title -->
                    <h6 class="widget-title mb-3">Marques</h6>
    
                    <div class="widget-desc">
                   <input type="hidden" id="linkProd" value="<?php if(isset($_GET['link']) && $_GET['link'] != '' ){ echo idCategBlog($_GET['link']); }  ?>" >
                   <input type="hidden" id="typeProd" value="" >
                        <?php
    					if(isset($_GET['link']) && $_GET['link'] != '' ){
    						$idCategProd = idCategBlog($_GET['link']);
                    	    $req1 = "SELECT id,raison FROM `marques` WHERE id IN (SELECT marque FROM `produits` WHERE `categorie` = '".$idCategProd."') AND `etat`= '1' ORDER BY `ordre` ASC";
                    	    $res1 = executeRequete($req1);
                    	        while ($data2 = mysqli_fetch_array($res1)) 
                    	        { 
                    	?>
                        <!-- Single Form Check -->
                        <div class="form-check">
                            <input class="form-check-input common_selector brand" type="checkbox" value="<?php echo afficheChamp($data2['id']); ?>" id="<?php echo afficheChamp($data2['raison']); ?>">
                            <label class="form-check-label" for="<?php echo afficheChamp($data2['raison']); ?>"><?php echo afficheChamp($data2['raison']); ?></label>
                        </div>
                        
                        <?php   }
    					
    					}else{ 
    						$req1 = "SELECT DISTINCT id,raison FROM `marques` WHERE `etat`= '1' ORDER BY `ordre` ASC";
                    	    $res1 = executeRequete($req1);
                    	        while ($data2 = mysqli_fetch_array($res1)) 
                    	        { 
    					
    					?>
    					
                        <!-- Single Form Check -->
                        <div class="form-check">
                            <input class="form-check-input common_selector brand" type="checkbox" value="<?php echo afficheChamp($data2['id']); ?>" id="<?php echo afficheChamp($data2['raison']); ?>">
                            <label class="form-check-label" for="<?php echo afficheChamp($data2['raison']); ?>"><?php echo afficheChamp($data2['raison']); ?></label>
                        </div>
    					<?php   }
    					
    					} ?>
                        
                    </div>
                </div>
                <!-- ##### Single Widget ##### -->
                <div class="widget brands mb-4">
                    <?php
    				
    				if(isset($_GET['link']) && $_GET['link'] != '' ){
    					 $idCategProd = idCategBlog($_GET['link']);
                    	 $req3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' AND  `idproduit` IN (SELECT id FROM `produits` WHERE `categorie` = '".$idCategProd."') GROUP BY idcarac ORDER BY `id` ASC";
                    	 $res3 = executeRequete($req3);
    				}else{
    					 $idCategProd = idCategBlog($_GET['link']);
                    	 $req3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' GROUP BY idcarac ORDER BY `id` ASC";
                    	 $res3 = executeRequete($req3);
    				    
    				}
                	 while ($data3 = mysqli_fetch_array($res3)) 
                	   { 
                	       $req4 = 'SELECT * FROM `caracteristique_prod`  WHERE valeur != "0" AND `idcarac`= "'.$data3['idcarac'].'" GROUP BY valeur ORDER BY `id` ASC';
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
    			<?php //$nbArticles=count($_SESSION['panier']['idcart']); ?>
    			<!-- Cart Menu -->
                <!--div class="cart-fav-search mb-100">
                    <a href="<?php //echo lienPanier();?>" class="cart-nav" id="blocDepartementsPanier"><img src="dist/img/cart.png" alt=""> Panier <span id="lblCartCount">(<?php  if ($nbArticles) echo ''.$nbArticles.''; else echo '0'; ?>)</span></a>
                </div-->
        
        </div>

        <div class="amado_product_area section-padding-40">
			<?php
			$variable2='<li class="breadcrumb-item text-secondary" aria-current="page"><a href="'.lienCategorie().'" class="text-decoration-none text-secondary">Catalogue</a></li>';
			$variable3 = ''; // Initialize to prevent undefined variable warning
			$variable4 = ''; // Initialize to prevent undefined variable warning
			
			if(isset($_GET['promo'])){		
			$variable3='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">En promotions</li>';
			}
			if(isset($_GET['linkp']) && $_GET['linkp'] != '' ){	
			$linkp=  sanitize($_GET['linkp']); 	
			$variable3='<li class="breadcrumb-item text-secondary" aria-current="page"><a href="'.lienCategories($linkp).'" class="text-decoration-none text-secondary">'.titreCategories($linkp).'</a></li>';
			}
			if(isset($_GET['link']) && $_GET['link'] != '' ){	
			$link=  sanitize($_GET['link']); 	
			$variable4='<li class="breadcrumb-item active fw-bold text-primary" aria-current="page">'.titreCategories($link).'</li>';
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
                        
                        <!-- Categories Dropdown -->
                        <div class="form-group mb-3">
                            <label class="fw-semibold small" style="color:var(--shop-text-secondary,#6B6589)">Catégories</label>
                            <select class="form-control common_selector category" style="height:auto; padding: 0.6rem 1rem; font-size: 0.9rem; border-color: var(--shop-border,#E0DEFF); border-radius: 0.5rem;">
                                <option value="">Toutes les catégories</option>
                                <?php
                                if(isset($_GET['link']) && $_GET['link'] != '' ){
                                    $link=  sanitize($_GET['link']);
                        	        $reqM = 'SELECT DISTINCT id,titre,link,type FROM `categories_blog` WHERE `etat` = "1" AND  `link` = "'.$link.'" ORDER BY `ordre` ASC';
                                }else{
                                    $reqM = 'SELECT DISTINCT id,titre,link,type FROM `categories_blog` WHERE `etat` = "1" ORDER BY `ordre` ASC';
                                }
                                $resM = executeRequete($reqM);
                                while ($dataM = mysqli_fetch_array($resM)) { 
                                    $sel = (isset($_GET['link']) && lienCategorieEquipements($dataM['link']) == lienCategorieEquipements($_GET['link'])) ? 'selected' : '';
                                    echo '<option value="'.afficheChamp($dataM['id']).'" '.$sel.'>'.afficheChamp1($dataM['titre']).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Marques Dropdown -->
                        <div class="form-group mb-3">
                            <label class="fw-semibold small" style="color:var(--shop-text-secondary,#6B6589)">Marques</label>
                            <select class="form-control common_selector brand" style="height:auto; padding: 0.6rem 1rem; font-size: 0.9rem; border-color: var(--shop-border,#E0DEFF); border-radius: 0.5rem;">
                                <option value="">Toutes les marques</option>
                                <?php
    			if(isset($_GET['link']) && $_GET['link'] != '' ){
    				$idCategProd = idCategBlog($_GET['link']);
                    	    $reqM2 = "SELECT id,raison FROM `marques` WHERE id IN (SELECT marque FROM `produits` WHERE `categorie` = '".$idCategProd."') AND `etat`= '1' ORDER BY `ordre` ASC";
    			}else{ 
    				$reqM2 = "SELECT DISTINCT id,raison FROM `marques` WHERE `etat`= '1' ORDER BY `ordre` ASC";
    			}
                                $resM2 = executeRequete($reqM2);
                                while ($dataM2 = mysqli_fetch_array($resM2)) { 
                                    echo '<option value="'.afficheChamp($dataM2['id']).'">'.afficheChamp($dataM2['raison']).'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Characteristics Dropdowns -->
                        <?php
    					if(isset($_GET['link']) && $_GET['link'] != '' ){
    					 $idCategProd = idCategBlog($_GET['link']);
                        	 $reqM3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' AND  `idproduit` IN (SELECT id FROM `produits` WHERE `categorie` = '".$idCategProd."') GROUP BY idcarac ORDER BY `id` ASC";
    					}else{
                        	 $reqM3 = "SELECT * FROM `caracteristique_prod` WHERE valeur != '0' GROUP BY idcarac ORDER BY `id` ASC";
    					}
                    	 $resM3 = executeRequete($reqM3);
                    	 while ($dataM3 = mysqli_fetch_array($resM3)) { 
                    	       $reqM4 = 'SELECT * FROM `caracteristique_prod`  WHERE valeur != "0" AND `idcarac`= "'.$dataM3['idcarac'].'" GROUP BY valeur ORDER BY `id` ASC';
                        	   $resM4 = executeRequete($reqM4);
                    	       if(mysqli_num_rows($resM4) > 0){
                        ?>
                        <div class="form-group mb-3">
                            <label class="fw-semibold small" style="color:var(--shop-text-secondary,#6B6589)"><?php echo titreCaracteristiques($dataM3['idcarac']); ?></label>
                            <select class="form-control common_selector caracteristique" style="height:auto; padding: 0.6rem 1rem; font-size: 0.9rem; border-color: var(--shop-border,#E0DEFF); border-radius: 0.5rem;">
                                <option value="">Tous</option>
                                <?php while ($dataM4 = mysqli_fetch_array($resM4)) { ?>
                                <option value="<?php echo valeurCaracteristiques($dataM4['valeur']); ?>"><?php echo valeurCaracteristiques($dataM4['valeur']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php } } ?>

                    </div>
                </div>
            </div>
            <!-- END MOBILE FILTERS -->

			<?php
			if(isset($_GET['promo'])){?>
			
			<!--------------------------------------------------->
            <div class="container-fluid filter_data">
                <!-- min-height prevents layout jump while AJAX loads -->
                <div style="min-height:200px"></div>
            </div>
			    
			<?php }
			elseif( (isset($_GET['link']) && $_GET['link'] != '') && !(isset($_GET['linkp'])) ){
			?>
			
			
			<div class="container-fluid">
			    <div class="border-bottom mb-3">
			        <h3 style="font-size:20px">Selectionnez votre marque préférée :</h3>
			    </div>
			    <div class="row">
    		        <?php 
				            $categ     =  sanitize($_GET['link']);
				            $idc       = idCategBlog($categ);
				            $req = "SELECT DISTINCT pr.marque FROM categories_blog ctg, produits pr WHERE pr.idparent_categ = '$idc' && ctg.link = '$categ' ";
                            $res = executeRequete($req);
    		            while ($datactg = mysqli_fetch_array($res))  {
    		        ?>
				        <div class="col-sm-2 mb-3 marque-logo">
    		            <a href="<?php echo lienRechercheByCM(linkMarque($datactg['marque']),$categ); ?>">
    		                <div class="card d-flex align-items-center justify-content-center" style="min-height:100px; border: 1px solid var(--shop-border,#E0DEFF); border-radius: 0.75rem; transition: 0.2s; cursor:pointer;">
    		                    <img src="<?php echo photoMarqueSite($datactg['marque']); ?>" class="img-fluid p-lg-3 p-md-2" style="object-fit:contain; max-height:70px;">
    		                </div>
    		            </a>
				            </div>
    		        <?php }  ?>
                </div>
            </div>
            
            <!----------------------------------------------------->
            <div class="container-fluid filter_data" style="min-height:200px">
                
            </div>
            <?php 
			}elseif( !(isset($_GET['link'])) && !(isset($_GET['linkp'])) ){
			    
			    $output ="";
        		
        		$output .="<div class='container-fluid filter_data'>";
			
        		$query = "	SELECT DISTINCT ctg.id, ctg.link, ctg.titre FROM produits pr, categories_blog ctg WHERE pr.etat = '1' AND ctg.idparent = '0' ";
        		$result 	= executeRequete($query);
        		
        		$total_row	= mysqli_num_rows($result);
        		
        		if($total_row > 0)
        		{
        			
        			$output .= '
        				
        					<div class="row">
        						<div class="col-sm-12">
        							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
        								<!-- Total Products -->
        								<div class="total-products">
        									<p> Il y a '.$total_row.' catégories.</p>
        								</div>
        							</div>
        						</div>
        					</div>';
        			$output .= '
        
        					<div class="row animated fadeInUp" data-delay="1s">';
        			while($row = mysqli_fetch_array($result))
        			{
        				if($row['id'])    $id_categ    = $row['id']; 
        				if($row['link'])  $link_categ  = $row['link']; 
        				
        				$output .= '
        				
        					
        					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-4">
        						<div class="single-product-wrapper h-wrapper border p-4 text-center hoverDiv" style="height:300px">
        							<!-- Product Image -->
        							<a href="'. lienCategories($link_categ).'" class="product-img hover-zoom bg-white">
        								<img src="'. photoCategBlog($id_categ).'" alt="" class="img-fluid">
        							</a>
        							
        
        							<!-- Product Description -->
        							<div class="product-description d-flex align-items-center justify-content-center">
        								<!-- Product Meta Data -->
        								<div class="product-meta-data">';
        								$output .= '<a href="'. lienCategories($link_categ).'" class="text-center">
        									<h6>'. titreCategBlog($id_categ).'</h6>
        								</a>
        							</div>
        						</div>
        					</div>
        				</div>';

        		}


        		
                    $output.= '</div>';
        
        		}
        		else
        		{
        				$output = '
        				
        					<div class="row">
        						<div class="col-12">
        							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
        								<!-- Total Products -->
        								<div class="total-products">
        									<p> Il y a 0 produits.</p>
        								</div>
        							</div>
        						</div>
        						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucune catégorie trouvée </h5></div>
        				    </div>';
        		}
        		
        		$output .="</div>";
        		
        		echo $output;
			}else{ ?>
			
			<!--------------------------------------------------->
            <div class="container-fluid filter_data" style="min-height:200px">
                
            </div>
			    
			<?php }
			?>
        </div>
    
    
	</div>

<script>
/* Mobile filters toggle — manual (avoids Bootstrap collapse double-fire) */
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
