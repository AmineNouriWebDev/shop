

	<section class="section section-content">		
	
		<div class="container mt-5 mb-5 p-4 ecole-content" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)),url(dist/img/carreau.png);background-repeat: repeat;" >
			    
			    
			    <div class="full_content"><?php echo $contenu; ?></div>
				
				
				<?php 
		            $requete1 ="SELECT * FROM `site_menu` WHERE `id` = '".$id."'  ORDER BY `ordre`";

	                $resultat1 = executeRequete($requete1);

					while($data1 = mysqli_fetch_array($resultat1)) {
					
						if(ApercuPage($data1['id'])) { 
				?>
						      
						<div class="text-right image-content">
							<img src="<?php echo photoPageSite($data1['id']); ?>" class="img-fluid">								
						</div>						
				<?php 	
						}								
					}
				?>
							
		</div>
			
	</section>
			