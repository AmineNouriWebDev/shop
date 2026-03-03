	<!----------------- Main --------------------->
	<div class="main">
		<div class="section blog section-content">
		
			<div class="container" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)),url(dist/img/carreau.png);background-repeat: repeat;">
				<?php 
		            $requete1 ="SELECT * FROM `articles` WHERE `link` = '".$link."' AND `etat` = '1' ORDER BY `ordre`";

	                $resultat1 = executeRequete($requete1);

					while($data1 = mysqli_fetch_array($resultat1)) {
				?>	
					<div class="row justify-content-center mt-4 mb-4">
					<?php if(ApercuArticle($data1['id'])) { ?>
						<div class="col-sm-12">			      
							<div class="image-content text-center pt-4">
								<img src="<?php echo photoArticleSite($data1['id']); ?>" class="img-fluid">
							</div>
						</div>						
					<?php } ?>
						<div class="col-sm-12 mt-4">
						
							<h6 class="date text-center"><?php echo datemois(timestamptodate($data['date'])); ?></h6>
							
							<h1 class="text-center"><?php echo titreArticle($data1['id']); ?></h1>
							
							<div class="p-4">
							
								<?php echo ContenuArticle($data1['id']); ?>
							
							</div>	
				   		</div>	
				    </div>
				<?php } ?>
			</div>		
		
		</div>
		<?php include('includes/newsletter.php');?>
	</div>