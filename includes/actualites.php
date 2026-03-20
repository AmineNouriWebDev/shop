<section class="actualite">
			<div class="container">	
				<div class="row justify-content-center">
					<div class="col-lg-8 col-sm-12 card-section ">        
						<div class="text-left">        
							<h2>Nos actualités</h2>  
							<img src="dist/img/zig.png" class="mb-4">
						</div>
						<div class="row justify-content-center">
						<?php
						
							$requete  = "SELECT * FROM `articles` WHERE `etat` = '1' ORDER BY `ordre` LIMIT 2";

							$resultat = executeRequete($requete);

							while($data = mysqli_fetch_array($resultat)) {
						?>	
							<div class="col-lg-6 col-sm-12 "> 
							
								<div class="card" style="background:transparent;border:none;">
								<?php if(ApercuArticle($data['id'])){ ?>
								  <a href="<?php echo lienArticleBlog(linkArticle($data['id'])); ?>"><img class="card-img-top" src="<?php echo photoArticleSite($data['id']); ?>" alt="Card image cap"></a>
								<?php } ?>
								  <div class="card-body">							  
									<h5 class="card-title"><a href="<?php echo lienArticleBlog(linkArticle($data['id'])); ?>"><?php echo titreArticle($data['id']); ?></a></h5>
									<h6 class="date"><?php echo datemois(timestamptodate($data['date'])); ?></h6>
									<div class="card-text"><?php echo courtContenuArticle($data['id']); ?></div>
									<a href="<?php echo lienArticleBlog(linkArticle($data['id'])); ?>" style="font-size:18px;color: #ffd338;"> <?php echo ancreArticle($data['id']); ?> <i class="fa fa-arrow-right"></i></a>
								  </div>
								</div>
								
							</div>
						
						<?php } ?>
						</div>
					</div>
					<div  onclick='window.location = $(this).find("a:first").attr("href");' class="col-lg-4 col-sm-12 actuality" style="cursor: pointer;height: 550px;border-radius: 20px;background: url(dist/img/img7.png) no-repeat center center;background-size: cover;">
						<img src="media/site/<?php echo $logo;?>" class="img-fluid pt-2 " width="155px"/>
						<div class="card-body">
							<a href="" >Accès <span>Intranet</span></a>
							
							<p>
							Cet espace permet une mise en relation entre les enseignants,
							les administratifs et les parents des élèves de l'école. 
							</p>
							
							<a href="" class="float-right" style="font-size:18px;"><i class="fa fa-arrow-right"></i></a>

						</div>
					</div>
                </div>					
			</div>
		</section>	