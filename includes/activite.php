			
			<div class="container">
				<div class="row mt-5 mb-5">
				
				<?php 
					$requete ="SELECT * FROM `activites` WHERE `etat` = '1' ORDER BY `ordre`";

					$resultat = executeRequete($requete);

					while($data = mysqli_fetch_array($resultat)) {
				?>
					<div class="col-lg-4 col-md-6 col-sm-12 pt-4">
						<div class="card text-center mb-2">
							<div class="carousel-item-image">
								<a href="<?php echo lienActivite($data['link']); ?>"><img src="<?php echo imageActivitesSource($data['id']); ?>" class="card-img-top" /></a>
							</div>
							<div class="card-body">
								<h5 class="card-title"><a href="<?php echo lienActivite($data['link']); ?>"><?php echo titreActivites($data['id']);?></a></h5>										
							</div>
						</div>
					</div>
				<?php } ?>	                                        
                </div>					
			</div>