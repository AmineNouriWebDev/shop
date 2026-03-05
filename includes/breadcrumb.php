	<!-- Breadcrumb Modernisé -->
	<div class="container mt-4 mb-2">
        <nav aria-label="breadcrumb" class="px-4 py-3 rounded-pill shadow-sm border border-gray-100" style="font-size: 0.85rem; font-weight: 600; background: var(--shop-surface);">
            <ol class="breadcrumb m-0 p-0 bg-transparent align-items-center" style="display:flex; flex-wrap:wrap; list-style:none;">
                <li class="breadcrumb-item-tw d-flex align-items-center"><a href="<?php echo lienAccueil();?>" class="text-secondary text-decoration-none"><i class="fa fa-home me-2"></i> Accueil</a></li>
                <?php if(isset($variable2) && $variable2 != '') { echo '<li class="mx-2 text-muted d-flex align-items-center"><i class="fa fa-chevron-right" style="font-size:0.6rem;"></i></li>' . str_replace('breadcrumb-item', 'breadcrumb-item-tw d-flex align-items-center', $variable2); } ?>
				<?php if(isset($variable3) && $variable3 != '') { echo '<li class="mx-2 text-muted d-flex align-items-center"><i class="fa fa-chevron-right" style="font-size:0.6rem;"></i></li>' . str_replace('breadcrumb-item', 'breadcrumb-item-tw d-flex align-items-center', $variable3); } ?>
				<?php if(isset($variable4) && $variable4 != '') { echo '<li class="mx-2 text-muted d-flex align-items-center"><i class="fa fa-chevron-right" style="font-size:0.6rem;"></i></li>' . str_replace('breadcrumb-item', 'breadcrumb-item-tw d-flex align-items-center', $variable4); } ?>
				<?php if(isset($variable5) && $variable5 != '') { echo '<li class="mx-2 text-muted d-flex align-items-center"><i class="fa fa-chevron-right" style="font-size:0.6rem;"></i></li>' . str_replace(array('breadcrumb-item active', 'breadcrumb-item'), array('breadcrumb-item-tw active text-primary', 'breadcrumb-item-tw active text-primary'), $variable5); } ?>
            </ol>
        </nav>
    </div>
    
    <style>
    .breadcrumb-item-tw a { color: #6b7280; text-decoration: none; transition: color 0.15s ease-in-out; }
    .breadcrumb-item-tw a:hover { color: var(--shop-primary, #5A31F4); }
    .breadcrumb-item-tw.active { color: var(--shop-primary, #5A31F4); font-weight: 700; }
    </style>
	<!-- Fin Breadcrumb Modernisé -->
