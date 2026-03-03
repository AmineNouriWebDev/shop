

        <section class="section section4 bg-light py-4">
            
		    <div class="container-fluid">
                    		
                <div class="text-center my-4">
    				<h2>Nos applications</h2>
				</div>     
				<div class="row justify-content-center">   		
        		
                	<?php 
            			            $req = "SELECT * FROM `applications` WHERE etat='1' LIMIT 0,12";
                                    $res = executeRequete($req);
                		            while ($datapp = mysqli_fetch_array($res))  {
                    				if($datapp['id'])    $id_app    = $datapp['id']; 
                	?>
			                    <div class="col-xs-6 col-sm-4 mobile-section col-md-4 col-lg-2 mb-4">
        							<div class="card p-3 h-100 text-center" style="border-radius:20px;background: #282058;">
        								<!-- Product Image -->
        								<div class="card-img">
        									 <img src="<?php echo ImageApplications($id_app); ?>" alt="" class="img-fluid" width="200px">
        								</div>
        								
        
        								<!-- Product Description -->
        								<div class="card-description pt-3">
        								    <h6><?php echo nomApplications($id_app); ?> </h6>
        								    <div class="line" style="width: 100px; height: 3px; background-color: #fab60e;display: block; margin: 15px auto;"></div>
        									<!-- Product Meta Data -->
        									<div class="card-meta-data">
        										<a href="<?php echo fileApplications($id_app); ?>" class="btn btn-acces" target="_blank">
        										    <i class="fa fa-upload mr-1" aria-hidden="true"></i> Télécharger
        										</a>
        									</div>
        								</div>
        							</div>
        						</div>
        						
    		        <?php }  ?>
        	    </div>
        	    <div class="text-right">
				    <a href="<?php echo lienApplications(); ?>" class="all-pack">Tous les applications <i class="fa fa-angle-double-right"></i></a>
				</div>
            </div>
        </section>