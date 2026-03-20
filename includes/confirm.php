
	<!----------------- Main --------------------->
	<div class="main">
			
			<!-----------------------Breadcrumb------------------->
			<div class="single-product-area">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb pl-0">
									 <li class="breadcrumb-item"><a href="<?php echo lienAccueil();?>">Accueil</a></li>
										<?php echo $variable2;?>

								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
	    
	    <div class="container">
	    
    	    <div class="alert alert-success text-center mb-4 p-4">
    
                <?php
                    //https://api.whatsapp.com/send?phone=21622484915
                    echo strip_tags($contenu);
                ?>
                
            </div>
            
        </div>
    
    </div>