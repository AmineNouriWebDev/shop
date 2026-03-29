<div class="main main-content-wrapper pb-5 mb-5" style="overflow-x: hidden;">
    <!-- Product Details Area Start -->
    <div class="single-product-area section-padding-20 clearfix pb-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 row">
                    <div class="col-12 col-lg-6">
                        <div class="single_product_thumb mb-4 mb-lg-0 mobile-center-img">
                            
                            <div class="product-gallery-tw" style="display:flex; flex-direction:column; gap:1rem;">
                                <!-- Main Image with Zoom -->
                                <div style="border:1px solid var(--shop-border, #e5e7eb); border-radius:1rem; overflow:hidden; background:var(--shop-surface, #fff); display:flex; align-items:center; justify-content:center; aspect-ratio:1/1; position:relative;">
                                    <img id="main-product-image" class="myImage" src="media/products/<?php echo $photo; ?>" alt="<?php echo htmlspecialchars($titre); ?>" style="max-width:100%; max-height:100%; object-fit:contain; display:block;">
                                    <div style="position:absolute; bottom:0.5rem; right:0.75rem; background:rgba(0,0,0,0.5); color:#fff; font-size:0.72rem; padding:3px 9px; border-radius:99px; pointer-events:none;">
                                        <i class="fa fa-search-plus me-1"></i> Zoomer
                                    </div>
                                </div>
                                
                                <!-- Thumbnails Row — hidden/shown by selectColor() -->
                                <div id="thumbnail-container" style="display:flex; gap:0.625rem; overflow-x:auto; padding-bottom:0.25rem;">
                                    <?php
                                    /* Main photo — generic (no color) */
                                    $mainSrc = 'media/products/'.$photo;
                                    ?>
                                    <button type="button" class="thumb-btn active-thumb" data-color-group="0" onclick="changeMainImage(this,'<?php echo $mainSrc; ?>')">
                                        <img src="<?php echo $mainSrc; ?>" alt="<?php echo htmlspecialchars($titre); ?>">
                                    </button>

                                    <?php
                                    /* Extra generic images */
                                    $req_gen = "SELECT id FROM `images_produit` WHERE `id_produit` = '".$id."'";
                                    $res_gen = executeRequete($req_gen);
                                    while($dgen = mysqli_fetch_array($res_gen)){
                                        $gSrc = imagesproduitSite($dgen['id']);
                                    ?>
                                    <button type="button" class="thumb-btn" data-color-group="0" onclick="changeMainImage(this,'<?php echo $gSrc; ?>')">
                                        <img src="<?php echo $gSrc; ?>" alt="<?php echo htmlspecialchars($titre); ?>">
                                    </button>
                                    <?php } ?>

                                    <?php
                                    /* Color-specific images */
                                    $req_ci = "SELECT idcouleur, image_path FROM `produit_images_couleurs` WHERE `idproduit` = '".$id."'";
                                    $res_ci = executeRequete($req_ci);
                                    while($dataci = mysqli_fetch_array($res_ci)){
                                        $cSrc = 'media/products/'.$dataci['image_path'];
                                    ?>
                                    <button type="button" class="thumb-btn" data-color-group="<?php echo intval($dataci['idcouleur']); ?>" style="display:none" onclick="changeMainImage(this,'<?php echo $cSrc; ?>')">
                                        <img src="<?php echo $cSrc; ?>" alt="<?php echo htmlspecialchars($titre); ?>">
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>

                            <script>
                            function changeMainImage(btn, src) {
                                document.getElementById('main-product-image').src = src;
                                document.querySelectorAll('.thumb-btn').forEach(function(el){
                                    el.classList.remove('active-thumb');
                                });
                                btn.classList.add('active-thumb');
                                if(typeof $ !== 'undefined' && $.fn.imagezoomsl) {
                                    try { $('.myImage').imagezoomsl({ zoomrange:[3,3] }); } catch(e){}
                                }
                            }
                            </script>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="single_product_desc">
                            <div class="product-meta-data">
                                <!-- Mobile Price block removed in favor of unhidden sidebar block below -->
                                <div class="line"></div>
                                <h2><?php echo $titre; ?></h2>
                                <?php if(marquesProduits($id) != '0' && ApercuMarque(marquesProduits($id)) !='') {  ?>
                                    <div class="mb-3" style="height:60px;overflow:hidden"><img src="<?php echo photoMarqueSite(marquesProduits($id)); ?>" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"></div>
                                <?php } ?>

                                <?php
                                // ── Star Rating Block ─────────────────────────────────
                                $prod_note   = floatval(noteAvisProduits($id));
                                $prod_nb     = intval(nbAvisProduits($id));
                                $client_logged = !empty($_SESSION['id_client']) ? intval($_SESSION['id_client'])
                                              : (!empty($_SESSION['client_id']) ? intval($_SESSION['client_id'])
                                              : (!empty($_SESSION['id']) ? intval($_SESSION['id']) : 0));
                                // Check if client already voted
                                $client_vote = 0;
                                if ($client_logged) {
                                    $rv = executeRequete("SELECT note FROM avis_produits WHERE id_produit='$id' AND id_client='$client_logged' LIMIT 1");
                                    if ($rv && $drv = mysqli_fetch_assoc($rv)) $client_vote = intval($drv['note']);
                                }
                                ?>
                                <?php if ($id > 0): // Always show if we have a valid product ?>
                                <div id="product-rating-block" style="margin-bottom:0.85rem;">
                                    <!-- Display stars SVG -->
                                    <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                                        <div class="stars-display" style="display:flex; gap:2px;" aria-label="Note: <?php echo $prod_note; ?> sur 5">
                                            <?php
                                            // Generate 5 SVG stars with partial fill
                                            for ($si = 1; $si <= 5; $si++):
                                                $fill_pct = 0;
                                                if ($prod_note >= $si) $fill_pct = 100;
                                                elseif ($prod_note > $si-1) $fill_pct = round(($prod_note - ($si-1)) * 100);
                                                $clip_id = 'sc-' . $id . '-' . $si;
                                            ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                                <defs>
                                                    <clipPath id="<?php echo $clip_id; ?>">
                                                        <rect x="0" y="0" width="<?php echo $fill_pct; ?>%" height="100%"/>
                                                    </clipPath>
                                                </defs>
                                                <!-- Grey empty star -->
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="#e5e7eb"/>
                                                <!-- Gold filled star clipped -->
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="#F59E0B" clip-path="url(#<?php echo $clip_id; ?>)"/>
                                            </svg>
                                            <?php endfor; ?>
                                        </div>
                                        <span id="prod-note-<?php echo $id; ?>" style="font-size:0.92rem; font-weight:700; color:var(--shop-text-primary);"><?php echo number_format($prod_note,1,'.',''); ?></span>
                                        <span id="nb-avis-<?php echo $id; ?>" style="font-size:0.82rem; color:var(--shop-text-secondary,#6b7280); <?php echo ($prod_nb > 0 ? '' : 'display:none;'); ?>">
                                            (<?php echo $prod_nb; ?> avis)
                                        </span>
                                    </div>

                                    <!-- Interactive voting (guests will be prompted to login on click) -->
                                    <div style="margin-top:0.5rem;">
                                        <span id="vote-label-<?php echo $id; ?>" style="font-size:0.78rem; color:var(--shop-text-secondary,#6b7280); display:block; margin-bottom:3px;">
                                            <?php 
                                            if ($client_logged) {
                                                echo $client_vote ? 'Votre note : ' . $client_vote . '/5 — Modifier :' : 'Notez ce produit :'; 
                                            } else {
                                                echo 'Notez ce produit :';
                                            }
                                            ?>
                                        </span>
                                        <div class="stars-vote" id="stars-vote-<?php echo $id; ?>" style="display:flex; gap:3px; cursor:pointer;">
                                            <?php for ($vi = 1; $vi <= 5; $vi++): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                                 class="vote-star" data-val="<?php echo $vi; ?>"
                                                 style="transition:transform 150ms ease; <?php echo ($vi <= $client_vote ? 'fill:#F59E0B;' : 'fill:#e5e7eb;'); ?>"
                                                 onclick="rateProduct(<?php echo $id; ?>, <?php echo $vi; ?>)"
                                                 onmouseover="highlightStars(<?php echo $id; ?>, <?php echo $vi; ?>)"
                                                 onmouseout="resetStars(<?php echo $id; ?>, <?php echo ($client_vote ?: 0); ?>)">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="inherit"/>
                                            </svg>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; /* end rating block */ ?>

                                <?php if ($etatStock == '1'){  ?>
                                    <p class="avaibility"><i class="fa fa-circle"></i> En Stock</p>
                                <?php }else{?>
                                    <p class="avaibility"><i class="fa fa-circle rupture"></i> En Rupture</p>
                                <?php } ?>

                                <!-- Desktop Price moved to the right column context (below) -->

                                <!-- VARIATIONS UI -->
                                <div class="product-variations mt-4 mb-4" id="productVariationsWrapper">
                                <!-- 1. COLORS -->
                                <?php
                                $first_color_id = null;
                                $q_cols = executeRequete("SELECT pc.idcouleur, c.nom, c.code_hexa FROM produit_couleurs pc JOIN couleurs c ON pc.idcouleur=c.id WHERE pc.idproduit='$id' ORDER BY c.nom");
                                if(mysqli_num_rows($q_cols) > 0) {
                                    echo '<div class="variation-group mb-4">';
                                    echo '<h6 class="mb-2 fw-bold" style="font-size:0.95rem;">Couleur : <span id="selected-color-name" class="fw-normal text-secondary">Choisissez</span></h6>';
                                    echo '<div class="d-flex flex-wrap gap-3">';
                                    while($col = mysqli_fetch_assoc($q_cols)) {
                                        if(!$first_color_id) $first_color_id = $col['idcouleur'];
                                        echo '<div class="color-swatch mr-2" data-color-id="'.$col['idcouleur'].'" data-color-name="'.$col['nom'].'" style="width: 36px; height: 36px; border-radius: 50%; background-color: '.$col['code_hexa'].'; cursor: pointer; border: 2px solid transparent; box-shadow: 0 0 0 1px #e2e8f0; transition: all 0.2s;" onclick="selectColor(this, '.$col['idcouleur'].')"></div>';
                                    }
                                    echo '</div></div>';
                                }

                                // 2. OTHER CHARACTERISTICS (RAM, Storage, etc)
                                // Load all combination variations for JS
                                $variationsMap = [];
                                $q_vmap = executeRequete("SELECT valeurs_ids, prix_vente, prix_promo FROM produit_variations WHERE idproduit='$id'");
                                while ($vmap_row = mysqli_fetch_assoc($q_vmap)) {
                                    $variationsMap[$vmap_row['valeurs_ids']] = [
                                        'pv' => floatval($vmap_row['prix_vente']),
                                        'pp' => floatval($vmap_row['prix_promo'])
                                    ];
                                }

                                $q_caracs = executeRequete("SELECT DISTINCT cp.idcarac, c.titre FROM caracteristique_prod cp JOIN caracteristiques c ON cp.idcarac=c.id WHERE cp.idproduit='$id' ORDER BY c.titre");
                                while($carac = mysqli_fetch_assoc($q_caracs)) {
                                    $idcarac = $carac['idcarac'];
                                    $q_vals = executeRequete("SELECT cp.*, vc.valeur as text_valeur FROM caracteristique_prod cp JOIN valeur_caracteristique vc ON cp.valeur = vc.id WHERE cp.idproduit='$id' AND cp.idcarac='$idcarac' ORDER BY CAST(vc.valeur AS UNSIGNED), vc.valeur");
                                    if(mysqli_num_rows($q_vals) > 0) {
                                        echo '<div class="variation-group mb-4" data-group-id="'.$idcarac.'">';
                                        echo '<h6 class="mb-2 fw-bold" style="font-size:0.95rem;">'.$carac['titre'].' :</h6>';
                                        echo '<div class="d-flex flex-wrap gap-2">';
                                        while($val = mysqli_fetch_assoc($q_vals)) {
                                            $disp_val = isset($val['text_valeur']) ? $val['text_valeur'] : $val['valeur'];
                                            echo '<button type="button" class="btn btn-outline-secondary variation-btn" data-val-id="'.$val['valeur'].'" data-group-id="'.$idcarac.'" style="border-radius: 6px; padding: 6px 14px; font-weight: 500;" onclick="selectVariation(this)">'.$disp_val.'</button>';
                                        }
                                        echo '</div></div>';
                                    }
                                }
                                ?>
                                </div>
                                <script>
                                // Combination variations map: key = sorted val IDs joined by comma
                                var variationsMap = <?php echo json_encode($variationsMap); ?>;
                                var defaultPV = <?php echo floatval($PrixVente); ?>;
                                var defaultPP = <?php echo floatval($PrixPromo); ?>;

                                function getSelectedValIds() {
                                    var ids = [];
                                    document.querySelectorAll('.variation-group').forEach(function(group) {
                                        var active = group.querySelector('.variation-btn.btn-dark');
                                        if (active) {
                                            ids.push(parseInt(active.getAttribute('data-val-id')));
                                        }
                                    });
                                    ids.sort(function(a, b) { return a - b; });
                                    return ids;
                                }

                                function lookupCombinationPrice() {
                                    var ids = getSelectedValIds();
                                    if (ids.length === 0) return null;
                                    var key = ids.join(',');
                                    return variationsMap[key] || null;
                                }

                                let currentVPrice = null;
                                let currentVName = null;


                                function selectColor(element, colorId) {
                                    // 1. Update visual style of color swatches
                                    document.querySelectorAll('.color-swatch').forEach(el => {
                                        el.style.borderColor = 'transparent';
                                        el.style.boxShadow = '0 0 0 1px #e2e8f0';
                                    });
                                    element.style.borderColor = '#000';
                                    element.style.boxShadow = '0 0 0 2px #000';

                                    // 2. Update color name label
                                    let colorName = element.getAttribute('data-color-name');
                                    let label = document.getElementById('selected-color-name');
                                    if (label) {
                                        label.textContent = colorName;
                                        label.classList.remove('text-secondary');
                                        label.classList.add('text-dark', 'fw-bold');
                                    }

                                    // 3. Filter thumbnails based on color group
                                    // If colorId has its own images => show only those
                                    // If colorId has no images => fallback to generic group 0
                                    let thumbs = document.querySelectorAll('.thumb-btn');
                                    let firstVisible = null;

                                    // Check if there are any images specific to this color
                                    let hasColorImages = false;
                                    thumbs.forEach(thumb => {
                                        if (parseInt(thumb.getAttribute('data-color-group')) === colorId) {
                                            hasColorImages = true;
                                        }
                                    });

                                    thumbs.forEach(thumb => {
                                        let group = parseInt(thumb.getAttribute('data-color-group'));
                                        let show = false;

                                        if (hasColorImages) {
                                            // Show ONLY images for this color, hide all others (including generic)
                                            show = (group === colorId);
                                        } else {
                                            // No specific images for this color: show only generic images
                                            show = (group === 0);
                                        }

                                        thumb.style.display = show ? 'block' : 'none';
                                        if (show && !firstVisible) firstVisible = thumb;
                                    });

                                    // 4. Auto-click first visible thumbnail to update main image
                                    if (firstVisible) {
                                        firstVisible.click();
                                    }
                                }

                                function selectVariation(element) {
                                    // UI styling — highlight within same group
                                    let group = element.closest('.variation-group');
                                    group.querySelectorAll('.variation-btn').forEach(el => {
                                        el.classList.remove('btn-dark', 'text-white');
                                        el.classList.add('btn-outline-secondary');
                                    });
                                    element.classList.remove('btn-outline-secondary');
                                    element.classList.add('btn-dark', 'text-white');

                                    // Try to find a combination price
                                    var combo = lookupCombinationPrice();
                                    if (combo) {
                                        var pv = parseFloat(combo.pv);
                                        if (isNaN(pv) || pv <= 0) pv = defaultPV;
                                        var pp = parseFloat(combo.pp);
                                        if (isNaN(pp) || pp <= 0) pp = defaultPP;
                                        currentVPrice = (pp > 0 && pp < pv) ? pp : pv;
                                        
                                        // Build readable variation name
                                        var names = [];
                                        var colorLabel = document.getElementById('selected-color-name');
                                        if (colorLabel && colorLabel.textContent !== 'Choisissez') {
                                            names.push("Couleur: " + colorLabel.textContent);
                                        }
                                        document.querySelectorAll('.variation-group').forEach(function(group) {
                                            if(!group.hasAttribute('data-group-id')) return; // skip color group
                                            var active = group.querySelector('.variation-btn.btn-dark');
                                            if (active) {
                                                var groupName = group.querySelector('h6').textContent.replace(' :', '').trim();
                                                names.push(groupName + ": " + active.textContent.trim());
                                            }
                                        });
                                        currentVName = names.join(', ');
                                        // Update Cart function calls
                                        updatePriceDisplay(pv, pp);
                                    } else {
                                        // No combination found: use default product price
                                        currentVPrice = null;
                                        currentVName = null;
                                        updatePriceDisplay(defaultPV, defaultPP);
                                    }
                                }

                                function updatePriceDisplay(pVente, pPromo) {
                                    let priceHtml = '';
                                    if (pPromo > 0 && pPromo < pVente) {
                                        priceHtml = '<div class="fw-black text-primary mt-2" style="font-weight: 900; letter-spacing: -1px; color: var(--shop-primary) !important; font-size: 2.8rem; line-height:1.1;">' + pPromo.toFixed(3) + ' <span style="font-size:1.1rem; font-weight:700; color:#111; color:var(--shop-text-primary);">DT</span>&nbsp;<span style="font-size:1.1rem; font-weight:600; color:var(--shop-text-primary); opacity:0.65;">TTC</span> <span style="text-decoration:line-through;color:#aaa;font-size: 22px; font-weight:500;">' + pVente.toFixed(3) + ' DT</span></div>';
                                        let savings = (pVente - pPromo).toFixed(3);
                                        priceHtml += '<div style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 6px; padding: 5px 12px; font-size: 0.9rem; font-weight: bold; margin-top: 5px; display: inline-block;"><i class="fa fa-tag me-1"></i> Économisez ' + savings + ' DT !</div>';
                                    } else {
                                        priceHtml = '<div class="fw-black text-primary mt-2" style="font-weight: 900; letter-spacing: -1px; color: var(--shop-primary) !important; font-size: 2.8rem; line-height:1.1;">' + pVente.toFixed(3) + ' <span style="font-size:1.1rem; font-weight:700; color:var(--shop-text-primary);">DT</span>&nbsp;<span style="font-size:1.1rem; font-weight:600; color:var(--shop-text-primary); opacity:0.65;">TTC</span></div>';
                                    }
                                    
                                    document.querySelectorAll('.price-display').forEach(el => el.innerHTML = priceHtml);
                                }

                                // Initialize default selections on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    setTimeout(function() {
                                        // Auto-select first color
                                        let firstColor = document.querySelector('.color-swatch');
                                        if (firstColor) firstColor.click();

                                        // Auto-select first option in each variation group
                                        document.querySelectorAll('.variation-group').forEach(function(group) {
                                            let firstBtn = group.querySelector('.variation-btn');
                                            if (firstBtn) firstBtn.click();
                                        });
                                    }, 100);
                                });

                                </script>
                                <!-- END VARIATIONS UI -->
                            </div>
                            <div class="short_overview my-3">
                                <?php echo courtContenuProduits($id); ?>
                            </div>
                            <?php if(rqProduits($id)){ ?>
                                <div class="remarque bg-warning-subtle text-amber-800 p-3 rounded-2xl mb-4 border border-amber-200" style="font-size:0.9rem;font-weight:600">
                                    <i class="fa fa-info-circle me-2"></i> <?php echo rqProduits($id); ?>
                                </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>...
                
                
                
                
                <!--------------------------------------------------- sidebar ---------------------------------------------------------------->
                    
                    <div class="col-12 col-lg-3 mb-4">
                        <div class="sticky-top pt-2">
                            <div class="single_product_desc shadow-sm border px-3 py-4 rounded-3xl text-center" style="background: var(--shop-surface);">
    	                        
                                <div class="product-meta-data mb-4">
                                    <div class="price-display">
                                        <div class="fw-black text-primary mt-2" style="font-weight: 900; letter-spacing: -1px; color: var(--shop-primary) !important; font-size: 2.8rem; line-height:1.1;">
                                            <?php if($PrixPromo != '0.000') { 
                                                echo $PrixPromo.' <span style="font-size:1.1rem; font-weight:700; color:var(--shop-text-primary);">DT</span>&nbsp;<span style="font-size:1.1rem; font-weight:600; color:var(--shop-text-primary); opacity:0.65;">TTC</span> <span style="text-decoration:line-through;color:#aaa;font-size:22px;font-weight:500;">'.$PrixVente.' DT</span>';
                                                $economie = number_format($PrixVente - $PrixPromo, 3, '.', '');
                                                echo '<div class="economisez-tag shadow-sm d-block mt-2"><i class="fa fa-tag me-1"></i> Économisez '.$economie.' DT !</div>';
                                            } else { 
                                                echo $PrixVente.' <span style="font-size:1.1rem; font-weight:700; color:var(--shop-text-primary);">DT</span>&nbsp;<span style="font-size:1.1rem; font-weight:600; color:var(--shop-text-primary); opacity:0.65;">TTC</span>'; 
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                    
                                <!-- Add to Cart Form -->
                                <form class="cart clearfix d-flex flex-column align-items-center" method="post">
                                    <div class="cart-btn d-flex mx-auto mb-4 align-items-center border border-2 border-primary rounded-pill px-2 py-1 shadow-sm" style="border-color: var(--shop-primary) !important; background: var(--shop-surface);">
                                        <div class="quantity d-flex align-items-center">
                                            <span class="qty-minus text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="cursor:pointer; width:35px; height:35px; background:var(--shop-bg-alt); font-size:1.5rem; line-height:1;" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) && qty > 1 ) effect.value--;return false;">−</span>
                                            <input type="number" class="qty-text border-0 bg-transparent text-center fw-bold fs-5 mx-2" style="width:50px; outline:none; color:var(--shop-text-primary);" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                            <span class="qty-plus text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="cursor:pointer; width:35px; height:35px; background:var(--shop-bg-alt); font-size:1.5rem; line-height:1;" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;">+</span>
                                        </div>
                                    </div>
                                    <script>
                                    function handleAddCart(id) {
                                        let qty = document.getElementById('qty') ? document.getElementById('qty').value : 1;
                                        addToCart(id, qty, currentVPrice, currentVName);
                                    }
                                    </script>

    								<?php if ($etatStock == '1'){  ?>
                                    <button type="button" name="addtocart" value="5" class="btn-primary-tw w-100 border-0 shadow-none text-uppercase py-3 fs-6" style="border-radius:1rem" onclick="handleAddCart(<?php echo $id; ?>);"><i class="fa fa-shopping-bag me-2"></i> ACHETER</button>
                                    <?php }else{?>
    								<button type="button" name="addtocart" value="5" class="btn-secondary-tw w-100 border-0 text-uppercase py-3 fs-6" style="border-radius:1rem" onclick="handleAddCart(<?php echo $id; ?>);" disabled><i class="fa fa-shopping-bag me-2"></i> ACHETER</button>
    								<?php } ?>
    								</form>
                                <div style="display:flex; justify-content:flex-end; align-items:center; margin-top:12px; width:100%; min-height:40px;">
                                    <div style="position:relative; display:inline-flex; align-items:center;">
                                        <?php
                                        $shareUrl   = urlencode(lienAccueil().''.lienProduits($link));
                                        $shareTitle  = urlencode($titre);
                                        $shareDesc   = urlencode(strip_tags(courtContenuProduits($id ?? '')));
                                        $shareImg    = urlencode($chemin_absolu.'media/products/'.$photo);

                                        /* Facebook */
                                        $fbLink = 'https://www.facebook.com/dialog/feed?app_id=966242223397117&display=popup&link='.$shareUrl.'&name='.$shareTitle.'&description='.$shareDesc.'&picture='.$shareImg.'&redirect_uri='.$shareUrl;
                                        /* WhatsApp */
                                        $waLink = 'https://api.whatsapp.com/send?text='.$shareTitle.'%0A'.$shareImg.'%0A'.$shareUrl;
                                        /* Instagram */
                                        $igLink = 'https://www.instagram.com/';
                                        ?>
                                        <!-- Popup icons -->
                                        <div id="shareNetworksList" style="
                                            display:flex; align-items:center; gap:8px;
                                            position:absolute; right:100%; top:50%; transform:translate(10px,-50%);
                                            margin-right:8px; opacity:0; pointer-events:none;
                                            transition: opacity 0.3s ease, transform 0.3s ease;
                                            background:var(--shop-surface); padding:7px 12px;
                                            border-radius:30px; box-shadow:0 4px 20px rgba(0,0,0,0.15);
                                            border:1px solid var(--shop-border); white-space:nowrap; z-index:200;">

                                            <a href="<?php echo $fbLink; ?>" target="_blank" title="Facebook" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:#1877F2;flex-shrink:0;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            </a>
                                            <a href="<?php echo $waLink; ?>" target="_blank" title="WhatsApp" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:#25D366;flex-shrink:0;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            </a>
                                            <a href="<?php echo $igLink; ?>" target="_blank" title="Instagram" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);flex-shrink:0;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                            </a>

                                            <?php
                                            /* Réseaux BDD */
                                            $reqShare = executeRequete("SELECT * FROM `social_network` WHERE `etat`='1' ORDER BY `ordre` ASC");
                                            while ($sn = mysqli_fetch_array($reqShare)) {
                                                $tt = strtolower(trim(afficheChamp($sn['titre'])));
                                                if (in_array($tt, ['facebook', 'whatsapp', 'instagram', 'youtube'])) continue;

                                                $sLink = '#';
                                                if (stripos($tt, 'telegram') !== false) {
                                                    $sLink = 'https://t.me/share/url?url='.$shareUrl.'&text='.$shareTitle;
                                                } elseif (stripos($tt, 'twitter') !== false || stripos($tt, 'x.com') !== false) {
                                                    $sLink = 'https://twitter.com/intent/tweet?url='.$shareUrl.'&text='.$shareTitle;
                                                } elseif (stripos($tt, 'linkedin') !== false) {
                                                    $sLink = 'https://www.linkedin.com/sharing/share-offsite/?url='.$shareUrl;
                                                } else {
                                                    $sLink = afficheChamp($sn['lien']);
                                                }

                                                $icStyle = 'display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:var(--shop-bg-alt);border:1px solid var(--shop-border);transition:transform 0.2s;';
                                                
                                                if ($sn['type'] == '1') {
                                                    $iconClass = trim(afficheChamp($sn['icone']));
                                                    $iconClass = str_replace('fa-brands', 'fa', $iconClass);
                                                    echo '<a href="'.$sLink.'" target="_blank" title="'.htmlspecialchars(afficheChamp($sn['titre'])).'" style="'.$icStyle.'" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'">'
                                                       . '<i class="'.$iconClass.' fa-lg" style="color:var(--shop-primary);"></i>'
                                                       . '</a>';
                                                } else {
                                                    $imgNetwork = photoSocialNetworkSite($sn['id']);
                                                    echo '<a href="'.$sLink.'" target="_blank" title="'.htmlspecialchars(afficheChamp($sn['titre'])).'" style="'.$icStyle.'" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'">'
                                                       . '<img src="'.$imgNetwork.'" style="width:18px;height:18px;object-fit:contain;" alt="">'
                                                       . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>

                                        <!-- Bouton Share -->
                                        <button type="button" id="shareBtn"
                                            style="border-radius:30px; padding:7px 18px; background:var(--shop-bg-alt); color:var(--shop-text-primary); border:1px solid var(--shop-border); font-weight:600; box-shadow:0 2px 6px rgba(0,0,0,0.08); cursor:pointer; display:inline-flex; align-items:center; gap:7px; font-size:0.85rem; transition:box-shadow 0.2s;"
                                            onmouseover="this.style.boxShadow='0 4px 14px rgba(0,0,0,0.14)'" onmouseout="this.style.boxShadow='0 2px 6px rgba(0,0,0,0.08)'"
                                            onclick="toggleShareList(event)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                            Share
                                        </button>
                                    </div>
                                </div>
                                <script>
                                function toggleShareList(e) {
                                    e.stopPropagation();
                                    var list = document.getElementById('shareNetworksList');
                                    var open = (list.style.opacity === '1');
                                    if (open) {
                                        list.style.opacity = '0';
                                        list.style.transform = 'translate(10px,-50%)';
                                        list.style.pointerEvents = 'none';
                                    } else {
                                        list.style.opacity = '1';
                                        list.style.transform = 'translate(0,-50%)';
                                        list.style.pointerEvents = 'auto';
                                    }
                                }
                                document.addEventListener('click', function(){
                                    var list = document.getElementById('shareNetworksList');
                                    if (list) {
                                        list.style.opacity = '0';
                                        list.style.transform = 'translate(10px,-50%)';
                                        list.style.pointerEvents = 'none';
                                    }
                                });
                                </script>
                            
                            
                            <?php 
                                // Fetch dynamic warranty badges for this product
                                $q_badges = executeRequete("SELECT * FROM `produits_badges` WHERE `id_produit`='$id' ORDER BY `id` ASC");
                                if (mysqli_num_rows($q_badges) > 0) {
                                    while($b_row = mysqli_fetch_array($q_badges)){
                                        if (trim($b_row['texte']) == '') continue;
                            ?>
                            <div class="p-3 mt-3 rounded-2xl shadow-sm border d-flex align-items-center" style="font-size:0.85rem; font-weight:600; color:var(--shop-text-primary); background:var(--shop-surface);">
                                <div class="rounded-circle d-flex justify-content-center align-items-center me-4" style="width:40px; min-width:40px; height:40px; background:var(--shop-bg-alt); color:var(--shop-primary);">
                                    <i class="<?php echo afficheChamp($b_row['icone']); ?> fa-lg"></i>
                                </div>
                                <span class="lh-sm"><?php echo afficheChamp($b_row['texte']); ?></span>
                            </div>    
                            <?php
                                    }
                                } else {
                                    // Fallback to default badges if none defined for this product
                                    $defaults = [
                                        ['ico' => 'fa-solid fa-rotate-left', 'txt' => 'Satisfait ou remboursé 30 jours'],
                                        ['ico' => 'fa-solid fa-truck-fast', 'txt' => 'Livraison suivie et sécurisée'],
                                        ['ico' => 'fa-solid fa-headset', 'txt' => 'Support client réactif 7j/7']
                                    ];
                                    foreach ($defaults as $dbadge) {
                            ?>
                            <div class="p-3 mt-3 rounded-2xl shadow-sm border d-flex align-items-center" style="font-size:0.85rem; font-weight:600; color:var(--shop-text-primary); background:var(--shop-surface);">
                                <div class="rounded-circle d-flex justify-content-center align-items-center me-4" style="width:40px; min-width:40px; height:40px; background:var(--shop-bg-alt); color:var(--shop-primary);">
                                    <i class="<?php echo $dbadge['ico']; ?> fa-lg"></i>
                                </div>
                                <span class="lh-sm"><?php echo $dbadge['txt']; ?></span>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                            
                            <?php if ($etatStock == '1'){  ?>
                            <div class="cart-summary m-0 mt-3 p-4 border rounded-3xl shadow-sm" style="background: var(--shop-surface);">
                                <!-- Commande Express Toggle -->
                                <button class="btn-primary-tw w-100 d-flex justify-content-between align-items-center fw-bold btn-express-toggle collapsed" type="button" onclick="$('#collapseExpress').slideToggle(); $(this).find('.toggle-icon').toggleClass('fa-chevron-down fa-chevron-up');" style="font-size:0.75rem !important; padding:0.6rem 0.75rem !important; white-space: nowrap;">
                                    <span class="text-truncate"><i class="fa fa-bolt text-warning me-1"></i> Commande Express Rapide</span>
                                    <i class="fa fa-chevron-down toggle-icon ms-1"></i>
                                </button>

                                <div class="mt-3 text-start" id="collapseExpress" style="display:none;">
                                    <hr class="mb-4">
                                    <form class="cart" id="commandeExpressForm" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label class="fw-semibold text-secondary small">Nom <span class="text-danger">*</span></label>
                                            <input type="text" name="nom" class="form-control form-control-tw" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label class="fw-semibold text-secondary small">Prénom <span class="text-danger">*</span></label>
                                            <input type="text" name="prenom" class="form-control form-control-tw" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label class="fw-semibold text-secondary small">Téléphone <span class="text-danger">*</span></label>
                                            <input type="text" name="tel" class="form-control form-control-tw" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label class="fw-semibold text-secondary small">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control form-control-tw" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 fw-semibold text-secondary small">Plateforme :</label>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <div class="custom-control custom-radio mr-2">
                                                <input type="radio" name="platform" value="whatsapp" id="platform_whatsapp" class="custom-control-input" required>
                                                <label class="custom-control-label d-flex align-items-center" for="platform_whatsapp"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width:20px;height:20px;margin-right:8px;"> WhatsApp</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-2">
                                                <input type="radio" name="platform" value="messenger" id="platform_messenger" class="custom-control-input">
                                                <label class="custom-control-label d-flex align-items-center" for="platform_messenger"><img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg" alt="Messenger" style="width:20px;height:20px;margin-right:8px;"> Messenger</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="platform" value="telegram" id="platform_telegram" class="custom-control-input">
                                                <label class="custom-control-label d-flex align-items-center" for="platform_telegram"><img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" style="width:20px;height:20px;margin-right:8px;"> Telegram</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check mb-3 text-start mt-2" style="color:#000; font-size: 13px;">
                                            <input type="checkbox" class="form-check-input" id="cgv" required> J'accepte les <a href="#politique" data-toggle="modal" class="politique">Conditions Générales de Ventes</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="payment-method">
<style>
.payment-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
.pay-card { border: 2px solid var(--shop-border, #e5e7eb); border-radius: 0.75rem; padding: 0.75rem 0.5rem; text-align: center; cursor: pointer; background: var(--shop-surface, #fff); transition: all 0.2s ease; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.pay-card:hover { border-color: var(--shop-primary, #6366f1); }
.pay-card.selected { border-color: var(--shop-primary, #6366f1); background: color-mix(in srgb, var(--shop-primary) 5%, transparent); }
.pay-card img { max-height: 36px; max-width: 100%; object-fit: contain; margin-bottom: 0.5rem; }
.pay-card span { display: block; font-size: 0.75rem; font-weight: 600; color: var(--shop-text-primary, #374151); line-height: 1.2; word-wrap: break-word; }
@media(max-width: 400px) { .payment-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
<div class="payment-grid">
<?php
if(typeProduits($id)=="A") {
    $requetepay = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1" AND id <>"9"';
} else {
    $requetepay = 'SELECT * FROM `moyens_paiement` WHERE `etat` = "1" AND `type` ="1"';
}
$respay = executeRequete($requetepay);
$first = true;
while($datapay = mysqli_fetch_array($respay)){
    $logo_url = url_paiement($datapay['id']);
    $img_src = ($logo_url != '' && strpos($logo_url, 'http') !== 0) ? $chemin_absolu.'media/paiement/'.$logo_url : $logo_url;
?>
    <label class="pay-card <?php echo $first ? 'selected' : ''; ?>" for="pay_<?php echo $datapay['id']; ?>">
        <input 
            type="radio" 
            name="paymentMethod" 
            id="pay_<?php echo $datapay['id']; ?>"
            value="<?php echo $datapay['id']; ?>" 
            style="display:none;"
            onclick="document.querySelectorAll('.pay-card').forEach(n=>n.classList.remove('selected')); this.parentElement.classList.add('selected');"
            <?php if ($first) { echo 'checked required'; $first = false; } ?>
        >
        <?php if($img_src != ""): ?>
            <img src="<?php echo htmlspecialchars($img_src); ?>" alt="<?php echo htmlspecialchars(moyen_paiement($datapay['id'])); ?>" onerror="this.style.display='none'">
        <?php endif; ?>
        <span><?php echo moyen_paiement($datapay['id']); ?></span>
    </label>
<?php } ?>
</div>
                                    </div>

                                    <?php if (!empty($cloudflare_site_key)): ?>
                                        <div class="cf-turnstile mb-3 mt-3" data-sitekey="<?php echo $cloudflare_site_key; ?>"></div>
                                    <?php endif; ?>

                                    <hr class="my-4">
                                    <div class="form-group mb-0 mt-2">
                                        <button type="submit" name="" class="btn-primary-tw w-100 border-0">Confirmer</button>
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
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>

            <?php if($contenu != '' || $video != ''): ?>
            <!-- ═══ DÉTAILS DU PRODUIT — Full-width below both columns ═══ -->
            <div class="row mt-5">
                <div class="col-12 px-4 px-lg-5" id="details-complets">
                    <?php if($contenu != ''): ?>
                        <h4 class="fw-bold mb-4 text-center" style="border-bottom:2px solid var(--shop-border,#e5e7eb); padding-bottom:0.75rem;">Caractéristiques</h4>
                        <div class="product-long-content text-secondary lh-lg" style="font-size:0.95rem;">
                            <?php echo $contenu; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($video != ''): ?>
                        <h4 class="fw-bold mb-4 mt-5 text-center" style="border-bottom:2px solid var(--shop-border,#e5e7eb); padding-bottom:0.75rem;">Vidéo de présentation</h4>
                        <div class="ratio ratio-16x9 rounded-2xl overflow-hidden shadow-sm border mx-auto" style="max-width: 800px;">
                            <?php echo $video; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="modal fade" id="politique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: none; border-radius: 1.5rem; background: var(--shop-surface, #fff); box-shadow: 0 10px 40px rgba(0,0,0,0.1); overflow: hidden;">
            <div class="modal-header" style="border-bottom: 1px solid var(--shop-border, #e5e7eb); background: var(--shop-bg-alt, #f9fafb); padding: 1.5rem;">
                <h3 class="modal-title fw-bold" id="exampleModalLabel" style="color: var(--shop-text-primary, #111827); font-size: 1.25rem; margin: 0; display:flex; align-items:center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 24px; height: 24px; color: var(--shop-primary, #5a31f4);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <?php echo titrePage(26); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--shop-text-secondary, #6b7280); opacity: 1; text-shadow: none; background: transparent; border: none; font-size: 1.5rem; padding: 0.5rem; margin: -0.5rem -0.5rem -0.5rem auto; cursor: pointer; transition: color 0.2s;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body rich-content" style="padding: 2rem; max-height: 60vh; overflow-y: auto; color: var(--shop-text-secondary, #4b5563); font-size: 0.95rem; line-height: 1.7;">
                <?php echo contenuPage(26); ?>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--shop-border, #e5e7eb); padding: 1.25rem 1.5rem; background: var(--shop-bg-alt, #f9fafb); justify-content: flex-end;">
                <button type="button" class="btn-primary-tw" data-dismiss="modal" style="padding: 0.625rem 1.5rem; font-size: 0.875rem; border-radius: 0.75rem;">J'ai compris</button>
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
    
    // Cloudflare Turnstile Verification
    if (typeof turnstile !== 'undefined') {
        const response = turnstile.getResponse();
        if (!response) {
            alert('Veuillez valider la vérification anti-spam (Cloudflare Turnstile).');
            return;
        }
    }
    const now = new Date();
    const date = now.toLocaleDateString('fr-TN'); 
    const time = now.toLocaleTimeString('fr-TN', { hour: '2-digit', minute: '2-digit' }); 
    const nom = document.querySelector('input[name="nom"]').value;
    const prenom = document.querySelector('input[name="prenom"]').value;
    const tel = document.querySelector('input[name="tel"]').value;
    const Quantity = document.querySelector('input[name="qte_cmd"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const platform = document.querySelector('input[name="platform"]:checked').value;
    
    // Improved payment method selection
    const paymentRadio = document.querySelector('input[name="paymentMethod"]:checked');
    const payment = paymentRadio ? document.querySelector(`label[for="${paymentRadio.id}"] span`).textContent.trim() : 'Paiement à la livraison';
    
    const productTitle = '<?php echo addslashes($titre); ?>';
    const productPrice = '<?php if($PrixPromo != "0.000") { echo $PrixPromo; } else { echo $PrixVente; } ?>';
    const productUrl = window.location.href;
    
    const message = `
🌟 *Nouvelle Commande Express* 🌟

🛍️ *Produit:* _${productTitle}_ (Lien: ${productUrl} )
💵 *Prix:* _${productPrice} DT_
📦 *Quantité:* ${Quantity}

────────────────

👤 *Informations Client:*
👨‍💼 *Nom:* ${nom} ${prenom}
📞 *Téléphone:* ${tel}
📧 *Email:* ${email}
💳 *Paiement:* ${payment}

────────────────

✅ Merci de *confirmer* cette commande dès que possible.
🗓️ *Date de commande:* ${date}
⏰ *Heure:* ${time}
    `.trim();
    
    const encodedMessage = encodeURIComponent(message);
    let url;
    
    // Use user-provided addresses for Technoplus
    if (platform === 'whatsapp') {
        const waPhone = '<?php echo !empty($cmd_num_whatsapp) ? $cmd_num_whatsapp : "+33652984813"; ?>'.replace('+', '');
        url = `https://api.whatsapp.com/send/?phone=${waPhone}&text=${encodedMessage}`;
    } else if (platform === 'telegram') {
        url = `https://t.me/technoplusfr?text=${encodedMessage}`;
    } else if (platform === 'messenger') {
        // Updated messenger URL to use the provided ID
        const messengerId = '660733470452499';
        url = `https://www.messenger.com/t/${messengerId}/?text=${encodedMessage}`;
    }
    
    if (url) {
        window.open(url, '_blank');
    }
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

<script>
/* ── Star Rating JS ─────────────────────────────────────────── */
function highlightStars(prodId, val) {
    document.querySelectorAll('#stars-vote-' + prodId + ' .vote-star').forEach(function(s) {
        s.style.fill = parseInt(s.dataset.val) <= val ? '#F59E0B' : '#e5e7eb';
        s.style.transform = parseInt(s.dataset.val) <= val ? 'scale(1.15)' : '';
    });
}
function resetStars(prodId, currentVote) {
    document.querySelectorAll('#stars-vote-' + prodId + ' .vote-star').forEach(function(s) {
        s.style.fill = parseInt(s.dataset.val) <= currentVote ? '#F59E0B' : '#e5e7eb';
        s.style.transform = '';
    });
}
function rateProduct(prodId, note) {
    var fd = new FormData();
    fd.append('id_produit', prodId);
    fd.append('note', note);
    fetch('ajax/rate_produit.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(function(data) {
        if (data.success) {
            var userVote = data.user_vote;
            resetStars(prodId, userVote);
            
            // Update the displayed average and count
            var noteEl = document.getElementById('prod-note-' + prodId);
            if (noteEl) noteEl.textContent = parseFloat(data.note).toFixed(1);
            
            var nbEl = document.getElementById('nb-avis-' + prodId);
            if (nbEl) {
                nbEl.textContent = '(' + data.nb_avis + ' avis)';
                nbEl.style.display = 'inline';
            }
            
            // Update the display stars (the semi-filled ones above the average)
            for (var i = 1; i <= 5; i++) {
                var clipRect = document.querySelector('#sc-' + prodId + '-' + i + ' rect');
                if (clipRect) {
                    var fillPct = 0;
                    var noteVal = parseFloat(data.note);
                    if (noteVal >= i) fillPct = 100;
                    else if (noteVal > i - 1) fillPct = Math.round((noteVal - (i - 1)) * 100);
                    clipRect.setAttribute('width', fillPct + '%');
                }
            }
            
            var lbl = document.getElementById('vote-label-' + prodId);
            if (lbl) lbl.textContent = 'Votre note : ' + userVote + '/5 — Modifier :';

            // IMPORTANT: Update the onmouseout values for all stars to keep the new vote filled
            document.querySelectorAll('#stars-vote-' + prodId + ' .vote-star').forEach(function(s) {
                s.setAttribute('onmouseout', 'resetStars(' + prodId + ',' + userVote + ')');
            });

            // Success Toast
            Toastify({
                text: "⭐ Merci ! Votre avis a été enregistré.",
                duration: 3000,
                gravity: "bottom",
                position: "right",
                className: "toast-tw",
                style: {
                    background: "var(--shop-primary, #5A31F4)",
                    color: "#fff",
                    borderRadius: "0.75rem",
                    boxShadow: "0 10px 30px rgba(90,49,244,0.3)",
                    fontFamily: "Inter, sans-serif",
                    fontSize: "0.875rem",
                    fontWeight: "500",
                    padding: "1rem 1.25rem"
                }
            }).showToast();
        } else {
            if (data.error === 'non_connecte') {
                Toastify({
                    text: "🔒 Vous devez être connecté pour noter. Cliquez ici pour vous connecter.",
                    duration: 5000,
                    destination: "connexion.php",
                    newWindow: false,
                    close: true,
                    gravity: "bottom",
                    position: "right",
                    className: "toast-tw",
                    style: {
                        background: "#f59e0b",
                        color: "#fff",
                        borderRadius: "0.75rem",
                        boxShadow: "0 10px 30px rgba(245, 158, 11, 0.3)",
                        fontFamily: "Inter, sans-serif",
                        fontSize: "0.875rem",
                        fontWeight: "600",
                        padding: "1rem 1.25rem",
                        cursor: "pointer"
                    }
                }).showToast();
            } else {
                Toastify({
                    text: "❌ " + (data.message || "Une erreur est survenue."),
                    duration: 4000,
                    gravity: "bottom",
                    position: "right",
                    className: "toast-tw",
                    style: {
                        background: "#ef4444",
                        color: "#fff",
                        borderRadius: "0.75rem",
                        padding: "1rem 1.25rem"
                    }
                }).showToast();
            }
        }
    })
    .catch(function(err) { 
        console.error(err);
        Toastify({
            text: "⚠️ Erreur technique. Veuillez réessayer.",
            duration: 4000,
            gravity: "bottom",
            position: "right",
            style: { background: "#6b7280" }
        }).showToast();
    });
}
</script>

<!--------------------------------------------------- Facebook ---------------------------------------------------------------->
                
                <script>
                    if (typeof fbq !== 'undefined') {
                        fbq('track','ViewContent',{
                            content_type: 'product',
                            content_ids:['<?php echo $id;?>'],
                            content_name:'<?php echo $titre;?>',
                            value:'<?php echo $price;?>',
                            currency: 'TND'
                        });
                    }
                </script>                
                <?php
                /* ─── Similar Products ─── */
                /* ─── Similar Products ─── */
                $req_sim = 'SELECT DISTINCT id, link FROM produits 
                    WHERE categorie = "'.$id_categ.'" AND etat = "1" AND id != "'.$id.'"
                    ORDER BY id DESC LIMIT 12';
                $res_sim = executeRequete($req_sim);
                $sim_count = mysqli_num_rows($res_sim);
                if($sim_count > 0):
                ?>
                <div class="container-fluid pt-2 pb-5 overflow-hidden">
                    <h3 class="fw-bold mb-4" style="color:var(--shop-text-primary); letter-spacing:-0.02em;">Produits similaires</h3>
                    <div class="prod-similaire" style="padding-bottom:0.75rem; margin-left:-0.5rem; margin-right:-0.5rem;">
                    <?php while($sp = mysqli_fetch_array($res_sim)):
                        $sp_id   = $sp['id'];
                        $sp_link = $sp['link'];
                        $sp_pv   = prixVenteProduits($sp_id);
                        $sp_pp   = prixPromoProduits($sp_id);
                        $sp_disc = 0;
                        if($sp_pp && $sp_pp != '0.000' && floatval($sp_pv) > 0) {
                            $sp_disc = round(((floatval($sp_pv) - floatval($sp_pp)) / floatval($sp_pv)) * 100);
                        }
                        $sp_stock = (etatStockProduits($sp_id) == '1');
                    ?>
                    <div class="px-2 h-100">
                        <div class="sim-card" style="height:100%; background:var(--shop-surface,#fff); border:1px solid var(--shop-border,#e5e7eb); border-radius:1.25rem; overflow:hidden; display:flex; flex-direction:column; transition:transform 250ms ease, box-shadow 250ms ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                            <!-- Image -->
                            <a href="<?php echo lienProduits($sp_link); ?>" style="display:block; aspect-ratio:1/1; overflow:hidden; background:var(--shop-bg-alt,#f9fafb); position:relative;">
                                <img src="<?php echo photoProduitsSite($sp_id); ?>" alt="<?php echo htmlspecialchars(titreProduits($sp_id)); ?>" loading="lazy" style="width:100%; height:100%; object-fit:contain; transition:transform 300ms ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform=''">
                                <?php if($sp_disc > 0): ?>
                                <span style="position:absolute; top:0.6rem; left:0.6rem; background:var(--shop-accent,#ef4444); color:#fff; font-size:0.65rem; font-weight:800; padding:3px 8px; border-radius:99px;">-<?php echo $sp_disc; ?>%</span>
                                <?php endif; ?>
                            </a>
                            <!-- Body -->
                            <div style="padding:0.875rem; display:flex; flex-direction:column; gap:0.375rem; flex:1;">
                                <p style="font-size:0.8rem; font-weight:600; color:var(--shop-text-primary); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; margin:0; line-height:1.35;">
                                    <a href="<?php echo lienProduits($sp_link); ?>" style="color:inherit; text-decoration:none;"><?php echo titreProduits($sp_id); ?></a>
                                </p>
                                <div style="display:flex; align-items:baseline; gap:0.4rem; flex-wrap:wrap; margin-top:auto; padding-top:0.375rem;">
                                    <?php if($sp_pp && $sp_pp != '0.000'): ?>
                                        <span style="font-size:1rem; font-weight:800; color:var(--shop-primary,#5a31f4);"><?php echo $sp_pp; ?> DT</span>
                                        <span style="font-size:0.75rem; color:#9ca3af; text-decoration:line-through;"><?php echo $sp_pv; ?> DT</span>
                                    <?php else: ?>
                                        <span style="font-size:1rem; font-weight:800; color:var(--shop-primary,#5a31f4);"><?php echo $sp_pv; ?> DT</span>
                                    <?php endif; ?>
                                </div>
                                <div style="display:flex; gap:0.375rem; margin-top:0.5rem; align-items:center;">
                                    <button onclick="addToCart(<?php echo intval($sp_id); ?>,'1')" <?php echo (!$sp_stock ? 'disabled' : ''); ?> style="flex:1; padding:0.45rem 0.5rem; border:none; border-radius:0.625rem; background:var(--shop-primary,#5a31f4); color:#fff; font-size:0.72rem; font-weight:600; cursor:pointer; transition:background 200ms; <?php echo (!$sp_stock ? 'opacity:0.45;cursor:not-allowed;' : ''); ?>">
                                        <i class="fa fa-shopping-cart me-2"></i><?php echo ($sp_stock ? 'Panier' : 'Rupture'); ?>
                                    </button>
                                    <button class="prod-cmp-btn" data-compare-id="<?php echo intval($sp_id); ?>"
                                        onclick='compareToggle(<?php echo intval($sp_id); ?>, <?php echo htmlspecialchars(json_encode(titreProduits($sp_id)), ENT_QUOTES); ?>, <?php echo htmlspecialchars(json_encode(photoProduitsSite($sp_id)), ENT_QUOTES); ?>)'
                                        title="Comparer"
                                        style="flex-shrink:0; width:38px; height:38px; padding:0; border-radius:0.75rem; justify-content:center; display: flex; align-items: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 0-2-2V9m0 0h18"/></svg>
                                    </button>

                                    <a href="<?php echo lienProduits($sp_link); ?>" class="sim-card-eye">
                                        <i class="fa fa-eye" style="font-size:0.85rem; color: currentColor;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
	
	</div>
	
<style>
/* ── Slick Carousel Overrides ── */
.prod-similaire .slick-track { display: flex !important; }
.prod-similaire .slick-slide { height: inherit !important; display: flex !important; justify-content: center; }
.prod-similaire .slick-slide > div { width: 100%; display: flex; }
.prod-similaire .slick-arrow { 
    z-index: 10; width: 44px; height: 44px; background: var(--shop-surface, #fff) !important; 
    border-radius: 50%; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid var(--shop-border, #e5e7eb) !important;
    display: flex !important; align-items: center; justify-content: center; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
    color: var(--shop-text-primary, #111827) !important;
    font-size: 1rem !important;
}
.prod-similaire .slick-arrow:hover { 
    background: var(--shop-primary) !important; border-color: var(--shop-primary) !important; color: #fff !important;
    transform: scale(1.1);
}
.prod-similaire .slick-arrow svg, .prod-similaire .slick-arrow i {
    width: 1em; height: 1em;
}
.prod-similaire .slick-prev { left: -15px; }
.prod-similaire .slick-next { right: -15px; }

@media (max-width: 768px) {
    .prod-similaire .slick-prev { left: 5px; }
    .prod-similaire .slick-next { right: 5px; }
}

.sim-card-eye {
    width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
    background: var(--shop-surface, #fff) !important; border: 1.5px solid var(--shop-primary, #5A31F4) !important; border-radius: 0.75rem;
    color: var(--shop-primary, #5A31F4) !important; text-decoration: none; transition: all 300ms ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.sim-card-eye i, .sim-card-eye svg { color: var(--shop-primary, #5A31F4) !important; transition: color 300ms; width: 1.1em; height: 1.1em; }
.sim-card-eye:hover {
    background: var(--shop-primary, #5A31F4) !important; color: #fff !important; 
    transform: translateY(-2px); box-shadow: 0 5px 15px color-mix(in srgb, var(--shop-primary) 30%, transparent);
}
.sim-card-eye:hover i, .sim-card-eye:hover svg { color: #fff !important; }
html.dark .sim-card-eye, body.dark-mode .sim-card-eye {
    background: #1e293b !important; color: #fff !important; border-color: #475569 !important;
}
html.dark .sim-card-eye i, body.dark-mode .sim-card-eye svg, html.dark .sim-card-eye svg, body.dark-mode .sim-card-eye i {
    color: #cbd5e1 !important;
}
html.dark .sim-card-eye:hover, body.dark-mode .sim-card-eye:hover {
    background: var(--shop-primary) !important; border-color: var(--shop-primary) !important;
}
html.dark .sim-card-eye:hover i, body.dark-mode .sim-card-eye:hover svg, html.dark .sim-card-eye:hover svg, body.dark-mode .sim-card-eye:hover i {
    color: #fff !important;
}

/* ══ PREMIUM BUTTONS ══ */
.btn-primary-tw {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.625rem;
    text-align: center; color: white !important; font-weight: 700; 
    padding: 1rem 1.5rem; border-radius: 1rem; text-decoration: none;
    background: linear-gradient(135deg, var(--shop-primary) 0%, color-mix(in srgb, var(--shop-primary) 85%, #000) 100%);
    box-shadow: 0 4px 15px color-mix(in srgb, var(--shop-primary) 30%, transparent);
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; border: none;
}
.btn-primary-tw:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px color-mix(in srgb, var(--shop-primary) 45%, transparent);
    filter: brightness(1.11);
    color: white !important;
}
.btn-primary-tw:active { transform: translateY(-1px); }

.btn-secondary-tw {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.625rem;
    text-align: center; background: var(--shop-bg-alt, #f3f4f6); 
    color: var(--shop-text-primary, #1a1a2e); font-weight: 700;
    padding: 1rem 1.5rem; border-radius: 1rem; text-decoration: none;
    transition: all 250ms ease; border: 1px solid var(--shop-border, #e5e7eb);
}
.btn-secondary-tw:hover {
    background: color-mix(in srgb, var(--shop-bg-alt) 90%, #000);
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

/* Webkit scrollbar for thumbnails */
.thumbnails-wrapper::-webkit-scrollbar { height: 6px; }
.thumbnails-wrapper::-webkit-scrollbar-track { background: transparent; }
.thumbnails-wrapper::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

.active-thumb {
    border-color: var(--shop-primary) !important;
    opacity: 1 !important;
    transform: scale(1.05);
}

/* Mobile precise fixes */
@media (max-width: 991.98px) {
    .mobile-center-img { text-align: center !important; }
    .mobile-center-img .myImage { width: 85% !important; margin: 0 auto; display: block; }
}

.btn-express-toggle[aria-expanded="true"] .toggle-icon { transform: rotate(180deg); }
.toggle-icon { transition: transform 0.3s ease; }

.color-swatch:hover {
    transform: scale(1.15) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.variation-btn {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1.5px solid #e2e8f0 !important;
}

.variation-btn:hover {
    border-color: var(--shop-primary, #5A31F4) !important;
    background-color: var(--shop-bg-alt, #f9fafb);
    color: var(--shop-primary, #5A31F4) !important;
    transform: translateY(-1px);
}

.variation-btn.btn-dark {
    border-color: #0f172a !important;
    background-color: #0f172a !important;
}

.economisez-tag {
    background-color: #fef2f2; 
    color: #ef4444; 
    border: 1px solid #fecaca; 
    border-radius: 8px; 
    padding: 6px 14px; 
    font-size: 0.85rem; 
    font-weight: 800; 
    margin-top: 8px; 
    display: inline-block;
    animation: fadeInScale 0.4s ease-out;
}

@keyframes fadeInScale {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

/* ── Thumbnail buttons ── */
.thumb-btn {
    flex-shrink: 0;
    width: 72px;
    height: 72px;
    border-radius: 0.75rem;
    border: 2px solid var(--shop-border, #e5e7eb);
    overflow: hidden;
    background: var(--shop-surface, #fff);
    cursor: pointer;
    padding: 0;
    transition: border-color 200ms ease, transform 150ms ease;
}
.thumb-btn img { width: 100%; height: 100%; object-fit: contain; }
.thumb-btn:hover { border-color: var(--shop-primary, #5a31f4); transform: scale(1.04); }
.thumb-btn.active-thumb { border-color: var(--shop-primary, #5a31f4) !important; transform: scale(1.06); box-shadow: 0 0 0 3px color-mix(in srgb, var(--shop-primary,#5a31f4) 20%, transparent); }

/* ── Similar products scroller hide scrollbar ── */
.similar-scroller::-webkit-scrollbar { display: none; }

/* ── Thumbnail container scrollbar ── */
#thumbnail-container::-webkit-scrollbar { height: 4px; }
#thumbnail-container::-webkit-scrollbar-track { background: transparent; }
#thumbnail-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>