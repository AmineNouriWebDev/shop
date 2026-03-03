
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
													<button type="button" class="btn btn-link text-danger p-2 fc-trash-btn" onclick="RemoveProductPanier(<?php echo $_SESSION['panier']['idcart'][$i];?>)" aria-label="Supprimer">
														<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
													</button>
												</td>
											</tr>
											<?php }?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-12 col-lg-8"></div>
							<div class="col-12 col-lg-4">
								<div class="cart-summary-tw mt-5">
								<?php $total= $total + $sous_total; ?>
									<h5>Total du panier</h5>
									<ul class="summary-table-tw">
										<li><span>Sous-total</span> <span><?php echo number_format($sous_total, 3, '.', ''); ?> DT</span></li>
										<li class="total-row"><span>Total</span> <span><?php echo number_format($total, 3, '.', ''); ?> DT</span></li>
									</ul>
									<div class="cart-btn-grp mt-4">
									    <?php if(isset($_SESSION['client_id']) && $_SESSION['client_id'] !='' ){?>
										<a href="<?php echo lienCommande(); ?>" class="btn-primary-tw w-100 mb-3">Confirmer l'achat →</a>
										<?php } else{?>
										<a href="<?php echo lienCommande(); ?>" class="btn-primary-tw w-100 mb-3">Passer à la caisse →</a>
										<?php }?>
										<a href="<?php echo lienCategorie(); ?>" class="btn-secondary-tw w-100">Retour à la boutique</a>
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

<style>
/* ── Cart Styles Overrides ─────────────────────────── */
.fc-trash-btn {
	background: color-mix(in srgb, #ef4444 10%, transparent);
	border: none;
	border-radius: 0.5rem;
	transition: background 150ms ease, color 150ms ease;
    display: inline-flex; align-items: center; justify-content: center;
}
.fc-trash-btn:hover {
	background: color-mix(in srgb, #ef4444 20%, transparent);
	color: #dc2626;
}
.cart-summary-tw {
	background: var(--shop-surface, #fff);
	border: 1px solid var(--shop-border, #e5e7eb);
	border-radius: 1.25rem;
	padding: 1.75rem;
	box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.cart-summary-tw h5 {
	font-size: 1.125rem; font-weight: 700; color: var(--shop-text-primary, #1a1a2e); float: none; display:block;
	margin: 0 0 1.25rem 0; border-bottom: 2px solid var(--shop-border, #e5e7eb); padding-bottom: 0.75rem;
}
.summary-table-tw { list-style: none; padding: 0; margin: 0; }
.summary-table-tw li {
	display: flex; justify-content: space-between; align-items: center;
	margin-bottom: 1rem; color: var(--shop-text-secondary, #4b5563); font-size: 0.9375rem; font-weight: 500;
}
.summary-table-tw .total-row {
	font-size: 1.125rem; font-weight: 700; color: var(--shop-text-primary, #1a1a2e);
	margin-top: 1.25rem; padding-top: 1rem; border-top: 1px dashed var(--shop-border, #e5e7eb);
}
.btn-primary-tw {
	display: block; text-align: center; background: var(--shop-primary, #5A31F4); color: white;
	font-weight: 600; padding: 0.875rem 1rem; border-radius: 0.875rem; text-decoration: none;
	transition: background 200ms ease, transform 150ms ease, box-shadow 200ms ease;
}
.btn-primary-tw:hover {
	background: var(--shop-primary-hover, #421bb6); color: white; text-decoration: none;
	transform: translateY(-2px); box-shadow: 0 8px 24px color-mix(in srgb, var(--shop-primary, #5A31F4) 35%, transparent);
}
.btn-secondary-tw {
	display: block; text-align: center; background: var(--shop-bg-alt, #f3f4f6); color: var(--shop-text-primary, #1a1a2e);
	font-weight: 600; padding: 0.875rem 1rem; border-radius: 0.875rem; text-decoration: none;
	transition: background 200ms ease;
}
.btn-secondary-tw:hover {
	background: #e5e7eb; color: var(--shop-text-primary, #1a1a2e); text-decoration: none;
}
</style>