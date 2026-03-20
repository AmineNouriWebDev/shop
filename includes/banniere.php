	
	<?php include('includes/menu.php');?>
	
	
<!---------------- Header ----------------------->
	<header class="header">
		
		<div class="view intro-2 banniere" style="background: url('dist/img/iptv-definition.png') no-repeat center center;background-size: cover;" >	
		    
		    <div class="banner-title text-center white-text p-5">
				<?php if((isset($_POST['action']) && $_POST['action'] == 'search')): ?>
		        <h1> Produits de la recherche : <?php echo htmlspecialchars($_POST['recherche'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h1>
				<?php elseif((isset($_GET['marque']) && $_GET['marque'] != '')): ?>
		        <h1> Produits de la recherche :  <?php echo htmlspecialchars($_GET['marque'], ENT_QUOTES, 'UTF-8'); ?></h1>
				<?php elseif((isset($_GET['search']) && $_GET['search'] != '')): ?>
		        <h1> Produits de la recherche : <?php echo htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8'); ?></h1>
				<?php elseif(isset($titre) && $titre != ''): ?>
				<h1><?php echo $titre; ?></h1>
				<?php endif; ?>
		    </div>
			
		</div>
	</header>

