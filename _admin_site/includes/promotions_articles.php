<?php
// Actions (Stop Promo)
if(isset($_GET['action']) && $_GET['action'] == 'stop_promo' && isset($_GET['id'])) {
    $id_prod = intval($_GET['id']);
    executeRequete("UPDATE `produits` SET `prix_promo` = '0.000', `promo_end_date` = NULL, `is_flash` = '0' WHERE `id` = '$id_prod'");
    
    $chk = executeRequete("SHOW TABLES LIKE 'produit_variations'");
    if(mysqli_num_rows($chk) > 0) {
        executeRequete("UPDATE `produit_variations` SET `prix_promo` = '0.000' WHERE `idproduit` = '$id_prod'");
    }
    
    phpToastRedirect("Promotion arrêtée avec succès.", "index.php?r=promotions_articles", "success");
    exit();
}

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$per_page = 20;

$cond = " 1=1 ";
if(isset($_POST['search'])) {
    $s = mysqli_real_escape_string($connexion, $_POST['search']);
    if(!empty($s)) {
        $cond .= " AND `titre` LIKE '%$s%' ";
    }
}

$query_count = "SELECT COUNT(*) as nb FROM `produits` WHERE `prix_promo` > 0 AND (`promo_end_date` IS NULL OR `promo_end_date` > NOW()) AND $cond";
$res_count = executeRequete($query_count);
$row_count = mysqli_fetch_assoc($res_count);
$num_rows = $row_count['nb'];
$nbPage = ceil($num_rows / $per_page);

$req_list = "SELECT id, titre, photo, prix_vente, prix_promo, promo_end_date, is_flash, etat_stock 
             FROM `produits` 
             WHERE `prix_promo` > 0 AND (`promo_end_date` IS NULL OR `promo_end_date` > NOW()) AND $cond 
             ORDER BY id DESC LIMIT $start, $per_page";
$res_list = executeRequete($req_list);

// Load Tailwind WITHOUT Preflight (Prevents breaking the Admin Theme) 
// Plus support the Dark Mode class.
?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
      corePlugins: { preflight: false },
      darkMode: 'class'
    }
</script>
<style>
    /* Ensure modal always scrolls smoothly on small screens */
    .modal-scrollable-body { max-height: calc(90vh - 70px); overflow-y: auto; padding-bottom: 2rem; }
</style>

<div class="tw-wrap dark:bg-slate-900" style="width: 100%; padding: 20px; display: block; min-height: 80vh;">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h3 class="text-2xl font-bold tracking-tight" style="margin:0;font-size:1.5rem;color:inherit;">Promotions & Ventes Flash</h3>
            <p class="text-sm mt-1" style="margin:0;color:inherit;opacity:0.8;">Gérez vos réductions temporaires et durées d'offres.</p>
        </div>
        <button onclick="openPromoModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200" style="border:none; cursor:pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Nouvelle Promotion
        </button>
    </div>

    <!-- MAIN CARD -->
    <div class="rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" style="background:transparent;">
        
        <!-- TOOLBAR (Search) -->
        <div class="p-4 md:p-5 border-b border-gray-100 dark:border-slate-700" style="background:transparent;">
            <form id="searchPromoForm" method="post" action="index.php?r=promotions_articles" class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="search" name="search" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>" 
                       class="block w-full p-2.5 pl-10 text-sm border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm outline-none" 
                       style="background: transparent; color: inherit;"
                       placeholder="Rechercher silencieusement..." 
                       onkeyup="clearTimeout(window.searchTimeout); window.searchTimeout = setTimeout(() => { document.getElementById('searchPromoForm').submit(); }, 600);">
            </form>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" style="color:inherit;">
                <thead class="text-xs uppercase border-b dark:border-slate-700" style="background:rgba(0,0,0,0.05);">
                    <tr>
                        <th scope="col" class="px-6 py-4">Photo</th>
                        <th scope="col" class="px-6 py-4">Nom de l'article</th>
                        <th scope="col" class="px-6 py-4">Prix Vente</th>
                        <th scope="col" class="px-6 py-4 text-rose-600 dark:text-rose-400">Prix Promo</th>
                        <th scope="col" class="px-6 py-4 text-center">Fin de validité</th>
                        <th scope="col" class="px-6 py-4 text-center">Mode</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    <?php if($num_rows > 0): while($row = mysqli_fetch_assoc($res_list)): 
                        $pid = $row['id'];
                        $img = (!empty($row['photo'])) ? '../media/products/'.$row['photo'] : '../media/products/image_non_dispo.jpg';
                        $has_end = !empty($row['promo_end_date']);
                        $is_flash = ($row['is_flash'] == 1);
                    ?>
                    <tr class="transition-colors" style="background:transparent;" onmouseover="this.style.background='rgba(0,0,0,0.05)'" onmouseout="this.style.background='transparent'">
                        <td class="px-6 py-3">
                            <img src="<?php echo $img; ?>" class="w-10 h-10 object-cover rounded shadow-sm border border-gray-100 dark:border-slate-600" alt="img">
                        </td>
                        <td class="px-6 py-3 font-medium min-w-[200px]" style="color:inherit;">
                            <?php echo htmlspecialchars($row['titre']); ?>
                        </td>
                        <td class="px-6 py-3 line-through" style="opacity:0.6;">
                            <?php echo $row['prix_vente']; ?> DT
                        </td>
                        <td class="px-6 py-3 text-rose-600 dark:text-rose-400 font-bold text-base">
                            <?php echo $row['prix_promo']; ?> DT
                        </td>
                        <td class="px-6 py-3 text-center min-w-[120px]">
                            <?php if ($has_end): ?>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full admin-counter" data-end="<?php echo strtotime($row['promo_end_date']); ?>">
                                    Calcul...
                                </span>
                                <div class="text-[10px] mt-1.5" style="opacity:0.6;"><?php echo date('d/m/Y H:i', strtotime($row['promo_end_date'])); ?></div>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">Indéfini</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <?php if ($is_flash): ?>
                                <span class="bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-bold px-2.5 py-1 rounded border border-orange-200 dark:border-orange-800/50">🔥 Flash</span>
                            <?php else: ?>
                                <span class="text-gray-300 dark:text-gray-600 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="editPromoModal(<?php echo $pid; ?>)" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:hover:text-blue-300 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 p-2 rounded-lg transition-colors border border-blue-100 dark:border-blue-800/30" title="Modifier la durée ou les prix" style="border:1px solid transparent; cursor:pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <a href="index.php?r=promotions_articles&action=stop_promo&id=<?php echo $pid; ?>" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:hover:text-red-300 dark:bg-red-900/20 dark:hover:bg-red-900/40 p-2 rounded-lg transition-colors border border-red-100 dark:border-red-800/30 inline-flex items-center" onclick="return confirm('Arrêter la promotion instantanément pour ce produit et toutes ses déclinaisons ?');" title="Arrêter instantanément">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="7" class="text-center py-10" style="opacity:0.7;">Aucune promotion active actuellement.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($nbPage > 1): ?>
        <div class="p-4 border-t border-gray-100 dark:border-slate-700 flex justify-center">
            <nav aria-label="Page navigation" class="inline-flex -space-x-px text-sm">
                <?php for ($i = 1; $i <= $nbPage; $i++): 
                    $startPage = ($i - 1) * $per_page;
                    $is_active = ($startPage == $start);
                    if ($is_active) {
                        echo '<span class="flex items-center justify-center px-4 h-10 text-blue-600 border border-blue-300 bg-blue-50 dark:bg-blue-900/50 dark:border-blue-700 dark:text-blue-300" style="margin:2px; border-radius:4px;">'.$i.'</span>';
                    } else {
                        echo '<a href="index.php?r=promotions_articles&start='.$startPage.'" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-slate-800 dark:border-slate-600 dark:text-gray-400 dark:hover:bg-slate-700 dark:hover:text-white transition-colors" style="margin:2px; border-radius:4px; text-decoration:none;">'.$i.'</a>';
                    }
                endfor; ?>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- TAILWIND MODAL OVERLAY (With force fixed inline styles to avoid wrapper overflow clipping) -->
<div id="promoModal" class="tw-wrap hidden items-center justify-center bg-gray-900/70 backdrop-blur-md transition-opacity" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 999999;">
    <!-- Modal Box -->
    <div class="relative w-full max-w-3xl rounded-2xl shadow-2xl flex flex-col mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="promoModalBox" style="background:var(--shop-surface, #fff); color:inherit; border:1px solid rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b" style="border-color:rgba(0,0,0,0.1);">
            <h3 class="text-lg font-bold" style="margin:0;">Gestion de Promotion</h3>
            <button onclick="closePromoModal()" type="button" class="rounded-lg p-1.5 ml-auto inline-flex items-center transition-colors" style="border:none; cursor:pointer; background:transparent; color:inherit; opacity:0.6;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        
        <!-- Body (Scrollable container to prevent modal from crossing screen bounds) -->
        <div class="px-6 py-4 modal-scrollable-body custom-scrollbar">
            
            <!-- Step 1: Search -->
            <div id="promo-step-1">
                <p class="mb-4 text-sm font-medium" style="margin-top:0; opacity:0.8;">Recherchez le produit à mettre en promotion :</p>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5" style="opacity:0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="ajax-search-promo" class="block w-full p-4 pl-10 text-sm border rounded-xl focus:ring-blue-500 focus:border-blue-500 outline-none" style="background:rgba(0,0,0,0.02); border-color:rgba(0,0,0,0.1); color:inherit;" placeholder="Tapez 3 lettres minimum..." autocomplete="off" onkeyup="searchProduitPromo(this.value)">
                </div>
                <div id="promo-search-results" class="mt-2 w-full rounded-xl shadow-lg border max-h-64 overflow-y-auto hidden divide-y" style="background:var(--shop-surface, #fff); border-color:rgba(0,0,0,0.1);"></div>
            </div>

            <!-- Step 2: Config -->
            <div id="promo-step-2" class="hidden">
                <!-- Ajax content -->
            </div>

        </div>
    </div>
</div>

<script>
// ADMIN COUNTDOWN TICKER
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.admin-counter');
    setInterval(() => {
        const now = Math.floor(Date.now()/1000);
        counters.forEach(c => {
            const end = parseInt(c.getAttribute('data-end'));
            let rem = end - now;
            if(rem <= 0) {
                c.innerHTML = "Terminé / Expiré";
                c.classList.replace('text-blue-800', 'text-red-800');
                c.classList.replace('bg-blue-100', 'bg-red-100');
                // Dark mode variant changes
                c.classList.remove('dark:bg-blue-900/30', 'dark:text-blue-400');
                c.classList.add('dark:bg-red-900/30', 'dark:text-red-400');
            } else {
                let d = Math.floor(rem / 86400); rem %= 86400;
                let h = Math.floor(rem / 3600); rem %= 3600;
                let m = Math.floor(rem / 60);
                c.innerHTML = (d>0 ? d+"j " : "") + h+"h " + m+"m";
            }
        });
    }, 1000);
});

// Appends Modal to highest DOM level instantly, bypassing any CSS transform traps
document.addEventListener('DOMContentLoaded', () => {
    const m = document.getElementById('promoModal');
    if(m) document.body.appendChild(m);
});

function openPromoModal() {
    const modal = document.getElementById('promoModal');
    const box = document.getElementById('promoModalBox');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.style.display = 'flex'; // Forzage Inline au cas où Tailwind bug
    setTimeout(() => { box.classList.replace('scale-95', 'scale-100'); }, 10);
    
    document.getElementById('promo-step-1').classList.remove('hidden');
    document.getElementById('promo-step-2').classList.add('hidden');
    document.getElementById('ajax-search-promo').value = '';
    document.getElementById('promo-search-results').classList.add('hidden');
    document.getElementById('ajax-search-promo').focus();
}

function closePromoModal() {
    const modal = document.getElementById('promoModal');
    const box = document.getElementById('promoModalBox');
    box.classList.replace('scale-100', 'scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.style.display = 'none';
    }, 200);
}

function searchProduitPromo(val) {
    const resDiv = document.getElementById('promo-search-results');
    if(val.length < 3) { resDiv.classList.add('hidden'); return; }
    
    fetch('ajax/ajax_promo.php?action=search&q='+encodeURIComponent(val))
    .then(r => r.text())
    .then(html => {
        resDiv.innerHTML = html;
        resDiv.classList.remove('hidden');
    });
}

function selectProduitPromo(id) {
    document.getElementById('promo-step-1').classList.add('hidden');
    const step2 = document.getElementById('promo-step-2');
    step2.classList.remove('hidden');
    step2.innerHTML = '<div class="flex flex-col items-center justify-center py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-4"></div><p class="text-gray-500 dark:text-gray-400">Chargement des tarifs et durées...</p></div>';
    
    fetch('ajax/ajax_promo.php?action=load_config&id='+id)
    .then(r => r.text())
    .then(html => { step2.innerHTML = html; });
}

// DIRECT EDIT 
function editPromoModal(id) {
    const modal = document.getElementById('promoModal');
    const box = document.getElementById('promoModalBox');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.style.display = 'flex'; // Fix
    setTimeout(() => { box.classList.replace('scale-95', 'scale-100'); }, 10);
    
    document.getElementById('promo-step-1').classList.add('hidden');
    const step2 = document.getElementById('promo-step-2');
    step2.classList.remove('hidden');
    step2.innerHTML = '<div class="flex flex-col items-center justify-center py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-4"></div><p class="text-gray-500 dark:text-gray-400">Chargement des données existantes...</p></div>';
    
    fetch('ajax/ajax_promo.php?action=load_config&id='+id)
    .then(r => r.text())
    .then(html => { step2.innerHTML = html; });
}

function submitPromoForm(e, form) {
    e.preventDefault();
    const data = new FormData(form);
    
    let btn = form.querySelector('button[type="submit"]');
    let otxt = btn.innerHTML;
    btn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline pb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Enregistrement...';
    btn.disabled = true;

    fetch('ajax/ajax_promo.php?action=save', { method: 'POST', body: data })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            closePromoModal();
            window.location.reload();
        } else {
            alert('Erreur: ' + data.error);
            btn.innerHTML = otxt; btn.disabled = false;
        }
    })
    .catch(err => {
        alert('Erreur réseau');
        btn.innerHTML = otxt; btn.disabled = false;
    });
}
</script>
