

        <section class="section section4 bg-white py-4">
            
		    <div class="container-fluid">
		        
				<div class="row justify-content-center">   		
        		
                	<?php 
            			            $req = "SELECT * FROM `applications` WHERE etat='1' ";
                                    $res = executeRequete($req);
                		            while ($datapp = mysqli_fetch_array($res))  {
                    				if($datapp['id'])    $id_app    = $datapp['id']; 
                	?>
			                    <div class="col-xs-6 col-sm-6 mobile-section col-md-4 col-lg-2 mb-4">
        							<div class="card p-3 h-100 text-center" style="border-radius:20px;background: #282058;">
        								<!-- Product Image -->
        								<div class="card-img">
        									 <img src="<?php echo ImageApplications($id_app); ?>" alt="" class="img-fluid" width="200px">
        								</div>
        								
        
        								<!-- Product Description -->
        								<div class="card-description pt-3">
        								    <h6 style="color:#e82069"><?php echo nomApplications($id_app); ?> </h6>
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
            </div>
        </section>