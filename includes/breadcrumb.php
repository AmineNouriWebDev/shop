
	<!---------------- Breadcrumb ----------------------->

	<div class="main-content-wrapper mt-4">
	    <div class="single-product-area" style="max-width:100%!important;width:100%!important;">
	        <div class="container">
	            <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb pl-0">
                                <li class="breadcrumb-item"><a href="<?php echo lienAccueil();?>">Accueil</a></li>
                                <?php echo isset($variable2) ? $variable2 : '';?>
								<?php echo isset($variable3) ? $variable3 : '';?>
								<?php echo isset($variable4) ? $variable4 : '';?>
								<?php echo isset($variable5) ? $variable5 : '';?>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!--------------- Fin Breadcrumb ----------------->
