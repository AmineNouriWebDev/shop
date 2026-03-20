<head>
    <style>
        .contactez-nous img {
            transition: 0.6s;
        }
        .contactez-nous img:hover {
            transform: scale(0.9);
        }
    </style>
</head>

                <div class="text-center my-4">
    				<h2>Contactez nous</h2>
				</div>
				<div class="row justify-content-center contactez-nous">
			        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 text-center">
					    <hr>
					
                		<?php if($whatsapp){ ?>
						    <a href="<?php echo 'tel:'.$whatsapp; ?>" role="button" target="_blank"><span><img src="media/icones/2-icones-whatsapp_4138132.png"  class="img-fluid" style="max-width:60px"></span></a>
                		<?php } ?>
                		<?php if($adresse_contact){ ?>
						    <a href="<?php echo 'mailto:'.$adresse_contact; ?>" role="button" target="_blank"><span><img src="media/icones/5-icones-mail_6896703.png"  class="img-fluid" style="max-width:60px"></span></a>
                		<?php } ?>
						<?php
							$req  ="SELECT * FROM `social_network` WHERE `etat` = '1' ORDER BY `ordre`";
							$res  = executeRequete($req);
							while($data = mysqli_fetch_array($res)) {
						?>
							<a href="<?php echo lienSocialNetwork($data['id']); ?>" role="button" target="_blank"><span><img src="<?php echo photoSocialNetworkSite($data['id']); ?>"  class="img-fluid" style="max-width:60px"></span></a>
								
						<?php } ?>
        		    	<hr>
        			</div>
        		</div>
        		
                <div class="text-center my-4">
    				<h2>Nos Catégories</h2>
				</div>     
				<div class="row row-cols-lg-5  row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center">   		
        		
                	<?php 
            			            $req = "SELECT * FROM categories_blog WHERE etat='1' AND idparent ='0'";
                                    $res = executeRequete($req);
                		            while ($datactg = mysqli_fetch_array($res))  {
                    				if($datactg['id'])    $id_categ    = $datactg['id']; 
                    				if($datactg['link'])  $link_categ  = $datactg['link']; 
                    				
            			            $reqsc = "SELECT * FROM categories_blog WHERE etat='1' AND idparent ='".$id_categ."'";
                                    $ressc = executeRequete($reqsc);
                	?>
			                    <div class="col mb-4">
        							<div class="single-product-wrapper h-wrapper border bg-light p-4 text-center hoverDiv h-100">
        								<!-- Product Image -->
        								<a href="<?php echo lienCategories($link_categ); ?>" class="">
        								    <div class="product-img border rounded p-3 border-warning mb-4 hover-zoom bg-white">
        									    <img src="<?php echo photoCategBlog($id_categ); ?>" alt="" class="img-fluid">
        									</div>
        								</a>
        								
        
        								<!-- Product Description -->
        								<div class="product-description">
        									<!-- Product Meta Data -->
        									<div class="product-meta-data">
        										<a href="<?php echo lienCategories($link_categ); ?>" class="text-center">
        											<h6><?php echo titreCategBlog($id_categ); ?> </h6>
        										</a>
        										<ul class="list-categ text-left">
        										<?php while ($datasctg = mysqli_fetch_array($ressc))  { 
                                    				if($datasctg['id'])    $id_scateg    = $datasctg['id']; 
                                    				if($datasctg['link'])  $link_scateg  = $datasctg['link'];
        										?>
        										    <li><a href="<?php echo lienCategorieEquipements($link_scateg); ?>"><?php echo titreCategBlog($id_scateg); ?></a></li>
        										<?php } ?>
        										</ul>
        									</div>
        								</div>
        							</div>
        						</div>
    		        <?php }  ?>
        	    </div>