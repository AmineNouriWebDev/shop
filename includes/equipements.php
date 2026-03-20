    <?php if(affichageAccueilBloc(7) =='1' ) { ?>
        <section class="section section4 py-5">
		    <div class="container">
				<?php if( affichageTitreBloc(7) == '1'){ ?>
				<div class="text-center">
    				<h2><?php echo titreBloc(7); ?></h2>
				</div>
				<?php } ?>
				
				<div class="align-items-centerrow align-items-center pt-4">
						<div class="customer-logos slider">
						<?php 
							$requete = 'SELECT * FROM `produits` WHERE `type`="E" ORDER BY `id` ASC LIMIT 6';
                            $resultat = executeRequete($requete);
	                        $num = mysqli_num_rows($resultat);
							$first = TRUE;
		                    if ($num > 0 ) { 
			                    while ($data = mysqli_fetch_array($resultat))  {
									$class = "";
									   if($first)
									   {
										  $class = "active";
										  $first = FALSE;
									   }
						?>
							<div class="slide pb-3  <?php echo  $class; ?>">
								<div class="card">
								  <a href="<?php echo lienProduits($data['link']);?>"><img class="card-img-top" src="<?php echo photoProduitsSite($data['id']); ?>" alt="Card image cap"></a>
								  <div class="card-body text-center">
									<a href="<?php echo lienProduits($data['link']);?>"> <h5 class="card-title"><?php echo titreProduits($data['id']); ?></h5></a>
									<div class="card-text">
										<?php echo afficheChamp1($data['caracteristique']); ?>
									</div>
									<a href="JavaScript:void(0)" onclick="addToCart1(<?php echo $data['id']; ?>, '1');" class="btn btn-primary commander text-uppercase"><?php if(ancreProduits($data['id'])) echo ancreProduits($data['id']); else echo 'Commander'; ?></a>
								  </div>
								</div>
							</div>
							
                        <?php }  } ?>
						</div>
				</div>
				<a href="<?php echo lienCategorie(); ?>" class="pull-right all-pack">Tous les produits <i class="fa fa-angle-double-right"></i></a>
			</div>
		</section>
	<?php } ?>