

		<div class="container login-container mt-5 mb-5" id="connexion">

		    <div class="row align-items-center" style="background: #29215a;">
				<div class="col-md-6 ads1">
					<div class="profile-img text-center">
						<img src="media/site/<?php echo $logo; ?>" alt="profile_img" class="img-fluid">
					</div>
				</div>
				<div class="col-md-6 login-form">
					<form action="<?php echo lienforget();?>" method="post"  data-toggle="validator" role="form" enctype="multipart/form-data">
						<p class="alert alert-secondary">Merci de saisir votre adresse e-mail afin de recevoir un nouveau mot de passe.</p>  
						<?php
						  if($erreur!=""){
						  ?>
						  <div class="alert alert-danger" role="alert">
						  <?php echo $erreur;?>
						</div>
						  
						  <?php
						  }
						  ?> 
						<div class="input-group mb-3">
						    <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
						    </div>
						    <input type="text" name="login" class="form-control" placeholder="Adresse e-mail"  required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info login-btn btn-block">Récupérer</button>
							<input type="hidden" name="action" value="forget">
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.container -->