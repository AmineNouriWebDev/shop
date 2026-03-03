	<!----------------- Main --------------------->
	<div class="main">
		<div class="section section-content banner">	
			<div class="container">
				<div class="row mt-5 mb-5">
				
				<?php 
					$requete ="SELECT * FROM `activites` WHERE `etat` = '1' AND `link`='".$link."' ";

					$resultat = executeRequete($requete);

					$data = mysqli_fetch_array($resultat);
				?>
					<div class="col-lg-4 col-md-6 col-sm-12 pt-4">
						<div id="img2" class="pola">
							<img src="<?php echo imageActivitesSource($data['id']); ?>" class="card-img-top" />
						</div>
					</div>
					
					<div class="col-lg-8 col-md-6 col-sm-12 p-5 text-justify">
						<?php echo contenuActivites($data['id']); ?>
					</div>	
                </div>					
			</div>
					</div>
		<?php include('includes/newsletter.php');?>
	</div>