
	<div class="main">
	
		<div class="container animated fadeInUp " data-delay="0.8s">
	
        <?php 
		
		$nbArticles = count($_SESSION['panier']['idcart'] ?? []);
		
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

								
								<div class="cart-table-tw clearfix">
									<table class="table mb-0">
										<thead>
											<tr>
												<th class="border-0">Produit</th>
												<th class="border-0">Nom</th>
												<th class="border-0">Prix</th>
												<th class="border-0 text-center">Quantité</th>
												<th class="border-0">Total</th>
												<th class="border-0 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
										
											<?php for ($i=0 ;$i < $nbArticles ; $i++) { ?>
											<tr>
												<td class="cart_product_img">
													<a href="<?php echo lienProduits(linkProduits($_SESSION['panier']['idcart'][$i]));?>">
														<img src="<?php echo photoProduitsSite($_SESSION['panier']['idcart'][$i]); ?>" alt="Product" class="rounded-lg shadow-sm">
													</a>
												</td>
												<td class="cart_product_name">
													<h5><?php 
                                                        if(isset($_SESSION['panier']['name'][$i]) && !empty($_SESSION['panier']['name'][$i])) {
                                                            echo htmlspecialchars($_SESSION['panier']['name'][$i]);
                                                        } else {
                                                            echo titreProduits($_SESSION['panier']['idcart'][$i]); 
                                                        }
                                                    ?></h5>
												</td>
												<td class="price">
													<span><?php 
                                                    if(isset($_SESSION['panier']['promo'][$i]) && floatval($_SESSION['panier']['promo'][$i]) > 0) {
                                                        echo number_format(floatval($_SESSION['panier']['promo'][$i]), 3, '.', '');
                                                    } else if(isset($_SESSION['panier']['price'][$i]) && floatval($_SESSION['panier']['price'][$i]) > 0) {
                                                        echo number_format(floatval($_SESSION['panier']['price'][$i]), 3, '.', '');
                                                    } else {
                                                        if(prixPromoProduits($_SESSION['panier']['idcart'][$i]) !='0.000'){ 
                                                            echo prixPromoProduits($_SESSION['panier']['idcart'][$i]); 
                                                        } else {  
                                                            echo PrixVenteProduits($_SESSION['panier']['idcart'][$i]); 
                                                        } 
                                                    }
                                                    ?> DT</span>
												</td>
												<td class="qty">
													<div class="qty-control d-flex align-items-center justify-content-center">
														<button type="button" class="qty-btn" onclick="UpdateMoinProductCart(<?php echo $_SESSION['panier']['idcart'][$i]; ?>,document.getElementById('qty_<?php echo $i; ?>').value)"><i class="fa fa-minus"></i></button>
														<input type="number" class="qty-text" id="qty_<?php echo $i; ?>" step="1" min="1" max="300" name="quantity" value="<?php echo isset($_SESSION['panier']['qte_prd'][$i]) ? $_SESSION['panier']['qte_prd'][$i] : 1; ?>" readonly>
														<button type="button" class="qty-btn" onclick="UpdatePlusProductCart(<?php echo $_SESSION['panier']['idcart'][$i]; ?>,document.getElementById('qty_<?php echo $i; ?>').value)"><i class="fa fa-plus"></i></button>
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
												<td class="total_price">
													<span><?php echo $total_ligne.' DT'; ?></span>
												</td>
												<td class="action-cell">
													<button type="button" class="btn btn-link text-danger fc-trash-btn" onclick="RemoveProductPanier(<?php echo $_SESSION['panier']['idcart'][$i];?>)" aria-label="Supprimer">
														<i class="fa fa-trash-alt"></i>
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
<style>
/* ── Modern Cart Page Styles ─────────────────────────── */
.cart-table-tw {
    background: var(--shop-surface, #fff);
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid var(--shop-border, #e5e7eb);
}

.cart-table-tw table thead {
    background: var(--shop-bg-alt, #f9fafb);
}

.cart-table-tw thead th {
    padding: 1.25rem 1rem;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--shop-text-secondary, #6b7280);
    font-weight: 700;
}

.cart-table-tw tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border-top: 1px solid var(--shop-border, #e5e7eb);
}

.cart_product_img img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    background: #fff;
    border-radius: 0.75rem;
    padding: 5px;
    border: 1px solid var(--shop-border, #e5e7eb);
}

.cart_product_name h5 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0;
    color: var(--shop-text-primary);
    max-width: 250px;
    line-height: 1.4;
}

.cart-table-tw .price span, 
.cart-table-tw .total_price span {
    font-weight: 800;
    color: var(--shop-text-primary);
    font-size: 1rem;
}

.qty-control {
    background: var(--shop-bg-alt, #f3f4f6);
    border-radius: 0.75rem;
    padding: 4px;
    width: fit-content;
    margin: 0 auto;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    border: none;
    background: #fff;
    color: var(--shop-text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.8rem;
}

.qty-btn:hover {
    background: var(--shop-primary);
    color: #fff;
}

.qty-text {
    width: 40px;
    text-align: center;
    border: none;
    background: transparent;
    font-weight: 700;
    font-size: 0.9rem;
    -moz-appearance: textfield;
}

.qty-text::-webkit-outer-spin-button,
.qty-text::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.action-cell .fc-trash-btn {
    width: 38px;
    height: 38px;
    background: #fef2f2;
    color: #ef4444;
    border-radius: 0.75rem;
    border: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.action-cell .fc-trash-btn:hover {
    background: #ef4444;
    color: #fff;
    transform: scale(1.1);
}

.cart-summary-tw {
	background: var(--shop-surface, #fff);
	border: 1px solid var(--shop-border, #e5e7eb);
	border-radius: 1.5rem;
	padding: 2rem;
	box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.cart-summary-tw h5 {
	font-size: 1.25rem; font-weight: 800; color: var(--shop-text-primary); float: none; display:block;
	margin: 0 0 1.5rem 0; padding-bottom: 1rem; border-bottom: 2px solid var(--shop-bg-alt);
}

.summary-table-tw { list-style: none; padding: 0; margin: 0; }
.summary-table-tw li {
	display: flex; justify-content: space-between; align-items: center;
	margin-bottom: 1.25rem; color: var(--shop-text-secondary); font-size: 0.95rem; font-weight: 600;
}

.summary-table-tw .total-row {
	font-size: 1.35rem; font-weight: 900; color: var(--shop-primary);
	margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px dashed var(--shop-border);
}

/* ══ PREMIUM BUTTONS ══ */
.btn-primary-tw {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem;
    text-align: center; color: white !important; font-weight: 700; 
    padding: 1.125rem 1.5rem; border-radius: 1rem; text-decoration: none;
    background: linear-gradient(135deg, var(--shop-primary) 0%, color-mix(in srgb, var(--shop-primary) 85%, #000) 100%);
    box-shadow: 0 4px 15px color-mix(in srgb, var(--shop-primary) 25%, transparent);
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; border: none;
    font-size: 1rem;
}
.btn-primary-tw:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px color-mix(in srgb, var(--shop-primary) 40%, transparent);
    filter: brightness(1.1); color: white !important;
}

.btn-secondary-tw {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem;
    text-align: center; background: var(--shop-bg-alt, #f3f4f6); 
    color: var(--shop-text-primary); font-weight: 700;
    padding: 1.125rem 1.5rem; border-radius: 1rem; text-decoration: none;
    transition: all 250ms ease; border: 1.5px solid var(--shop-border, #e5e7eb);
    font-size: 0.95rem;
}
.btn-secondary-tw:hover {
    background: var(--shop-border);
    transform: translateY(-2px);
}

/* ══ RESPONSIVE MOBILE (Card Style) ══ */
@media (max-width: 767.98px) {
    .cart-table-tw table thead { display: none; }
    
    .cart-table-tw tbody tr {
        display: block;
        padding: 1.25rem;
        position: relative;
        border-bottom: 8px solid var(--shop-bg-alt);
    }
    
    .cart-table-tw tbody tr:last-child { border-bottom: none; }
    
    .cart-table-tw tbody td {
        display: block;
        padding: 0.5rem 0;
        border: none;
        text-align: left !important;
    }
    
    .cart_product_img {
        float: left;
        margin-right: 1rem;
        padding-top: 0 !important;
    }
    
    .cart_product_name {
        padding-top: 0 !important;
    }
    
    .cart_product_name h5 {
        font-size: 0.9rem;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .cart-table-tw td.price {
        display: inline-block;
        padding: 0 !important;
    }
    
    .cart-table-tw td.price span {
        font-size: 0.9rem;
        color: var(--shop-primary);
    }
    
    .cart-table-tw td.qty {
        margin-top: 1rem;
        clear: both;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0 !important;
        border-top: 1px solid var(--shop-bg-alt) !important;
    }
    
    .cart-table-tw td.qty::before {
        content: "Quantité:";
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--shop-text-secondary);
    }
    
    .qty-control { margin: 0; }
    
    .cart-table-tw td.total_price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0 !important;
        border-top: 1px dashed var(--shop-border) !important;
    }
    
    .cart-table-tw td.total_price::before {
        content: "Total ligne:";
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--shop-text-secondary);
    }
    
    .cart-table-tw td.total_price span {
        font-size: 1.1rem;
        color: var(--shop-primary);
    }
    
    .action-cell {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        padding: 0 !important;
    }
    
    .action-cell .fc-trash-btn {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }

    /* Buttons optimization */
    .btn-primary-tw, .btn-secondary-tw {
        padding: 0.875rem 1rem;
        font-size: 0.9rem;
        border-radius: 0.85rem;
    }
    
    .cart-summary-tw {
        padding: 1.25rem;
        margin-top: 2rem !important;
    }
    
    .cart-summary-tw h5 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .summary-table-tw .total-row {
        font-size: 1.2rem;
        margin-top: 1rem;
        padding-top: 1rem;
    }
}
</style>