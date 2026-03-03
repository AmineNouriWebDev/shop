		<section class="section section2 mt-4 p-5">
		    <div class="container">
				<div class="text-center">
    				    <h2>Nos activités</h2>
    				    <img src="dist/img/zig.png" class="mb-4">
				</div>
				<div class="customer-logos slider">
				
				<?php 
					$requete ="SELECT * FROM `activites` WHERE `etat` = '1' ORDER BY `ordre`";

					$resultat = executeRequete($requete);

					while($data = mysqli_fetch_array($resultat)) {
				?>
					<div class="slide">
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
		</section>