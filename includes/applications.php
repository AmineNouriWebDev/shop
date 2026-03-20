
<section class="py-4">
    <div class="container-fluid">
        <div class="row justify-content-center px-lg-5">   		
            <?php 
            $req = "SELECT * FROM `applications` WHERE etat='1' ";
            $res = executeRequete($req);
            while ($datapp = mysqli_fetch_array($res)) {
                if($datapp['id']) $id_app = $datapp['id']; 
            ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                    <div class="cx-surface p-4 text-center h-100 d-flex flex-column align-items-center justify-content-between">
                        <!-- App Icon/Image -->
                        <div class="card-img mb-3">
                             <img src="<?php echo ImageApplications($id_app); ?>" alt="<?php echo nomApplications($id_app); ?>" class="img-fluid rounded-2xl shadow-sm" style="max-width: 120px; aspect-ratio: 1/1; object-fit: contain;">
                        </div>
                        
                        <!-- App Content -->
                        <div class="w-100 text-center">
                            <h3 class="text-xl font-bold mb-1" style="color: var(--shop-text-primary, #111827);">
                                <?php echo nomApplications($id_app); ?>
                            </h3>
                            
                            <div class="mx-auto my-3" style="width: 40px; height: 3px; background: var(--shop-primary); border-radius: 2px; opacity: 0.6;"></div>
                            
                            <div class="mt-4">
                                <a href="<?php echo fileApplications($id_app); ?>" class="cx-btn btn-primary-tw w-100" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>