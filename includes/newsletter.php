		<section class="section newsletter pt-4">
			<div class="container text-center abonnez-vous">			
				<div class="text-center">        
					<h2>Newsletter</h2>  
					<img src="dist/img/zig.png" class="mb-4">
				</div>
				<p class="mx-auto">Abonnez-vous à notre lettre d'informations et recevez nos offres promotionnelles par e-mail </p>
				<form method="POST" enctype="multipart/form-data" novalidate="novalidate" class="mx-auto">	
					<input type="text" class="form-control input-sm pac-target-input" name="abonner" placeholder="Votre adresse e-mail..." required="">
					<button type="submit" class="btn btn-newsletter" id="newsletterBTN" name="inscrir"><img src="dist/img/email.png" />S'abonner</button>	
				</form>
			</div>
		</section>
			<?php
				if(isset($_POST['inscrir'])){
				header('Content-Type: text/html; charset=utf-8'); 
				$requete = "Select * from `newsletter` WHERE `email` ='".$_POST['abonner']."'";
				//echo $requete; 
				$result = executeRequete($requete);
				$data = mysqli_fetch_array($result);
				if (isset($data['email'])) 
					$message= "Adresse déjà abonnée.";
				else{
					$res =executeRequete("INSERT INTO `newsletter` VALUES ('','".$_POST['abonner']."')");
					$message= "Merci pour votre inscription.";
				}
				}
			?>