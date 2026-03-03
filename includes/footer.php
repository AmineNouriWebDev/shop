 <!--------------- Footer --------------------->
	
	<footer>

		<div class="footer-widget pt-4">
			<div class="container">
				<div class="row">
	                <div class="col-lg-3 col-md-6 col-sm-12 cl1 text-center">
	                    <div class="info justify-content-center">
	                        <a class="logo" href="<?php echo lienAccueil();?>"><img src="media/site/<?php echo $logo;?>"  class="logo" style="max-width:140px"></a>
	                    </div>
	                    <div  class="align-items-centerrow align-items-center rejoignez-nous">
								<h6 class="mb-4">Nous suivre sur</h6>
								<?php
								   $req  ="SELECT * FROM `social_network` WHERE `etat` = '1' ORDER BY `ordre`";
								   $res  = executeRequete($req);
								   while($data2 = mysqli_fetch_array($res)) {
								?>
								<a href="<?php echo lienSocialNetwork($data2['id']); ?>" role="button" target="_blank"><span><img src="<?php echo photoSocialNetworkSite($data2['id']); ?>" class="img-fluid" style="width:43px;height:43px"></span></a>
								
								<?php } ?>
						</div>
	                </div>
	                <div class="col-lg-3 col-md-6 col-sm-12 cl2">
	                    <div class="info">
	                        <h5 class="title text-uppercase"> Informations </h5>
	                        <nav>
	                         	<ul>
	                                <li>
	                                    <a href="<?php echo lienContenu(2);  ?>"> A propos de Techno plus </a>
	                                </li>
	                                <li>
	                                    <a href="<?php echo lienContenu(3);  ?>"> Liste des chaînes</a>
	                                </li>
	                                <li>
	                                    <a href="<?php echo lienContenu(8);  ?>"> Aide</a>
	                                </li>
	                                <li>
	                                    <a href="<?php echo lienContact();  ?>"> Contactez-nous </a>
	                                </li>
	                            </ul>
	                        </nav>
	                    </div>
	                </div>
	                <div class="col-lg-3 col-md-6 col-sm-12 cl2">
	                    <div class="info">
	                        <h5 class="title text-uppercase"> Boutique</h5>
	                        <nav>
	                         	<ul>
	                         	    <?php
                	                   $req = 'SELECT * FROM `categories_blog` WHERE `etat` = "1" ORDER BY `ordre` ASC LIMIT 4';
                	                   $res = executeRequete($req);
                	                    while ($data = mysqli_fetch_array($res)) 
                	                    { 
                	               ?>
	                                <li>
	                                    <a href="<?php echo lienCategorieEquipements($data['link']);  ?>"> <?php echo afficheChamp1($data['titre']); ?> </a>
	                                </li>
	                                <?php } ?>
	                            </ul>
	                        </nav>
	                    </div>
	                </div>
	                <div class="col-lg-3 col-md-6 col-sm-12 cl3">
	                    <div class="info">
	                        <h5 class="title text-uppercase"> Service clients</h5>	
	                        <nav>
	                         	<ul>
	                                <li>
	                                    <a href="tel:<?php echo $gsm;?>"><img src="dist/img/telephone.png"/> <p class="phone"><?php echo $gsm;?></p></a>
	                                </li>
	                                <li>
	                                    <a href="mailto:<?php echo $email_contact;?>"><img src="dist/img/email.png"/> <p class="mail"><?php echo $email_contact;?></p></a>
	                                </li>
	                            </ul>
	                        </nav>
	                    </div>
	                </div>
            	</div>
			</div>
		</div>
		<div class="pied-page">
			<div class="container">
				<div class="row align-items-center">	
    				<div class="col-sm-6 text-left">				
    					<p style="font-size: 12px;"><?php echo $copyright; ?>  </p>
    				</div>
    				<div class="col-sm-6 text-right">
    				    <img src="dist/img/payment-card.png" class="img-fluid" style=" max-width: 350px;">
    				</div>
				</div>
			
			</div>
		</div>
		<a id="scrollUP" href="#top" style="position: fixed; z-index: 2147483647; display: block;"><i class="fa fa-angle-up"></i></a>
	</footer>
	<!--------------- Fin Footer ---------------->