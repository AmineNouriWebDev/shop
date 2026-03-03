
	<div class="main">
	
		<div class="container animated fadeInUp " data-delay="0.8s">
	
        <?php 
		
		$nbArticles=count($_SESSION['panier']['idcart']);
		
		if($nbArticles) { 
		   $sous_total= 0;
		   $total= 0;
		?>
	
			<div  id="shopping__cart" class="main main-content-wrapper d-flex clearfix">		
				<div class="cart-table-area section-padding-20">
					<div class="container">
						<div class="row">  
							<div class="col-12">
								<div class="cart-title pb-3">
									<h3> Panier </h3>
								</div>
								
								<div class="shop_sidebar_area p-0 bg-transparent mb-5">
									<div class="line"></div>
								</div>

								
								<div class="cart-table clearfix table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>Nom</th>
												<th>Prix</th>
												<th>Quantité</th>
												<th>Total</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										
											<?php for ($i=0 ;$i < $nbArticles ; $i++) { ?>
											<tr>
												<td class="cart_product_img">
													<a href="<?php echo lienProduits(linkProduits($_SESSION['panier']['idcart'][$i]));?>"><img src="<?php echo photoProduitsSite($_SESSION['panier']['idcart'][$i]); ?>" alt="Product"></a>
												</td>
												<td class="cart_product_desc">
													<h5><?php echo titreProduits($_SESSION['panier']['idcart'][$i]); ?></h5>
												</td>
												<td class="price">
													<span><?php if(prixPromoProduits($_SESSION['panier']['idcart'][$i]) !='0.000'){ echo prixPromoProduits($_SESSION['panier']['idcart'][$i]); }else{  echo PrixVenteProduits($_SESSION['panier']['idcart'][$i]); } ?> DT</span>
												</td>
												<td class="qty">
													<div class="qty-btn d-flex flex-wrap" style="background: #f5f7fa;">
								<p>Qté</p>
								<div class="quantity">
									<span class="qty-minus" onclick="UpdateMoinProductCart(<?php echo $_SESSION['panier']['idcart'][$i]; ?>,document.getElementById('qty_<?php echo $i; ?>').value)"><i class="fa fa-minus" aria-hidden="true"></i></span>
									<input type="number" class="qty-text" id="qty_<?php echo $i; ?>" step="1" min="1" max="300" name="quantity" value="<?php echo isset($_SESSION['panier']['qte_prd'][$i]) ? $_SESSION['panier']['qte_prd'][$i] : 1; ?>">
									<span class="qty-plus" onclick="UpdatePlusProductCart(<?php echo $_SESSION['panier']['idcart'][$i]; ?>,document.getElementById('qty_<?php echo $i; ?>').value)"><i class="fa fa-plus" aria-hidden="true"></i></span>
								</div>
							</div>
						</td>
						<?php 
						   // Check if total array index exists, calculate if not
						   if(isset($_SESSION['panier']['total'][$i]) && $_SESSION['panier']['total'][$i] !== null) {
						       $total_ligne = number_format($_SESSION['panier']['total'][$i], 3, '.', '');
						   } else {
						       // Fallback calculation
						       $qte = isset($_SESSION['panier']['qte_prd'][$i]) ? $_SESSION['panier']['qte_prd'][$i] : 1;
						       if(prixPromoProduits($_SESSION['panier']['idcart'][$i]) != '0.000') {
						           $prix = prixPromoProduits($_SESSION['panier']['idcart'][$i]);
						       } else {
						           $prix = PrixVenteProduits($_SESSION['panier']['idcart'][$i]);
						       }
						       $total_ligne = number_format($qte * $prix, 3, '.', '');
						   }
						   $sous_total = $sous_total + $total_ligne;
						?>
												<td>
													<span><?php echo $total_ligne.' DT'; ?></span>
												</td>
												<td class="text-center">
													<a  style="cursor:pointer" onclick="RemoveProductPanier(<?php echo $_SESSION['panier']['idcart'][$i];?>)"> <i class="fa fa-trash" style="color:red;font-size:1.2rem;"></i> </a>
											</tr>
											<?php }?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-12 col-lg-8"></div>
							<div class="col-12 col-lg-4">
								<div class="cart-summary mt-5">
								<?php $total= $total + $sous_total; ?>
									<h5>Total du panier</h5>
									<ul class="summary-table">
										<li><span>sous-total:</span> <span><?php echo number_format($sous_total, 3, '.', ''); ?> DT</span></li>
										<!--li><span>livraison:</span> <span>Free</span></li-->
										<li><span>total:</span> <span><?php echo number_format($total, 3, '.', ''); ?> DT</span></li>
									</ul>
									<div class="cart-btn mt-50">
									    <?php if(isset($_SESSION['client_id']) && $_SESSION['client_id'] !='' ){?>
										<a href="<?php echo lienCommande(); ?>" class="btn amado-btn w-100">Confirmer</a>
										<?php } else{?>
										<a href="<?php echo lienCommande(); ?>" class="btn amado-btn w-100">Passer à la caisse</a>
										<?php }?>
									</div>
									<div class="cart-btn mt-2">										
										<a href="<?php echo lienCategorie(); ?>" class="btn amado-btn w-100" style="background: #aaa;">Retour à la boutique</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>    
			</div>
			<?php }else{ ?>
			<div  id="shopping__cart" class="main main-content-wrapper d-flex clearfix">    
				<div class="cart-table-area section-padding-50">
					<div class="container">
						<div class="row">
							<div class="alert alert-info col-12" role="alert">
								Votre panier est vide ! <a href="<?php echo lienCategorie(); ?>" class="alert-link" style="font-size: 0.9rem;float: right;text-decoration: underline;">Retour à la boutique</a>
							</div>
						</div>
					</div>
				</div>				
			</div>	
			<?php } ?>	
	
		</div>
	</div>