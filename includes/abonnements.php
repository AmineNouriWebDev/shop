<?php if(affichageAccueilBloc(5) =='1' ) { ?>
        <section class="section section2 py-5">
		    <div class="container">
				<?php if( affichageTitreBloc(5) == '1'){ ?>
				<div class="text-center">
    				<h2><?php echo titreBloc(5); ?></h2>
				</div>
				<?php } ?>
				<div class="row justify-content-center align-items-center pt-4 pack">
					<?php 
						$requete2 = 'SELECT * FROM `produits` WHERE `afficher_accueil` = "1" AND `type`="A" ORDER BY `id` ASC LIMIT 3 ';
                        $resultat2 = executeRequete($requete2);
	                    $num2 = mysqli_num_rows($resultat2);						
		                if ($num2 > 0 ) { 
			                while ($data2 = mysqli_fetch_array($resultat2))  {
					?>
					<div class="col-lg-4 col-md-6 col-sm-12 pb-3">
						<div class="card text-center">
						  <div class="card-body pl-3 pr-3">
							<a href="<?php echo lienProduits($data2['link']);?>"><img class="card-img-top" src="<?php echo photoProduitsSite($data2['id']); ?>" alt="Card image cap"></a>
							<a href="<?php echo lienProduits($data2['link']);?>" style="text-decoration:none;"><h1 class="card-title"><?php echo titreProduits($data2['id']); ?></h1></a>
							<h3 class="price"><?php echo prixVenteProduits($data2['id']).'dt'; ?></h3>
							<!--h5 class="delai"><?php echo delaiProduits($data2['id']); ?></h5-->							
							<div class="row align-items-center icon mt-4 mb-4">
								<div class="col-4">
									<a href="JavaScript:void(0)" class="device-icon" title="TV">
										<img src="dist/img/tv.png" alt="TV" class="img-fluid">
										<span class="device-name">TV</span>
									</a>
								</div>
								<div class="col-4">
									<a href="JavaScript:void(0)" class="device-icon" title="Screen">
										<img src="dist/img/ecran.png" alt="Screen" class="img-fluid">
										<span class="device-name">Screen</span>
									</a>
								</div>
								<div class="col-4">
									<a href="JavaScript:void(0)" class="device-icon" title="Phone">
										<img src="dist/img/phone.png" alt="Phone" class="img-fluid">
										<span class="device-name">Phone</span>
									</a>
								</div>
						</div>
							
							<a href="JavaScript:void(0)" onclick="addToCart1(<?php echo $data2['id']; ?>, '1');" class="btn btn-warning text-uppercase white-text"><?php if(ancreProduits($data2['id'])) echo ancreProduits($data2['id']); else echo "S'abonner"; ?></a>
						  </div>
						</div>
					</div>
					<?php }} ?>
				</div>
				<a href="<?php echo lienBloc(5); ?>" class="pull-right white-text all-pack"><?php echo ancreBloc(5); ?> <i class="fa fa-angle-double-right"></i></a>
			</div>
		</section>
	<?php } ?>