<?php
if (!isset($popup_already_checked)) {
    $popup_already_checked = true;
    
    // Determine if we are on the homepage
    $on_homepage = (function_exists('lienAccueil') && lienAccueil()) ? true : false;
    // Alternative check if lienAccueil is missing or doesn't work optimally
    if(isset($_SERVER['REQUEST_URI']) && ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || strpos($_SERVER['REQUEST_URI'], '/shop/') === 0 && strlen($_SERVER['REQUEST_URI']) <= 7)){
        $on_homepage = true; // Fallback
    }

    $popup_res = mysqli_query($connexion, "SELECT * FROM `site_popups` WHERE `etat` = 1 ORDER BY `id` DESC LIMIT 1");
    if ($popup_res && mysqli_num_rows($popup_res) > 0) {
        $popup = mysqli_fetch_assoc($popup_res);
        
        $show_popup = false;
        if ($popup['emplacement'] == 'toutes') {
            $show_popup = true;
        } else if ($popup['emplacement'] == 'accueil' && $on_homepage) {
            $show_popup = true;
        }
        
        if ($show_popup) {
            $p_id = $popup['id'];
            $p_link = !empty($popup['lien']) ? afficheChamp($popup['lien']) : '';
            $p_btn = !empty($popup['bouton_texte']) ? afficheChamp($popup['bouton_texte']) : '';
            
            $img_desktop = !empty($popup['image_desktop']) ? $chemin_absolu.'media/popups/'.$popup['image_desktop'] : '';
            $img_tablet = !empty($popup['image_tablet']) ? $chemin_absolu.'media/popups/'.$popup['image_tablet'] : $img_desktop;
            $img_mobile = !empty($popup['image_mobile']) ? $chemin_absolu.'media/popups/'.$popup['image_mobile'] : $img_desktop;

            if ($img_desktop) {
?>
<style>
/* CSS Spécifique au Popup */
.shop-popup-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.65);
    z-index: 99999;
    display: none; /* Masqué par défaut, affiché par JS si nécessaire */
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    opacity: 0;
    transition: opacity 0.4s ease;
}
.shop-popup-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    transform: scale(0.95);
    transition: transform 0.4s ease;
    background: #fff;
    display: flex;
    flex-direction: column;
}
.shop-popup-overlay.show {
    opacity: 1;
}
.shop-popup-overlay.show .shop-popup-content {
    transform: scale(1);
}
.shop-popup-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255,255,255,0.9);
    color: #111;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.shop-popup-close:hover {
    background: #fff;
    color: #dc2626;
}
.shop-popup-image-container {
    display: block;
    width: 100%;
    height: 100%;
    cursor: <?php echo $p_link ? 'pointer' : 'default'; ?>;
}
.shop-popup-image-container picture,
.shop-popup-image-container img {
    display: block;
    max-width: 100%;
    max-height: 80vh; /* Laisser de la place pour le bouton si présent */
    object-fit: contain;
}
.shop-popup-footer {
    padding: 15px;
    text-align: center;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}
.shop-popup-btn {
    display: inline-block;
    padding: 10px 24px;
    background: var(--shop-primary, #2563eb);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    border-radius: 8px;
    font-size: 16px;
    transition: opacity 0.2s;
}
.shop-popup-btn:hover {
    color: #fff;
    opacity: 0.9;
}
</style>

<div class="shop-popup-overlay" id="globalPromoPopup">
    <div class="shop-popup-content">
        <button class="shop-popup-close" onclick="closePromoPopup()" aria-label="Fermer">×</button>
        
        <<?php echo $p_link ? 'a href="'.$p_link.'"' : 'div'; ?> class="shop-popup-image-container">
            <picture>
                <source media="(max-width: 576px)" srcset="<?php echo $img_mobile; ?>">
                <source media="(max-width: 991px)" srcset="<?php echo $img_tablet; ?>">
                <img src="<?php echo $img_desktop; ?>" alt="Promotion">
            </picture>
        </<?php echo $p_link ? 'a' : 'div'; ?>>

        <?php if($p_btn && $p_link): ?>
        <div class="shop-popup-footer">
            <a href="<?php echo $p_link; ?>" class="shop-popup-btn"><?php echo $p_btn; ?></a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var popupId = <?php echo $p_id; ?>;
    var storageKey = 'shop_popup_closed_' + popupId;
    var twoHoursInMs = 2 * 60 * 60 * 1000;
    
    // Check local storage for this specific popup ID
    var closedItem = localStorage.getItem(storageKey);
    var shouldShow = true;
    
    if (closedItem) {
        var closedData = JSON.parse(closedItem);
        // data looks like { timestamp: 1612... }
        if (Date.now() - closedData.timestamp < twoHoursInMs) {
            // It has been less than 2 hours. Do not show.
            shouldShow = false;
        } else {
            // It has been more than 2 hours. We can show it again and clear the old item.
            localStorage.removeItem(storageKey);
        }
    }
    
    if (shouldShow) {
        var popupEl = document.getElementById('globalPromoPopup');
        if(popupEl) {
            // Show the popup with a slight delay for better UX
            setTimeout(function() {
                popupEl.style.display = 'flex';
                // Trigger reflow to apply CSS transition
                popupEl.offsetHeight; 
                popupEl.classList.add('show');
            }, 500);
        }
    }
});

function closePromoPopup() {
    var popupId = <?php echo $p_id; ?>;
    var storageKey = 'shop_popup_closed_' + popupId;
    var popupEl = document.getElementById('globalPromoPopup');
    
    // Animate out
    if(popupEl) {
        popupEl.classList.remove('show');
        setTimeout(function() {
            popupEl.style.display = 'none';
        }, 400); // match transition duration
    }
    
    // Save to localStorage with current timestamp
    localStorage.setItem(storageKey, JSON.stringify({
        timestamp: Date.now()
    }));
}
</script>
<?php
            }
        }
    }
}
?>
