	
<?php include('includes/menu.php');?>
	<?php // include('includes/sidebar.php'); // Removed to prevent duplicate menu display ?>
	
	<!---------------- Header ----------------------->
	<header class="header">
	
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			
	    <?php 
			$requete1   = "SELECT * FROM `sliders` WHERE `etat` = '1'";
			$resultat1  = executeRequete($requete1);
			$counter   = 0;
			$count	   = mysqli_num_rows($resultat1);			
	    ?>
		
			<!--Slides-->
			<div class="carousel-inner" role="listbox">
			<?php while($data1 = mysqli_fetch_array($resultat1)) { ?>
			
                <a href="<?php echo lienSlider($data1['id']); ?>" class="carousel-item <?php echo ( $counter == 0 ? ' active' : '' ) ?>" <?php echo ( $counter == 0 ? ' data-interval="3000"' : 'data-interval="2000"' ) ?>>
                      <img class="d-block img-fluid" src="<?php echo photoSliderSite($data1['id']); ?>" alt="First slide" style="max-height:660px;margin:auto;width:100%">
                </a>
                
			<?php $counter++;  } ?>
			</div>
			<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev" style="background: rgb(40 32 88 / 50%);width: 3%;">
			  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			  <span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next" style="background: rgb(40 32 88 / 50%);width: 3%;">
			  <span class="carousel-control-next-icon" aria-hidden="true"></span>
			  <span class="sr-only">Next</span>
			</a>
		</div>
	</header>
	<!--------------- Fin header ----------------->

