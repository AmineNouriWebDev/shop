<div class="main main-content-wrapper pb-5 mb-5">
    <!-- Product Details Area Start -->
    <div class="single-product-area section-padding-20 clearfix pb-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 row mx-0 text-center text-lg-start">
                    <div class="col-12 col-lg-6 mx-auto">
                        <div class="single_product_thumb mb-4 mb-lg-0">
                            
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ul class="carousel-indicators">
                                    <li data-target="#product_details_slider" data-slide-to="0" class="active" style="background: url('media/products/<?php echo $photo; ?>') no-repeat center;background-size: contain;"></li>
                                    <?php 
                                    if(imgproduit($id)){
                                        $req1 = "SELECT * FROM `images_produit` WHERE `id_produit` = '".$id."'";
                                        $res1 = executeRequete($req1);
                                        $c="1";
                                        while($dataip = mysqli_fetch_array($res1)){    
                                    ?>
                                        <li data-target="#product_details_slider" data-slide-to="<?php echo $c; ?>" style="background: url('<?php echo imagesproduitSite($dataip['id']); ?>') no-repeat center;background-size: contain;"></li>
                                    <?php $c++; }} 
                                    
                                    // Initialize variables for order form
                                    $sous_total = isset($sous_total) ? $sous_total : 0;
                                    $total = isset($total) ? $total : 0;
                                    $frais = isset($frais) ? $frais : 0;
                                    ?>
                                </ul>
                                <div class="carousel-inner text-center">
                                    <div class="carousel-item active">
                                        <img class="img-fluid myImage" src="media/products/<?php echo $photo; ?>" alt="First slide">
                                    </div>
                                    <?php 
                                    if(imgproduit($id)){
                                        $req2 = "SELECT * FROM `images_produit` WHERE `id_produit` = '".$id."'";
                                        $res2 = executeRequete($req2);
                                        while($dataip2 = mysqli_fetch_array($res2)){    
                                    ?>
                                        <div class="carousel-item">
                                            <img class="img-fluid myImage" src="<?php echo imagesproduitSite($dataip2['id']); ?>" alt="First slide">
                                        </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="single_product_desc">
                            <div class="product-meta-data">
                                <div class="d-lg-none">
                                    <div class="product-meta-data mb-3">
                                        <p class="fs-1 fw-black text-primary mt-2" style="font-weight: 900; letter-spacing: -1px; color: var(--shop-primary) !important;"><?php if($PrixPromo != '0.000') { echo $PrixPromo.' DT <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.$PrixVente.' DT</span>'; }else{ echo $PrixVente.' DT'; } ?></p>
                                    </div>
                                </div>  
                                <div class="line"></div>
                                <h2><?php echo $titre; ?></h2>
                                <?php if(marquesProduits($id) != '0' && ApercuMarque(marquesProduits($id)) !='') {  ?>
                                    <div class="mb-3" style="height:60px;overflow:hidden"><img src="<?php echo photoMarqueSite(marquesProduits($id)); ?>" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"></div>
                                <?php } ?>
                                <?php if ($etatStock == '1'){  ?>
                                    <p class="avaibility"><i class="fa fa-circle"></i> En Stock</p>
                                <?php }else{?>
                                    <p class="avaibility"><i class="fa fa-circle rupture"></i> En Rupture</p>
                                <?php } ?>
                            </div>
                            <div class="short_overview my-3">
                                <?php echo courtContenuProduits($id); ?>
                            </div>
                            <?php if(rqProduits($id)){ ?>
                                <div class="remarque bg-warning-subtle text-amber-800 p-3 rounded-2xl mb-4 border border-amber-200" style="font-size:0.9rem;font-weight:600">
                                    <i class="fa fa-info-circle me-2"></i> <?php echo rqProduits($id); ?>
                                </div>
                            <?php } ?>
                            
                            <?php if($contenu != "") { ?>
                                <a href="#details-complets" class="btn-secondary-tw d-inline-block p-2 px-4 mb-4" style="border-radius:2rem; font-size:0.85rem;">
                                    <i class="fa fa-arrow-down me-2"></i> Afficher plus de détails
                                </a>
                            <?php } ?>
                            
                            <?php if ($etatStock == '1'){  ?>
                                <div class="cart-table-area mt-4">
                                    <div class="cart-summary m-0 p-4 border rounded-3xl shadow-sm bg-white">
                                        <a href="applications.php" class="btn-secondary-tw w-100 d-block text-center text-uppercase mb-4">Télécharger nos applications</a>
                                        
                                        <!-- Commande Express Toggle -->
                                        <button class="btn-primary-tw w-100 d-flex justify-content-between align-items-center fw-bold btn-express-toggle collapsed" type="button" onclick="$('#collapseExpress').slideToggle(); $(this).find('.toggle-icon').toggleClass('fa-chevron-down fa-chevron-up');">
                                            <span><i class="fa fa-bolt text-warning me-2"></i> Commande Express Rapide</span>
                                            <i class="fa fa-chevron-down toggle-icon"></i>
                                        </button>

                                        <div class="mt-3" id="collapseExpress" style="display:none;">
                                            <hr class="mb-4">
                                            <form class="cart" id="commandeExpressForm" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <label class="fw-semibold text-secondary small">Nom <span class="text-danger">*</span></label>
                                                    <input type="text" name="nom" class="form-control form-control-tw" required>
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label class="fw-semibold text-secondary small">Prénom <span class="text-danger">*</span></label>
                                                    <input type="text" name="prenom" class="form-control form-control-tw" required>
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label class="fw-semibold text-secondary small">Téléphone <span class="text-danger">*</span></label>
                                                    <input type="text" name="tel" class="form-control form-control-tw" required>
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <label class="fw-semibold text-secondary small">Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control form-control-tw" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 fw-semibold text-secondary small">Choisissez la plateforme pour recevoir la confirmation:</label>
                                                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-lg-start">
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input type="radio" name="platform" value="whatsapp" id="platform_whatsapp" class="custom-control-input" required>
                                                        <label class="custom-control-label d-flex align-items-center" for="platform_whatsapp"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width:20px;height:20px;margin-right:8px;"> WhatsApp</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input type="radio" name="platform" value="messenger" id="platform_messenger" class="custom-control-input">
                                                        <label class="custom-control-label d-flex align-items-center" for="platform_messenger"><img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg" alt="Messenger" style="width:20px;height:20px;margin-right:8px;"> Messenger</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="platform" value="telegram" id="platform_telegram" class="custom-control-input">
                                                        <label class="custom-control-label d-flex align-items-center" for="platform_telegram"><img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" style="width:20px;height:20px;margin-right:8px;"> Telegram</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-check mb-3 text-start" style="color:#000; font-size: 13px;">
                                                            <input type="checkbox" class="form-check-input" id="cgv" required> J'accepte les <a href="#politique" data-toggle="modal" class="politique">Conditions Générales de Ventes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="payment-method">
<?php
if(typeProduits($id)=="A") {
    $requetepay = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1" AND id <>"9"';
} else {
    $requetepay = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1"';
}
$respay = executeRequete($requetepay);
$first = true;
while($datapay = mysqli_fetch_array($respay)){
?>
    <div class="custom-control custom-radio mr-sm-2">
        <input 
            type="radio" 
            name="paymentMethod" 
            class="custom-control-input" 
            value="<?php echo $datapay['id']; ?>" 
            id="payment_<?php echo $datapay['id'];?>" 
            <?php if ($first) { echo 'required'; $first = false; } ?>
        >
        <label class="custom-control-label" for="payment_<?php echo $datapay['id']; ?>">
            $label = moyen_paiement($datapay['id']);
            // We just output the text label. Images removed to save space on mobile form.
            echo '<span class="fw-semibold text-secondary mx-2">' . $label . '</span>';
            ?>
        </label>
    </div>
<?php } ?>
</div>

                                            <hr class="my-4">
                                            <div class="form-group mb-0 mt-2">
                                                <button type="submit" name="" class="btn-primary-tw w-100 border-0">Confirmer la commande</button>
                                                <input type="hidden" name="action" id="" value="cmd_express" />
                                                <input type="hidden" name="soustotal" id="stotal_commande" value="<?php echo $sous_total; ?>" />
                                                <input type="hidden" name="total" id="total_commande" value="<?php echo $total; ?>" />
                                                <input type="hidden" name="frais_livraison" id="frais_commande" value="<?php echo $frais; ?>" />
                                                <input type="hidden" name="qte_cmd" id="qte_cmd" value="1" />
                                                <input type="hidden" name="prod_cmd" id="prod_cmd" value="<?php echo $id; ?>" />
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                            
                            <!-- LONG CONTENT INJECTION -->
                            <div class="mt-5 text-start" id="details-complets">
                                <?php if($contenu != "") { ?>
                                    <h4 class="fw-bold mb-4 border-bottom pb-2">Détails du produit</h4>
                                    <div class="product-long-content text-secondary lh-lg" style="font-size: 0.95rem;">
                                        <?php echo $contenu; ?>
                                    </div>
                                <?php } ?>
                                
                                <?php if($video != "") { ?>
                                    <h4 class="fw-bold mb-4 mt-5 border-bottom pb-2">Vidéo de présentation</h4>
                                    <div class="ratio ratio-16x9 rounded-2xl overflow-hidden shadow-sm border">
                                        <?php echo $video; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            
                        </div>
                    </div>
                </div>...
                
                
                
                
                <!--------------------------------------------------- sidebar ---------------------------------------------------------------->
                    
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="sticky-top pt-2 full-sc ">
                            <div class="single_product_desc bg-white shadow-sm border px-3 py-4 rounded-3xl text-center">
    	                        
                                <div class="product-meta-data mb-4">
    	                            <p class="fs-1 fw-black text-primary mt-2" style="font-weight: 900; letter-spacing: -1px; color: var(--shop-primary) !important;"><?php if($PrixPromo != '0.000') { echo $PrixPromo.' DT <br/><span class="text-muted text-decoration-line-through fs-5 fw-normal" style="color:#9ca3af !important;">'.$PrixVente.' DT</span>'; }else{ echo $PrixVente.' DT'; } ?></p>
                                </div>
                                    
                                <!-- Add to Cart Form -->
                                <form class="cart clearfix d-flex flex-column align-items-center" method="post">
                                    <div class="cart-btn d-flex mx-auto mb-4 align-items-center bg-white border border-2 border-primary rounded-pill px-2 py-1 shadow-sm" style="border-color: var(--shop-primary) !important;">
                                        <div class="quantity d-flex align-items-center">
                                            <span class="qty-minus text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="cursor:pointer; width:35px; height:35px; background:#f3f4f6; font-size:1.5rem; line-height:1;" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) && qty > 1 ) effect.value--;return false;">−</span>
                                            <input type="number" class="qty-text border-0 bg-transparent text-center fw-bold fs-5 mx-2" style="width:50px; outline:none;" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                            <span class="qty-plus text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="cursor:pointer; width:35px; height:35px; background:#f3f4f6; font-size:1.5rem; line-height:1;" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;">+</span>
                                        </div>
                                    </div>
    								<?php if ($etatStock == '1'){  ?>
                                    <button type="button" name="addtocart" value="5" class="btn-primary-tw w-100 border-0 shadow-none text-uppercase py-3 fs-6" style="border-radius:1rem" onclick="addToCart(<?php echo $id; ?>, document.getElementById('qty').value);"><i class="fa fa-shopping-bag me-2"></i> Ajouter au panier</button>
                                    <?php }else{?>
    								<button type="button" name="addtocart" value="5" class="btn-secondary-tw w-100 border-0 text-uppercase py-3 fs-6" style="border-radius:1rem" onclick="addToCart(<?php echo $id; ?>, document.getElementById('qty').value);" disabled><i class="fa fa-shopping-bag me-2"></i> Ajouter au panier</button>
    								<?php } ?>
    							</form>
                            </div>
                            
                            
                            <?php 
                                $reqs ="SELECT * FROM `services` ORDER BY `ordre` ASC";
                                $ress =executeRequete($reqs);
                                while($datas = mysqli_fetch_array($ress)){
                            ?>
                            <div class="bg-white p-3 mt-3 rounded-2xl shadow-sm border d-flex align-items-center" style="font-size:0.85rem; font-weight:600; color:#374151;">
                                <div class="rounded-circle d-flex justify-content-center align-items-center me-3" style="width:45px; height:45px; background:var(--shop-bg-alt);">
                                    <img src="<?php echo photoServiceSite($datas['id']); ?>" width="24px" alt="Service" /> 
                                </div>
                                <span class="lh-sm"><?php echo titreService($datas['id']); ?></span>
                            </div>    
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="politique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><?php echo titrePage(26); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo contenuPage(26); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('commandeExpressForm').addEventListener('submit', function(event) {
    event.preventDefault();
    if (!document.getElementById('cgv').checked) {
        alert('Veuillez accepter les Conditions Générales de Ventes.');
        return;
    }
    const now = new Date();
    const date = now.toLocaleDateString('fr-TN'); // e.g. "14/06/2025"
    const time = now.toLocaleTimeString('fr-TN', { hour: '2-digit', minute: '2-digit' }); // e.g. "15:42"
    const nom = document.querySelector('input[name="nom"]').value;
    const prenom = document.querySelector('input[name="prenom"]').value;
    const tel = document.querySelector('input[name="tel"]').value;
    const Quantity = document.querySelector('input[name="qte_cmd"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const platform = document.querySelector('input[name="platform"]:checked').value;
    const payment = document.querySelector(`label[for="${document.querySelector('input[name="paymentMethod"]:checked').id}"]`).textContent.trim();
    const productTitle = '<?php echo addslashes($titre); ?>';
    const productPrice = '<?php if($PrixPromo != "0.000") { echo $PrixPromo; } else { echo $PrixVente; } ?>';
    const productUrl = window.location.href;
    const message = `
🌟 *Nouvelle Commande Express* 🌟

🛍️ *Produit:* _${productTitle}_ (Lien: ${productUrl} )
💵 *Prix:* _${productPrice} DT_
📦 *Quantité:* ${Quantity}

───────────────

👤 *Informations Client:*
👨‍💼 *Nom:* ${nom} ${prenom}
📞 *Téléphone:* ${tel}
📧 *Email:* ${email}
💳 *Paiement:* ${payment}

───────────────

✅ Merci de *confirmer* cette commande dès que possible.
🗓️ *Date de commande:* ${date}
⏰ *Heure:* ${time}
    `.trim();
    const encodedMessage = encodeURIComponent(message);
    let url;
    if (platform === 'whatsapp') {
        url = `https://wa.me/<?php echo $cmd_num_whatsapp; ?>?text=${encodedMessage}`;
    } else if (platform === 'telegram') {
        url = `https://t.me/technoplusfr?text=${encodedMessage}`;
    } else if (platform === 'messenger') {
        url = '<?php echo $lien_cmd_messenger; ?>'.replace('%%TXT%%', encodedMessage);
    }
    window.location.href = url;
});
</script>

<script>
// Smooth scroll for "Afficher plus de détails"
document.querySelectorAll('a[href="#details-complets"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});
</script>

<!--------------------------------------------------- Facebook ---------------------------------------------------------------->
                
                <script>
                    fbq('track','ViewContent',{
                        content_type: 'product',
                        content_ids:['<?php echo $id;?>'],
                        content_name:'<?php echo $titre;?>',
                        value:'<?php echo $price;?>',
                        currency: 'TND'
                    });
                </script>                
                <!------------------------------------------------------- PRODUITS SIMILAIRES ------------------------------------------------------------>
                <?php 
		            $requete = 'SELECT * FROM `produits_similaire` WHERE `id_produit` ="'.$id.'" AND id_categ !="0"';
                    $resultat = executeRequete($requete);
	                $num = mysqli_num_rows($resultat);
		            if ($num > 0 ) {?>
		            <div class="my-4">
        	            <h2>Produits similaires</h2>
        	            <div class="prod-similaire slider justify-content-center">
        		            <?php
        		            
        		            while ($datapr = mysqli_fetch_array($resultat))  {
        		                
                    		    if($datapr['id_categ']){   
                    				$id_categ = $datapr['id_categ'];  
                		            $requete1 = 'SELECT * FROM `produits` WHERE `categorie` ="'.$id_categ.'"';
                                    $resultat1 = executeRequete($requete1);
        		                    while ($datapr1 = mysqli_fetch_array($resultat1))  {
                    				$id_p = $datapr1['id']; 
                    				$link_p  = linkProduits($id_p); 
                    		    
                    		?>
			                    <div class="mb-4 slide px-2">
        							<div class="single-product-wrapper border p-2 text-center hoverDiv h-100">
        								<!-- Product Image -->
        								<a href="<?php echo lienProduits($link_p); ?>" class="product-img hover-zoom">
        									<img src="<?php echo photoProduitsSite($id_p); ?>" alt="" class="img-fluid">
        								</a>
        
        								<!-- Product Description -->
        								<div class="product-description d-flex flex-column align-items-center justify-content-between">
        									<!-- Product Meta Data -->
        									<div class="product-meta-data text-center">
        										<a href="<?php echo lienProduits($link_p); ?>">
        											<h6><?php echo titreProduits($id_p); ?></h6>
        										</a>
        										<div class="line mx-auto my-2 h-auto"></div>
        										<?php
        										if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 
            									$output = '<div style="height:60px;overflow:hidden"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid mx-auto" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';
            									}
        										echo $output;
        										?>
            									<?php if (etatStockProduits($id_p) == '1'){ ?> 
                                                    <p class="avaibility m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>
        								        <?php }else{?>
                                                    <p class="avaibility m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>
        								        <?php } ?>
        										<?php if(prixPromoProduits($id_p) != '0.000') { ?>
            									<p class="product-price"><?php echo prixPromoProduits($id_p); ?> DT  <br/> <span style="text-decoration:line-through;color:#aaa;font-size: 18px;"><?php echo prixVenteProduits($id_p); ?> DT</span> </p>
            									<?php }else{?>
            									<p class="product-price"><?php echo prixVenteProduits($id_p); ?> DT </p>
            									<?php }?>
        									</div>
        									<!-- Ratings & Cart -->
        									<div class="ratings-cart d-flex w-100 justify-content-between">
    										    <div class="cart">
        										<?php if(etatStockProduits($id_p) == '1'){  ?>
                                                 <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p) ?>,'1')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"  style="font-size: 12px;padding: 0px 1px;"><img src="dist/img/cart.png" alt="" class="img-fluid" style="width:15px!important;display:inline-block;"> Ajouter au panier</button>
        								        <?php }else{ ?>
                                                 <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(<?php echo afficheChamp($id_p) ?>,'1')" id="AddCart" style="background: unset;opacity: 0.5; font-size: 12px;padding: 0px 1px;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid" style="width:15px!important;display:inline-block;"> Ajouter au panier</button>
        								        <?php } ?>
        												
        										</div>
        										<div class="cart" data-toggle="tooltip" data-placement="top" title="Détails produit">
        											<a href="<?php echo lienProduits($link_p); ?>"  class="btn btn-primary-outline"  style="font-size: 12px;padding: 0px 1px;"><i class="fa fa-eye" style="color:#ababab"></i> Voir détails</a>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>
        	            <?php } } } ?>
        	            </div>
    	            </div>
    	            <?php } ?>
                
            </div>
        </div>
	
	</div>
	
	    <div class="modal fade" id="politique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel"><?php echo titrePage(26); ?></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>
<style>
/* ── Product Details Overrides ───────────────────────── */
.btn-primary-tw {
	display: inline-block; text-align: center; background: var(--shop-primary, #5A31F4); color: white;
	font-weight: 600; padding: 0.875rem 1.25rem; border-radius: 0.875rem; text-decoration: none;
	transition: background 200ms ease, transform 150ms ease, box-shadow 200ms ease; cursor: pointer;
}
.btn-primary-tw:hover {
	background: var(--shop-primary-hover, #421bb6); color: white; text-decoration: none;
	transform: translateY(-2px); box-shadow: 0 8px 24px color-mix(in srgb, var(--shop-primary, #5A31F4) 35%, transparent);
}
.btn-secondary-tw {
	display: inline-block; text-align: center; background: var(--shop-bg-alt, #e5e7eb); color: var(--shop-text-primary, #1a1a2e);
	font-weight: 600; padding: 0.875rem 1.25rem; border-radius: 0.875rem; text-decoration: none; transition: background 200ms ease;
}
.btn-secondary-tw:hover {
    background: #d1d5db; color: #1a1a2e; text-decoration: none;
}
.btn-disabled-tw {
	display: inline-block; text-align: center; background: #f3f4f6; color: #9ca3af;
	font-weight: 600; padding: 0.875rem 1.25rem; border-radius: 0.875rem; text-decoration: none; cursor: not-allowed;
}
.rounded-3xl { border-radius: 1.5rem !important; }
.rounded-2xl { border-radius: 1rem !important; }
.form-control-tw {
    border-radius: 0.75rem; border: 1.5px solid var(--shop-border, #e5e7eb); padding: 0.6rem 1rem;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.form-control-tw:focus { border-color: var(--shop-primary, #5A31F4); box-shadow: 0 0 0 3px color-mix(in srgb, var(--shop-primary) 15%, transparent); }
.single_product_desc h2 { font-weight: 800; color: var(--shop-text-primary); letter-spacing: -0.02em; }
.avaibility i { color: #10b981; }
.avaibility i.rupture { color: #ef4444; }
.product-price { font-weight: 700; color: var(--shop-primary, #5A31F4); }
.product-long-content img { max-width: 100%; height: auto; border-radius: 0.75rem; margin-top: 1rem; margin-bottom: 1rem; }
.product-long-content h1, .product-long-content h2, .product-long-content h3 { color: var(--shop-text-primary); font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem;}

/* Commande Express accordion state */
.btn-express-toggle[aria-expanded="true"] .toggle-icon { transform: rotate(180deg); }
.toggle-icon { transition: transform 0.3s ease; }
</style>