	
	<?php $nbArticles = (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart'])) ? count($_SESSION['panier']['idcart']) : 0; ?>
	<div id="feedback">
		<div class="content-feed" id="feedbackContent">
			<i class="fa fa-shopping-cart"></i> 
			<p>
				<?php  
						if ($nbArticles) {
							
							echo 'Il y a '.$nbArticles.' produit(s) dans votre panier. <a href="'.lienPanier().'" class="pl-2">voir panier</a>'; 
						}
						else{ 
						
							echo 'votre panier est vide !  <a href="'.lienCategorie().'" class="pl-2">voir catalogue</a>';
						
						} 
				?>
			</p>
		</div>
	</div>