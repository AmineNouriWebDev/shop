		<section class="section section1 postContainerGrid py-5">
			<div class="container-fluid">		
				<?php 
		            $requete1 ="SELECT * FROM `bloc_accueil` WHERE `etat` = '1' AND `affichage_accueil`='1' AND id != '15' ORDER BY `ordre`";

	                $resultat1 = executeRequete($requete1);

					while($data1 = mysqli_fetch_array($resultat1)) {
				?>
				<?php if( $data1['affichage_titre'] == '1'){ ?>
				<div class="text-center my-4">
    				<h2><?php echo titreBloc($data1['id']); ?></h2>
				</div>
				<?php } ?>
				<div class="row <?php if (numColBloc($data1['id']) =='5'){ echo "row-cols-lg-5  row-cols-md-3 row-cols-sm-2 row-cols-1"; } ?> justify-content-center">
					
					<?php if(typeSectionBloc($data1['id']) =='4' ) { ?>
					
                		        <?php
                		            if (numColBloc($data1['id']) =='2'){ $numRowsc = 6;  }elseif (numColBloc($data1['id']) =='3'){ $numRowsc = 12;}elseif (numColBloc($data1['id']) =='4'){ $numRowsc = 9;}elseif (numColBloc($data1['id']) =='5'){ $numRowsc = 10;}elseif (numColBloc($data1['id']) =='6'){ $numRowsc = 12;}
            			            $req = "SELECT DISTINCT pr.id,pr.link FROM `produits` pr,`liste_produits` lpr,`categories_marques` ctgm WHERE lpr.idbloc ='".$data1['id']."' AND pr.etat='1' AND ( pr.prix_promo !='0.000' AND lpr.en_promo='1') AND 
            			            ( lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie ) AND ( (lpr.marque !='' AND pr.titre LIKE CONCAT('%',lpr.marque,'%')) OR lpr.marque ='')
            			            ORDER BY pr.prix_vente ASC LIMIT 0,".$numRowsc."";
                                    //echo $req;
                                    $res = executeRequete($req);
                                    $numRows = mysqli_num_rows($res);
                                    if($numRows > 0){
                		            while ($datapr = mysqli_fetch_array($res))  {
                    				if($datapr['id'])    $id_p    = $datapr['id']; 
                    				if($datapr['link'])  $link_p  = $datapr['link']; 
                    				
                		        ?>
        						
                				<div class="<?php if (numColBloc($data1['id']) =='5'){ echo "col"; }else{ ?>col-xs-12 col-sm-6 col-md-6 col-lg-<?php echo numColBloc($data1['id']); } ?> mb-4">
        							<div class="single-product-wrapper border p-2 text-center hoverDiv">
        								<!-- Product Image -->
        								<a href="<?php echo  lienProduits($link_p); ?>" class="product-img hover-zoom">
        									<img src="<?php echo  photoProduitsSite($id_p); ?>" alt="" class="img-fluid">
        								</a>
        								<!-- Product Description -->
        								<div class="product-description d-flex flex-column align-items-center justify-content-between">
        									<!-- Product Meta Data -->
        									<div class="product-meta-data">
        									    <a href="<?php echo  lienProduits($link_p); ?>">
        											<h6> <?php echo titreProduits($id_p); ?></h6>
        										</a>
        										<div class="line"></div>
        										<?php if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') {  ?>
            									<div style="height:60px;overflow:hidden"><img src="<?php echo photoMarqueSite(marquesProduits($id_p)); ?>" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>
            									<?php }
            									if (etatStockProduits($id_p) == '1'){   ?>
                                                    <p class="avaibility m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>
        								        <?php }else{ ?>
                                                    <p class="avaibility m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>
        								        <?php } 
        										if(prixPromoProduits($id_p) != '0.000') {  ?>
            									<p class="product-price "> <?php echo prixPromoProduits($id_p); ?> DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;"> <?php echo prixVenteProduits($id_p); ?> DT</span> </p>
            									<?php }else{ ?>
            									<p class="product-price"> <?php echo prixVenteProduits($id_p); ?> DT </p>
            									<?php } ?>
        										
        									</div>
        									<!-- Ratings & Cart -->
        									<div class="ratings-cart d-flex w-100 justify-content-between">
        										<div class="cart">
        										<?php if (etatStockProduits($id_p) == '1'){  ?>
                                                 <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p); ?>, '1')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>
        								        <?php }else{ ?>
                                                    <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p); ?>, '1')" id="AddCart" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>
        								        <?php } ?>		
        										</div>
        										<div class="cart" data-toggle="tooltip" data-placement="top" title="Détails produit">
        											<a href="<?php echo  lienProduits($link_p); ?>"  class="btn btn-primary-outline"><i class="fa fa-eye" style="color:#ababab"></i> Voir détails</a>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
						
    		                    <?php } }else{  
    		                     
            			            $req1 = "SELECT DISTINCT pr.id,pr.link FROM `produits` pr,`liste_produits` lpr,`categories_marques` ctgm WHERE lpr.idbloc ='".$data1['id']."' AND pr.etat='1' AND ( pr.prix_promo ='0.000' AND lpr.en_promo='0') AND 
            			            ( lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie ) AND ( (lpr.marque !='' AND pr.titre LIKE CONCAT('%',lpr.marque,'%')) OR lpr.marque ='')
            			            ORDER BY pr.id DESC,pr.prix_vente ASC LIMIT 0,".$numRowsc."";
                                    //echo $req1;
                                    $res1 = executeRequete($req1);
                                    $numRows = mysqli_num_rows($res1);
                                    if($numRows > 0){
                		            while ($datapr1 = mysqli_fetch_array($res1))  {
                    				if($datapr1['id'])    $id_p1    = $datapr1['id']; 
                    				if($datapr1['link'])  $link_p1  = $datapr1['link'];
    		                    
    		                    ?>
			                    <div class="<?php if (numColBloc($data1['id']) =='5'){ echo "col"; }else{ ?>col-xs-12 col-sm-6 col-md-6 col-lg-<?php echo numColBloc($data1['id']); } ?> mb-4">
        							<div class="single-product-wrapper border p-2 text-center hoverDiv">
        								<!-- Product Image -->
        								<a href="<?php echo  lienProduits($link_p1); ?>" class="product-img hover-zoom">
        									<img src="<?php echo  photoProduitsSite($id_p1); ?>" alt="" class="img-fluid">
        								</a>
        								<!-- Product Description -->
        								<div class="product-description d-flex flex-column align-items-center justify-content-between">
        									<!-- Product Meta Data -->
        									<div class="product-meta-data">
        									    <a href="<?php echo  lienProduits($link_p1); ?>">
        											<h6> <?php echo titreProduits($id_p1); ?></h6>
        										</a>
        										<div class="line"></div>
        										<?php if(marquesProduits($id_p1) != '0' && ApercuMarque(marquesProduits($id_p1)) !='') {  ?>
            									<div style="height:60px;overflow:hidden"><img src="<?php echo photoMarqueSite(marquesProduits($id_p1)); ?>" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>
            									<?php }
            									if (etatStockProduits($id_p1) == '1'){   ?>
                                                    <p class="avaibility m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>
        								        <?php }else{ ?>
                                                    <p class="avaibility m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>
        								        <?php } 
        										if(prixPromoProduits($id_p1) != '0.000') {  ?>
            									<p class="product-price "> <?php echo prixPromoProduits($id_p1); ?> DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;"> <?php echo prixVenteProduits($id_p1); ?> DT</span> </p>
            									<?php }else{ ?>
            									<p class="product-price"> <?php echo prixVenteProduits($id_p1); ?> DT </p>
            									<?php } ?>
        										
        									</div>
        									<!-- Ratings & Cart -->
        									<div class="ratings-cart d-flex w-100 justify-content-between">
        										<div class="cart">
        										<?php if (etatStockProduits($id_p1) == '1'){  ?>
                                                 <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p1); ?>, '1')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>
        								        <?php }else{ ?>
                                                    <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p1); ?>, '1')" id="AddCart" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" width="15px" alt="" class="img-fluid"> Ajouter au panier</button>
        								        <?php } ?>		
        										</div>
        										<div class="cart" data-toggle="tooltip" data-placement="top" title="Détails produit">
        											<a href="<?php echo  lienProduits($link_p1); ?>"  class="btn btn-primary-outline"><i class="fa fa-eye" style="color:#ababab"></i> Voir détails</a>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
    		                    <?php } } }  ?>
					<?php }elseif(typeSectionBloc($data1['id']) =='1' ) { ?>
			                    <div class="<?php if (numColBloc($data1['id']) =='5'){ echo "col"; }else{ ?> col-lg-<?php echo numColBloc($data1['id']); } ?> text-center my-4">
	
                            		<div id="carouselSection" class="carousel slide" data-ride="carousel">
                            	    <?php 
                            			$req   = "SELECT * FROM `liste_section_content` WHERE idbloc='".$data1['id']."'";
                            			$res  = executeRequete($req);
                            			$counter   = 0;
                            			$count	   = mysqli_num_rows($res);			
                            	    ?>
                            		
                            			<!--Slides-->
                            			<div class="carousel-inner" role="listbox">
                            			<?php while($data = mysqli_fetch_array($res)) { ?>
                            			
                                            <a href="<?php echo lienSectionContent($data['id']); ?>" class="carousel-item <?php echo ( $counter == 0 ? ' active' : '' ) ?>" <?php echo ( $counter == 0 ? ' data-interval="3000"' : 'data-interval="2000"' ) ?>>
                                                  <img class="d-block w-100 img-fluid" src="<?php echo photoSectionContent($data['id']); ?>" alt="First slide" style="max-height:660px;margin:auto">
                                            </a>
                                            
                            			<?php $counter++;  } ?>
                            			</div>
                            			<a class="carousel-control-prev" href="#carouselSection" role="button" data-slide="prev" style="top: 80px;">
                            			  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            			  <span class="sr-only">Previous</span>
                            			</a>
                            			<a class="carousel-control-next" href="#carouselSection" role="button" data-slide="next" style="top: 80px;">
                            			  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            			  <span class="sr-only">Next</span>
                            			</a>
                            		</div>
			                        
			                    </div>
					
					<?php }elseif(typeSectionBloc($data1['id']) =='6' ) { ?>
					
					            <?php if(ApercuBloc($data1['id'])){ ?>
			                    <div class="<?php if (numColBloc($data1['id']) =='5'){ echo "col"; }else{ ?>col-xs-4 mobile-section col-sm-4 col-md-4 col-lg-<?php echo numColBloc($data1['id']); } ?> text-center mb-4">
			                        <div class="h-100">
			                            <a href="<?php echo lienBloc($data1['id']);  ?>"><img src="<?php echo photoBlocSite($data1['id']); ?>" class="img-fluid" style="width: 100%;object-fit: contain;height: -webkit-fill-available;"></a>
        						    </div>
        						</div>
        						<?php } ?>
                		        <?php 
            			            $req = "SELECT * FROM `liste_section_content` WHERE idbloc='".$data1['id']."' ";
                                    $res = executeRequete($req);
                		            while ($databn = mysqli_fetch_array($res))  {
                    				if($databn['id'])    $id_bn    = $databn['id']; 
                    				
                		        ?>
			                    <div class="<?php if (numColBloc($data1['id']) =='5'){ echo "col"; }else{ ?>col-xs-4 col-sm-4 mobile-section col-md-4 col-lg-<?php echo numColBloc($data1['id']); } ?> text-center mb-4">
			                        <div class="h-100">
			                            <a href="<?php echo lienSectionContent($id_bn);  ?>"><img src="<?php echo photoSectionContent($id_bn); ?>" class="img-fluid" style="width: 100%;object-fit: contain;height: -webkit-fill-available;"></a>
        						    </div>
        						</div>
    		                    <?php }  ?>
					<?php } ?>
				</div>
				<?php } ?>
				
				<?php include('categ-contact-accueil.php'); ?>
				
			</div>
		</section>