		<!---------------- Nav-bar ----------------------->
	<nav class="navbar navbar-expand-lg navbar-light ">
		<div class="container">

			<a class="navbar-brand" href="<?php echo lienAccueil();?>"><img src="media/site/<?php echo $logo;?>" class="logo-navbar"></a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">

				<ul class="navbar-nav mx-auto">
				    
				<?php

		           $requete1 ="SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='0' ORDER BY `ordre`";

	               $resultat1 = executeRequete($requete1);

	               while($data1 = mysqli_fetch_array($resultat1)) {

					    $requete2 ="SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='".$data1['id']."' ORDER BY `ordre`";

	                    $resultat2 = executeRequete($requete2);

	                    $num2      = mysqli_num_rows($resultat2);

		        ?>
		          
					<li class="nav-item <?php if($num2){ ?>dropdown<?php } ?>">

						<a class="nav-link <?php if($num2){ ?>dropdown-toggle<?php } ?>" href="<?php echo lienContenu($data1['id']); ?>" <?php if($num2){ ?>id="navbarDropdown<?php echo $data1['id']; ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"<?php } ?>>
							
							<?php echo utf8_decode(titrePage($data1['id'])); ?> <?php if($num2){ ?><i class="fa fa-angle-down"></i><span class="sr-only">(current)</span><?php } ?>
						
						</a>

                           <?php if($num2){ ?>

							<div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <?php  $data2 = mysqli_fetch_array($resultat2);
							
								$req2 = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent`='0' ORDER BY `titre`";
								
								$res2 = executeRequete($req2);
								
								while($data3 = mysqli_fetch_array($res2)){
									
							?>

							    <a class="dropdown-item waves-effect waves-light" href="<?php echo lienCategorieEquipements($data3['link'],$data3['type']);  ?>"><i class="fa fa-caret-right"></i> &nbsp; <?php echo afficheChamp($data3['titre']); ?></a>
								<?php
        	                        $req1 = "SELECT * FROM `categories_blog` WHERE `idparent` = '".$data3["id"]."' AND `etat` = '1' ORDER BY `ordre` ASC ";
        	                        $res1 = executeRequete($req1);
        	                         while ($data1 = mysqli_fetch_array($res1)) { 
								?>
        	                        <a class="dropdown-item waves-effect waves-light pl-4" href="<?php echo lienCategorieEquipements($data1['link'],$data1['type']);  ?>"> <?php echo  afficheChamp($data1['titre']); ?></a>
        	                                     
								<?php } ?>
                            <?php } ?>

							</div>

                            <?php } ?>

					</li>
					
					
                    <?php } ?>
				</ul>
				
				
				<a href="" class="btn btn-acces"><img src="dist/img/customer-feedback.png" /> Accès clients </a>
			</div>
		</div>
	</nav>
	<!---------------- Fin Nav-bar ------------------>
	
	<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location;
        $('ul.navbar-nav a[href="'+ url +'"]').parent().addClass('active');
        $('ul.navbar-nav a').filter(function() {
             return this.href == url;
        }).parent().addClass('active');
    });
	</script> 