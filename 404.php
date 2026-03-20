<?php 
http_response_code(404);
    include("include.php");

		$titre = 'Erreur 404: Page Introuvable !';
		$title_page = 'Erreur 404: Page Introuvable !';
        $variable2='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
 

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include('includes/script-header.php');?>
	
</head>
<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>

    <div class="main">
	
		<div class="container text-center py-3">
		
			<img src="dist/img/404.jpg" class="img-fluid" style="max-width:600px">	
			
			<h5 class="my-3" style="color:#000;"> La page recherchée est introuvable !</h5>
			
			<a href="<?php echo lienAccueil(); ?>" style="font-family: 'Montserrat';border-radius: 50px;padding: 10px 25px;" class="btn btn-danger">Retour à la page d'accueil</a>
            
		</div>
    
	</div>
	
	<?php include('includes/footer.php');?>

	<?php include('includes/script_footer.php');?>

</body>
</html>