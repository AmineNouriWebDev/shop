<?php

	session_start();


	include("include.php");


        $Request = 'SELECT * FROM `site_menu` WHERE `id` = "20" AND `etat` = "1" ';
		
    	$Result  = executeRequete($Request) ;
		
    	$Datum = mysqli_fetch_array($Result);
            
        if(isset($_GET['marque']) && isset($_GET['categorie'])) { $title_page = str_replace("%%CATEGORIE%%",titreCategories($_GET['categorie']),$title_marque);  $title_page = str_replace("%%MARQUE%%",$_GET['marque'],$title_page); }elseif($Datum['titre_page'] != '') $title_page=afficheChamp($Datum['titre_page']); 
            
        if(isset($_GET['marque']) && isset($_GET['categorie'])) { $keywords_page = str_replace("%%CATEGORIE%%",titreCategories($_GET['categorie']),$keywords_marque); $keywords_page = str_replace("%%MARQUE%%",$_GET['marque'],$keywords_page);  }elseif($Datum['keywords'] != '') $keywords_page=afficheChamp($Datum['keywords']);  
            
        if(isset($_GET['marque']) && isset($_GET['categorie'])) { $description_page = str_replace("%%CATEGORIE%%",titreCategories($_GET['categorie']),$description_marque); $description_page = str_replace("%%MARQUE%%",$_GET['marque'],$description_page);  }elseif($Datum['description'] != '') $description_page=afficheChamp($Datum['description']); 
		
        $contenu = afficheChamp($Datum['contenu']);
		
    	$titre   = afficheChamp($Datum['titre']);
		
    	$id = $Datum['id'];
    	
        $img=afficheChamp($Datum['image']);
        
        $img_entete = photoPageSite($id);
    	
    	
	$variable2='<li class="breadcrumb-item text-secondary" aria-current="page">'.$titre.'</li>';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <?php include('includes/script_panier.php'); ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { margin: 0; font-family: 'Inter', system-ui, sans-serif; background: var(--shop-bg-base); color: var(--shop-text-primary); }
    /* jQuery UI slider: brand purple */
    #price_range.ui-slider { height:5px !important; background:var(--shop-border,#E0DEFF) !important; border:none !important; border-radius:3px !important; width: 85% !important; margin: 1.5rem auto 1rem auto !important; }
    #price_range .ui-slider-range { background:var(--shop-primary,#5A31F4) !important; }
    #price_range .ui-slider-handle { width:16px !important;height:16px !important;top:-6px !important;border-radius:50% !important;background:var(--shop-primary,#5A31F4) !important;border:2px solid #fff !important;box-shadow:0 2px 6px rgba(90,49,244,.4) !important;cursor:pointer !important; }
    #price_range .ui-slider-handle:focus { outline:none !important; box-shadow:0 0 0 3px rgba(90,49,244,.25) !important; }
    .shop_sidebar_area { overflow-x: hidden; }
  </style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>
	
	<?php include('includes/recherche.php');?>


  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
	 
	 
	 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
	 
	 
	<?php
    if ((isset($_GET['categorie']) && $_GET['categorie'] != '')){ 
    $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits` WHERE categorie="'.idCategBlog($_GET['categorie']).'" || idparent_categ="'.idCategBlog($_GET['categorie']).'"';
    $resprice = executeRequete($reqprice);
    $dataprice = mysqli_fetch_array($resprice);
	}else{
    $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits`';
    $resprice = executeRequete($reqprice);
    $dataprice = mysqli_fetch_array($resprice);
	}
    ?>	
	
 	<script type="text/javascript">
 	
    $(document).ready(function(){

		filter_data();

		function filter_data()
		{
			$('.filter_data').html('<div class="row"> <div class="col-12"><div id="loading"></div></div></div>');
			var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
			var search    = "<?php if ((isset($_POST['recherche']) && $_POST['recherche'] != '')){ echo $_POST['recherche']; } /*elseif ((isset($_GET['marque']) && $_GET['marque'] != '')){ echo $_GET['marque']; }*/elseif((isset($_POST['action']) && $_POST['action'] == 'search') || (isset($_POST['action']) && $_POST['action'] == 'search1')){ echo addslashes($_POST['recherche']); }else{ echo  ''; }  ?>";
			var brand = get_filter('brand') ;
            var promo         = "<?php if(isset($_GET['promo'])) echo 'promo';else echo ''; ?>";
			var marque = "<?php if((isset($_GET['marque']) && $_GET['marque'] != '')){ echo $_GET['marque']; }else{ echo  ''; }  ?>";
			var type = document.getElementById('typeProd').value;
			var link = document.getElementById('linkProd').value;
			var category = get_filter('category');
			var caracteristique = get_filter('caracteristique');
			var categoryByTitre = '<?php if ((isset($_GET['categorie']) && $_GET['categorie'] != '')){ echo $_GET['categorie']; }elseif ((isset($_POST['categorie']) && $_POST['categorie'] != '')){ echo linkCategBlog($_POST['categorie']); }else{ echo ''; } ?>';
			$.ajax({
				url:"includes/fetch_data_test.php",
				method:"POST",
				data:{action:action,brand:brand, category:category,caracteristique:caracteristique, type:type,link:link,search:search, minimum_price:minimum_price, maximum_price:maximum_price,categoryByTitre:categoryByTitre,marque:marque,promo:promo },
				
				success:function(data){
					$('.filter_data').html(data);
				}
			});
		}

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			return filter;
		}

		$('.common_selector').click(function(){
			filter_data();
		});

        $('#price_range').slider({
            range:true,
            min:<?php echo $dataprice['min'] ?? 0; ?>,
            max:<?php echo $dataprice['max'] ?? 1000; ?>,
            values:[<?php echo $dataprice['min'] ?? 0; ?>, <?php echo $dataprice['max'] ?? 1000; ?>],
            step:0.001,
            format:'DT',
            stop:function(event, ui)
            {
                $('#price_show').html(ui.values[0] + ' DT - ' + ui.values[1] +' DT');
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                filter_data();
            }
        });
		$('.slect2').select2();

    });
    
    </script>
	
</body>

</html>