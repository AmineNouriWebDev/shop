        <?php if(affichageAccueilBloc(8) =='1' ) { ?>
        <section class="section section3 py-5">
		    <div class="container">
		        
				<?php if( affichageTitreBloc(8) == '1'){ ?>
				<div class="text-center">
    				<h2><?php echo titreBloc(8); ?></h2>
				</div>
				<?php } ?>
				<div class="row align-items-centerrow align-items-center pt-4">
				    
				    <?php 
						$requete2 = 'SELECT * FROM `services` ORDER BY `ordre` ASC ';
                        $resultat2 = executeRequete($requete2);
	                    $num2 = mysqli_num_rows($resultat2);						
		                if ($num2 > 0 ) { 
			                while ($data2 = mysqli_fetch_array($resultat2))  {
					?>
					<div class="col-lg-4 col-md-12 col-sm-12 pb-3 cl5">							
						<nav>
	                        <ul>
	                            <li>
	                                <img src="<?php echo photoServiceSite($data2['id']);?>"/> <span><?php echo titreService($data2['id']);?></span >
	                            </li>
	                        </ul>
	                    </nav>
								
					</div>
					<?php }} ?>
					
				</div>
			</div>
		</section>
		<?php } ?>