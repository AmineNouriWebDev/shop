	
	
	<?php
        $nom			= nomClient($_SESSION['client_id']);
        $prenom			= prenomClient($_SESSION['client_id']);
        $email			= emailClient($_SESSION['client_id']);
        $tel			= telClient($_SESSION['client_id']);
        $adresse		= adresseClient($_SESSION['client_id']);
        $ville		    = villeClient($_SESSION['client_id']);
        $cp		        = cpClient($_SESSION['client_id']);
        $passwordClient	= passwordClient($_SESSION['client_id']);
        
	    $variable2='<li class="breadcrumb-item active" aria-current="page"><a href="'.lienCompte().'">'.titrePage(9).'</a></li>';
	    include("breadcrumb.php");
	    $id_client = $_SESSION['client_id'];

	if(isset($_POST['action']) && $_POST['action']=="infos"){ //envoi modif infos personnelles
		$nom=sanitize($_POST['nom']);
		$prenom=sanitize($_POST['prenom']);

		$email=sanitize($_POST['email']);
		$tel=sanitize($_POST['tel']);
		$adresse=sanitize($_POST['adresse']);
		$ville=sanitize($_POST['ville']);
		$cp=sanitize($_POST['cp']);
		$req="SELECT * FROM `clients` where `email` ='".$email."' AND id<>'".$_SESSION['client_id']."'";   
	 // echo $req; exit; 
		$res=executeRequete($req);
		$data1 = mysqli_fetch_array($res);
		if($data1['id']!=""){ // compte existe avec l'adresse email 
		  $erreur="Un compte existe déjà avec cette adresse e-mail!";
		?>
		<script language="javascript">
	  <!--
		alert('<?php echo $erreur;?>')
	  -->
	  </script>
		<?php
		}else{ // enregistrer les modifications
		  $req="UPDATE `clients` set `nom`='".$nom."',`prenom`='".$prenom."',`tel`='".$tel."',`adresse`='".$adresse."',`ville`='".$ville."',`code_postale`='".$cp."' where `id` ='".$_SESSION['client_id']."'";
		  executeRequete($req);
		  $succes="Informations mises à jour avec succès.";   
		}
	}
	
	if(isset($_POST['action']) && $_POST['action']=="mdp"){ //envoi modif infos personnelles

		if($passwordClient == sanitize($_POST['current_password']))
		{
		  $current_password=sanitize($_POST['current_password']);
		  $new_password=sanitize($_POST['new_password']);
		  $confirm_password=sanitize($_POST['confirm_password']);
		  if($new_password == $confirm_password)
		  { 
		      
		    $password = $new_password;
		    $req="UPDATE `clients` set `password`='".$password."' where `id` ='".$_SESSION['client_id']."'";
		    executeRequete($req);
		    $succes="Mot de passe mise à jour avec succès."; 
		  }
		  else
		  { 
		      $erreur="Il faut confirmer votre mot de passe!";
		      
		    ?>
		    <script language="javascript">
	        <!--
		    alert('<?php echo $erreur;?>')
	        -->
	        </script>
		    <?php
	      }
		}
		else
		{
          $erreur="votre mot de passe est incorrect!";
		?>
		<script language="javascript">
	  <!--
		alert('<?php echo $erreur;?>')
	  -->
	  </script>
		<?php
	    }
	}
 	?>	
	
	<div class="main">
		<div class="container animated fadeInUp " data-delay="0.8s">
			<div class=" section-padding-20">			
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="nav flex-column nav-pills-tw bg-white p-3 rounded-3xl shadow-sm border mb-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						  <a class="nav-link-tw active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"> <i class="fa fa-home"></i> Tableau de bord </a>
						  <a class="nav-link-tw" id="v-pills-infos-tab" data-toggle="pill" href="#v-pills-infos" role="tab" aria-controls="v-pills-infos" aria-selected="false"> <i class="fa fa-user"></i> Informations personnelles </a>
						  <a class="nav-link-tw" id="v-pills-history-tab" data-toggle="pill" href="#v-pills-history" role="tab" aria-controls="v-pills-history" aria-selected="false"> <i class="fa fa-shopping-basket"></i> Historiques des commandes</a>
						  <div class="border-top my-2"></div>
						  <a class="nav-link-tw text-danger" id="deconnect" href="<?php echo lienDeconnexion(); ?>" ><i class="fa fa-sign-out"></i> Déconnexion</a>
						</div>
					</div>
					<div class="col-md-9 col-sm-12">
						<div class="tab-content bg-white p-4 rounded-3xl shadow-sm border" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							    
								<span>Bienvenue <?php echo ucwords(nomClient($id_client).' '.prenomClient($id_client)); ?> ,</span>
								<p class="mt-3">
								
								À partir du tableau de bord de votre compte, vous pouvez afficher vos <b>historiques des commandes</b> et <b>modifier votre mot de passe et les détails de votre compte</b>.
								
								</p>
						  
							</div>
							<div class="tab-pane fade" id="v-pills-infos" role="tabpanel" aria-labelledby="v-pills-infos-tab">
							    
								<?php include('infos_personnels.php');?>
							</div>
							<div class="tab-pane fade" id="v-pills-history" role="tabpanel" aria-labelledby="v-pills-history-tab">
							    
								<?php include('historique_commandes.php');?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		</div>
	</div>
	
<style>
/* ── Account Nav Overrides ───────────────────────────── */
.rounded-3xl { border-radius: 1.5rem !important; }
.nav-link-tw {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.875rem 1rem; color: var(--shop-text-secondary, #4b5563);
    font-weight: 600; border-radius: 0.75rem; text-decoration: none;
    transition: all 200ms ease; margin-bottom: 0.25rem;
}
.nav-link-tw:hover {
    background: var(--shop-bg-alt, #f3f4f6); color: var(--shop-primary, #5A31F4);
    text-decoration: none; margin-left: 4px; border-radius: 0.75rem;
}
.nav-link-tw.active {
    background: color-mix(in srgb, var(--shop-primary, #5A31F4) 12%, transparent) !important;
    color: var(--shop-primary, #5A31F4) !important;
}
.nav-link-tw i {
    width: 20px; text-align: center; opacity: 0.8;
}
.tab-content {
	min-height: 400px;
}
</style>
