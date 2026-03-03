<?php 

session_start();
include("../include.php");

if(isset($_POST["action"])){

    $type_filter  = $_POST["type"];
    $qty          = "1";
    $output       = '';
    $per_page     = 12;
    $current_page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;

    $inreq = isset($_POST["caracteristique"]) ? ' , `caracteristique_prod` cp ' : '';

    /* ── Base query ── */
    $query = "SELECT DISTINCT pr.id, pr.link, pr.categorie FROM produits pr, categories_blog ctg ".$inreq." WHERE pr.etat = '1'";

    if(isset($_POST["link"]) && $_POST["link"] != ''){
        $query .= " AND pr.categorie ='".$_POST["link"]."'";
    }
    if(isset($_POST["brand"])){
        $query .= " AND pr.marque IN('".implode("','", $_POST["brand"])."')";
    }
    if(isset($_POST["category"])){
        $query .= " AND pr.categorie IN('".implode("','", $_POST["category"])."')";
    }
    if(isset($_POST["caracteristique"])){
        $query .= " AND ";
        foreach($_POST["caracteristique"] as $c){
            $query .= " ( cp.idproduit = pr.id AND cp.valeur='".idvaleurCaracteristiques($c)."' AND cp.idcarac = '".idcaracCaracteristiques($c)."') OR";
        }
        $query = rtrim($query,'OR');
    }
    if(isset($_POST["search"]) && $_POST["search"] != ''){
        $s = str_replace(" "," ",$_POST["search"]);
        $query .= " AND ( pr.titre LIKE '%$s%' OR pr.link LIKE '%$s%' )";
    }
    if(isset($_POST["marque"]) && $_POST["marque"] != ''){
        $query .= " AND ( pr.marque LIKE '%".idraisonMarque($_POST["marque"])."%' )";
    }
    if(isset($_POST["categoryByTitre"]) && $_POST["categoryByTitre"] != ''){
        $ctg = $_POST["categoryByTitre"];
        $id  = idBySearchCategBlog($ctg);
        $query .= " AND ( pr.categorie IN (SELECT id FROM categories_blog WHERE idparent='$id' || id='$id') OR pr.idparent_categ IN (SELECT id FROM categories_blog WHERE idparent='$id' || id='$id') )";
    }
    if(isset($_POST["promo"]) && $_POST["promo"] != ''){
        $query .= " AND pr.prix_promo !='0.000'";
        if(isset($_POST["minimum_price"],$_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])){
            $query .= " AND pr.prix_promo BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'";
        }
        $query .= " GROUP BY pr.categorie ORDER BY pr.prix_promo ASC";
    }else{
        if(isset($_POST["minimum_price"],$_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])){
            $query .= " AND pr.prix_vente BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'";
        }
        $query .= " GROUP BY pr.id ORDER BY pr.prix_vente ASC";
    }

    /* ── Count without LIMIT ── */
    $total_row   = mysqli_num_rows(executeRequete($query));
    $total_pages = max(1, ceil($total_row / $per_page));
    if($current_page > $total_pages) $current_page = $total_pages;
    $offset      = ($current_page - 1) * $per_page;

    /* ── Paginated queries (need two separate result sets) ── */
    $q_paged   = $query . " LIMIT ".$per_page." OFFSET ".$offset;
    $res_grid  = executeRequete($q_paged);
    $res_list  = executeRequete($q_paged);

    /* ========================================================
       HELPERS
    ======================================================== */
    function renderGridCard($id_p, $link_p, $qty){
        $stock = (etatStockProduits($id_p) == '1');
        $o = '';
        $o .= '<div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4 grid-group-item">';
        $o .= '<div class="prod-card h-100">';

        /* Image */
        $o .= '<a href="'.lienProduits($link_p).'" class="prod-img-wrap">';
        $o .= '<img src="'.photoProduitsSite($id_p).'" alt="" loading="lazy">';
        $o .= '</a>';

        /* Body */
        $o .= '<div class="prod-body">';

        /* Brand logo */
        if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) != ''){
            $o .= '<div class="prod-brand"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" alt=""></div>';
        }

        /* Title */
        $o .= '<a href="'.lienProduits($link_p).'" class="prod-title">'.titreProduits($id_p).'</a>';

        /* Stock */
        $o .= $stock
            ? '<p class="prod-stock in-stock"><i class="fa fa-circle"></i> En Stock</p>'
            : '<p class="prod-stock out-stock"><i class="fa fa-circle"></i> En Rupture</p>';

        /* Price */
        if(prixPromoProduits($id_p) != '0.000'){
            $o .= '<div class="prod-price"><span class="price-main">'.prixPromoProduits($id_p).' DT</span><span class="price-old">'.prixVenteProduits($id_p).' DT</span></div>';
        }else{
            $o .= '<div class="prod-price"><span class="price-main">'.prixVenteProduits($id_p).' DT</span></div>';
        }

        /* Buttons */
        $o .= '<div class="prod-btns">';
        $o .= '<a href="'.lienProduits($link_p).'" class="btn-view"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/></svg> Détail</a>';
        if($stock){
            $o .= '<button type="button" onclick="addToCart(event,'.afficheChamp($id_p).','.$qty.')" class="btn-cart"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg> Panier</button>';
        }else{
            $o .= '<button disabled class="btn-cart btn-cart-disabled">Rupture</button>';
        }
        $o .= '</div>';
        $o .= '</div>'; // prod-body
        $o .= '</div>'; // prod-card
        $o .= '</div>'; // col
        return $o;
    }

    function renderListCard($id_p, $link_p, $qty){
        $stock = (etatStockProduits($id_p) == '1');
        $o  = '';
        $o .= '<div class="col-12 mb-3 list-item-wrap">';
        $o .= '<div class="prod-list-card">';
        /* Image */
        $o .= '<a href="'.lienProduits($link_p).'" class="list-img"><img src="'.photoProduitsSite($id_p).'" alt="" loading="lazy"></a>';
        /* Content */
        $o .= '<div class="list-body">';
        $o .= '<a href="'.lienProduits($link_p).'" class="list-title">'.titreProduits($id_p).'</a>';
        $o .= '<div class="list-desc">'.tronquer(strip_tags(courtContenuProduits($id_p)),200).'</div>';
        $o .= $stock
            ? '<p class="prod-stock in-stock"><i class="fa fa-circle"></i> En Stock</p>'
            : '<p class="prod-stock out-stock"><i class="fa fa-circle"></i> En Rupture</p>';
        $o .= '</div>';
        /* Right */
        $o .= '<div class="list-right">';
        if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) != ''){
            $o .= '<div class="list-brand"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" alt=""></div>';
        }
        if(prixPromoProduits($id_p) != '0.000'){
            $o .= '<div class="prod-price"><span class="price-main">'.prixPromoProduits($id_p).' DT</span><span class="price-old">'.prixVenteProduits($id_p).' DT</span></div>';
        }else{
            $o .= '<div class="prod-price"><span class="price-main">'.prixVenteProduits($id_p).' DT</span></div>';
        }
        $o .= '<a href="'.lienProduits($link_p).'" class="btn-view w-block"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/></svg> Voir détail</a>';
        if($stock){
            $o .= '<button type="button" onclick="addToCart(event,'.afficheChamp($id_p).','.$qty.')" class="btn-cart w-block"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg> Ajouter</button>';
        }else{
            $o .= '<button disabled class="btn-cart w-block btn-cart-disabled">Rupture de stock</button>';
        }
        $o .= '</div>';
        $o .= '</div>'; // prod-list-card
        $o .= '</div>'; // col
        return $o;
    }

    function renderPagination($cur, $total, $total_row){
        if($total <= 1) return '';
        $o = '<div class="cat-pagination">';
        if($cur > 1) $o .= '<button class="pag-btn" data-page="'.($cur-1).'">&#8592;</button>';
        for($p=1; $p<=$total; $p++){
            $active = ($p === $cur);
            if($p==1 || $p==$total || abs($p-$cur)<=2){
                $o .= '<button class="pag-btn'.($active?' pag-active':'').'" data-page="'.$p.'">'.$p.'</button>';
            }elseif(abs($p-$cur)==3){
                $o .= '<span class="pag-dots">…</span>';
            }
        }
        if($cur < $total) $o .= '<button class="pag-btn" data-page="'.($cur+1).'">&#8594;</button>';
        $o .= '</div>';
        $o .= '<p class="pag-info">Page '.$cur.' / '.$total.' &mdash; '.$total_row.' produits</p>';
        return $o;
    }

    /* ========================================================
       TOP BAR (count + grid/list toggle)
    ======================================================== */
    $output .= '<div class="cat-topbar">';
    $output .= '<span class="cat-count">'.$total_row.' produit'.($total_row>1?'s':'').'</span>';
    $output .= '<div class="view-toggle">';
    $output .= '<a href="javascript:void(0)" id="grid" class="vt-btn vt-active" title="Grille"><i class="fa fa-th-large"></i></a>';
    $output .= '<a href="javascript:void(0)" id="list" class="vt-btn" title="Liste"><i class="fa fa-bars"></i></a>';
    $output .= '</div>';
    $output .= '</div>';

    if($total_row > 0){

        /* ── GRID view ── */
        $output .= '<div class="cat-grid-view"><div class="row w-100 m-0">';
        while($row = mysqli_fetch_array($res_grid)){
            $output .= renderGridCard($row['id'], $row['link'], $qty);
        }
        $output .= '</div></div>';

        /* ── LIST view ── */
        $output .= '<div class="cat-list-view" style="display:none"><div class="row">';
        while($row2 = mysqli_fetch_array($res_list)){
            $output .= renderListCard($row2['id'], $row2['link'], $qty);
        }
        $output .= '</div></div>';

        /* ── Pagination ── */
        $output .= renderPagination($current_page, $total_pages, $total_row);

    }else{
        $output .= '<div class="text-center py-5" style="color:var(--shop-text-secondary,#6B6589);"><i class="fa fa-search fa-2x mb-3 d-block"></i><p>Aucun produit trouvé.</p></div>';
    }

    echo $output;

} // end if action
?>

<style>
/* ═══════════════════════════════════════════════
   CATEGORY PAGE — Product cards + controls
   Uses brand tokens: var(--shop-primary)
   ═══════════════════════════════════════════════ */

/* ── Top bar ── */
.cat-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--shop-border,#E0DEFF);
}
.cat-count { font-size: 0.875rem; color: var(--shop-text-secondary,#6B6589); font-weight: 500; }
.view-toggle { display: flex; gap: 0.375rem; }
.vt-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px;
    border-radius: 0.5rem;
    border: 1.5px solid var(--shop-border,#E0DEFF);
    color: var(--shop-text-secondary,#6B6589);
    background: var(--shop-surface,#fff);
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
}
.vt-btn:hover, .vt-active {
    border-color: var(--shop-primary,#5A31F4) !important;
    background: var(--shop-primary,#5A31F4) !important;
    color: #fff !important;
    text-decoration: none;
}

/* ── Prevent flicker ── */
.filter_data { min-height: 200px; }

/* ── GRID card ── */
.prod-card {
    background: var(--shop-surface,#fff);
    border: 1.5px solid var(--shop-border,#E0DEFF);
    border-radius: 1rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}
.prod-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(90,49,244,.15);
}
.prod-img-wrap {
    display: flex; align-items: center; justify-content: center;
    background: #f8f7ff;
    padding: 1rem;
    height: 170px;
    overflow: hidden;
    flex-shrink: 0;
}
.prod-img-wrap img { max-height: 140px; max-width: 100%; object-fit: contain; width: auto; }

.prod-body {
    padding: 0.75rem;
    display: flex; flex-direction: column;
    flex: 1;
}

.prod-brand {
    display: flex; align-items: center; justify-content: center;
    height: 36px; margin-bottom: 0.4rem;
}
.prod-brand img { max-height: 32px; max-width: 80px; object-fit: contain; }

.prod-title {
    font-size: 0.83rem; font-weight: 600;
    color: var(--shop-text-primary,#120B2E);
    text-decoration: none; line-height: 1.35;
    display: block; margin-bottom: 0.3rem;
    overflow: hidden;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
}
.prod-title:hover { color: var(--shop-primary,#5A31F4); }

.prod-stock { font-size: 0.73rem; font-weight: 500; margin: 0 0 0.3rem; }
.in-stock  { color: #10B981; }
.out-stock { color: #B0AABB; }

.prod-price { margin-bottom: 0.5rem; }
.price-main { font-size: 1rem; font-weight: 700; color: var(--shop-primary,#5A31F4); }
.price-old  { font-size: 0.78rem; color: #B0AABB; text-decoration: line-through; margin-left: 0.3rem; }

/* ── Buttons ── */
.prod-btns { display: flex; gap: 0.375rem; margin-top: auto; }
.btn-view {
    flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 0.25rem;
    padding: 0.4rem 0.4rem; border-radius: 0.45rem; font-size: 0.78rem; font-weight: 600;
    background: transparent; border: 1.5px solid var(--shop-primary,#5A31F4);
    color: var(--shop-primary,#5A31F4); text-decoration: none; transition: 0.15s;
    white-space: nowrap;
}
.btn-view:hover { background: var(--shop-primary,#5A31F4); color: #fff; text-decoration: none; }
.btn-view.w-block { display: flex; width: 100%; margin-bottom: 0.3rem; }
.btn-cart {
    flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 0.25rem;
    padding: 0.4rem 0.4rem; border-radius: 0.45rem; font-size: 0.78rem; font-weight: 600;
    background: var(--shop-primary,#5A31F4); border: none; color: #fff; cursor: pointer;
    transition: 0.15s; white-space: nowrap;
}
.btn-cart:hover { background: var(--shop-primary-hover,#4A24E8); }
.btn-cart.w-block { display: flex; width: 100%; margin-bottom: 0.3rem; }
.btn-cart-disabled { background: #e5e7eb !important; color: #9ca3af !important; cursor: not-allowed !important; }

/* ── LIST card ── */
.prod-list-card {
    display: flex; align-items: stretch;
    background: var(--shop-surface,#fff);
    border: 1.5px solid var(--shop-border,#E0DEFF);
    border-radius: 1rem; overflow: hidden;
}
.list-img {
    flex-shrink: 0; width: 150px;
    display: flex; align-items: center; justify-content: center;
    background: #f8f7ff; padding: 0.75rem;
}
.list-img img { max-height: 110px; max-width: 130px; object-fit: contain; }
.list-body {
    flex: 1; padding: 0.75rem; display: flex; flex-direction: column;
    justify-content: space-between; min-width: 0;
}
.list-title {
    font-size: 0.9rem; font-weight: 600; color: var(--shop-text-primary,#120B2E);
    text-decoration: none; margin-bottom: 0.3rem; display: block;
}
.list-title:hover { color: var(--shop-primary,#5A31F4); }
.list-desc { font-size: 0.78rem; color: var(--shop-text-secondary,#6B6589); line-height: 1.4; margin-bottom: 0.4rem; }
.list-right {
    flex-shrink: 0; width: 160px; padding: 0.75rem;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    border-left: 1px solid var(--shop-border,#E0DEFF); gap: 0.35rem; text-align: center;
}
.list-brand { height: 40px; display: flex; align-items: center; justify-content: center; }
.list-brand img { max-height: 36px; max-width: 110px; object-fit: contain; }

/* ── Pagination ── */
.cat-pagination {
    display: flex; align-items: center; justify-content: center;
    flex-wrap: wrap; gap: 0.35rem;
    margin: 1.5rem 0 0.5rem;
}
.pag-btn {
    min-width: 36px; height: 36px; padding: 0 0.5rem;
    border-radius: 0.5rem; border: 1.5px solid var(--shop-border,#E0DEFF);
    background: var(--shop-surface,#fff); color: var(--shop-text-secondary,#6B6589);
    cursor: pointer; font-size: 0.875rem; font-weight: 500;
    transition: 0.15s;
}
.pag-btn:hover { border-color: var(--shop-primary,#5A31F4); color: var(--shop-primary,#5A31F4); }
.pag-active {
    background: var(--shop-primary,#5A31F4) !important;
    border-color: var(--shop-primary,#5A31F4) !important;
    color: #fff !important; font-weight: 700;
}
.pag-dots { color: var(--shop-text-disabled,#B0AABB); line-height: 36px; }
.pag-info { text-align: center; font-size: 0.78rem; color: var(--shop-text-secondary,#6B6589); margin-bottom: 1rem; }

/* ── jQuery UI slider brand color ── */
.ui-slider { height: 5px !important; background: var(--shop-border,#E0DEFF) !important; border: none !important; border-radius: 3px !important; }
.ui-slider-range { background: var(--shop-primary,#5A31F4) !important; }
.ui-slider-handle {
    width: 16px !important; height: 16px !important; top: -6px !important;
    border-radius: 50% !important; background: var(--shop-primary,#5A31F4) !important;
    border: 2px solid #fff !important; box-shadow: 0 2px 6px rgba(90,49,244,.4) !important;
    cursor: pointer !important; margin-left: -8px !important;
}

/* ── Mobile ── */
@media (max-width: 992px) {
    .cat-grid-view { display: none !important; }
    .cat-list-view { display: block !important; }
    .list-img { width: 110px; }
    .list-right { width: 130px; }
    .view-toggle a#grid { display: none; }
}
@media (max-width: 576px) {
    .prod-list-card { flex-direction: column; }
    .list-img { width: 100%; height: 160px; }
    .list-right { width: 100%; border-left: none; border-top: 1px solid var(--shop-border,#E0DEFF); }
    .btn-view.w-block, .btn-cart.w-block { margin-bottom: 0.25rem; }
}
</style>

<script type="text/javascript">
/* IIFE — executes immediately after AJAX inject (no document.ready needed) */
(function(){
    /* ── View toggle ── */
    function setView(mode){
        if(mode === 'grid'){
            document.querySelectorAll('.cat-grid-view').forEach(function(el){ el.style.display='block'; });
            document.querySelectorAll('.cat-list-view').forEach(function(el){ el.style.display='none'; });
            var g = document.getElementById('grid'); var l = document.getElementById('list');
            if(g){ g.className='vt-btn vt-active'; }
            if(l){ l.className='vt-btn'; }
        }else{
            document.querySelectorAll('.cat-list-view').forEach(function(el){ el.style.display='block'; });
            document.querySelectorAll('.cat-grid-view').forEach(function(el){ el.style.display='none'; });
            var g = document.getElementById('grid'); var l = document.getElementById('list');
            if(g){ g.className='vt-btn'; }
            if(l){ l.className='vt-btn vt-active'; }
        }
    }

    /* Default view depends on screen size */
    function applyDefaultView(){
        if(window.innerWidth <= 992){
            /* Force list on mobile */
            document.querySelectorAll('.cat-grid-view').forEach(function(el){ el.style.display='none'; });
            document.querySelectorAll('.cat-list-view').forEach(function(el){ el.style.display='block'; });
        }else{
            /* Grid on desktop */
            document.querySelectorAll('.cat-grid-view').forEach(function(el){ el.style.display='block'; });
            document.querySelectorAll('.cat-list-view').forEach(function(el){ el.style.display='none'; });
        }
    }
    applyDefaultView();

    /* Delegates (works even after next AJAX reload) */
    document.addEventListener('click', function(e){
        var t = e.target.closest('#grid');
        if(t){ e.preventDefault(); setView('grid'); return; }
        t = e.target.closest('#list');
        if(t){ e.preventDefault(); setView('list'); return; }
        t = e.target.closest('.pag-btn');
        if(t){
            var page = parseInt(t.getAttribute('data-page'));
            if(typeof window.filter_data_page === 'function') window.filter_data_page(page);
        }
    });

    /* Tooltips */
    if(typeof jQuery !== 'undefined') jQuery('[data-toggle="tooltip"]').tooltip();

})();
</script>
