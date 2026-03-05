<?php

	session_start();
	include("include.php");
	
	if(isset($_GET['link']) && $_GET['link'] != '' ){	
		$link=  sanitize($_GET['link']); 	
    	$requete = "SELECT * FROM `categories_blog` WHERE `link` = '".$link."'";
        //echo $requete;
        $resultat = executeRequete($requete);
        $data = mysqli_fetch_array($resultat);
        if($data['id']!=""){
            
            $id     = afficheChamp($data['id']);
            $titre  = titreCategories($data['link']);    
            $photo  = isset($data['photo']) ? afficheChamp($data['photo']) : '';	   
			$idp    = afficheChamp($data['idparent']);		   	
			$typeOg = "Category";
			$imgOg  = 'media/blog/'.$photo;
			if($idp != 0){
			    
                $titrecp  = titreCategories(linkCategBlog($idp)); 
                
    			$urlOg  = lienAccueil().''.lienCategorieEquipements($link);
                if($data['titre_page'] != '') $title_page=afficheChamp1($data['titre_page']); else { $title_page = str_replace("%%SOUSCATEGORIE%%",$titre,$title_scateg); $title_page = str_replace("%%CATEGORIE%%",$titrecp,$title_page); }
                if($data['keywords'] != '') $keywords_page=afficheChamp($data['keywords']); else { $keywords_page = str_replace("%%SOUSCATEGORIE%%",$titre,$keywords_scateg); $keywords_page = str_replace("%%CATEGORIE%%",$titrecp,$keywords_page);  }
                if($data['description'] != '') $description_page=afficheChamp($data['description']); else { $description_page = str_replace("%%SOUSCATEGORIE%%",$titre,$description_scateg); $description_page = str_replace("%%CATEGORIE%%",$titrecp,$description_page); }
			}else{
    			$urlOg  = lienAccueil().''.lienCategories($link);
                if($data['titre_page'] != '') $title_page=afficheChamp1($data['titre_page']); else $title_page = str_replace("%%CATEGORIE%%",$titre,$title_categ);
                if($data['keywords'] != '') $keywords_page=afficheChamp($data['keywords']); else $keywords_page = str_replace("%%CATEGORIE%%",$titre,$keywords_categ);
                if($data['description'] != '') $description_page=afficheChamp($data['description']); else $description_page = str_replace("%%CATEGORIE%%",$titre,$description_categ);
			}
        }
	}elseif(isset($_GET['promo'])){
	    
    	$requete = "SELECT * FROM `site_menu` WHERE `id` = '23'";
        //echo $requete;
        $resultat = executeRequete($requete);
        $data = mysqli_fetch_array($resultat);
        if($data['id']!=""){
            
            $id=afficheChamp($data['id']);
            $titre=afficheChamp($data['titre']);		        
            $contenu=afficheChamp($data['contenu']);
            $description_page=afficheChamp($data['description']);
            $title_page=afficheChamp($data['titre_page']);
            $keywords_page=afficheChamp($data['keywords']);
        }
	}else{
	    
    	$requete = "SELECT * FROM `site_menu` WHERE `id` = '18'";
        //echo $requete;
        $resultat = executeRequete($requete);
        $data = mysqli_fetch_array($resultat);
        if($data['id']!=""){
            
            $id=afficheChamp($data['id']);
            $titre=afficheChamp($data['titre']);		        
            $contenu=afficheChamp($data['contenu']);
            $description_page=afficheChamp($data['description']);
            $title_page=afficheChamp($data['titre_page']);
            $keywords_page=afficheChamp($data['keywords']);
            
        }else{
            
            $url = current_url();
            $date = timestampTD(date("d/m/Y H:i:s"));
            executeRequete("INSERT INTO `pages_introuvables`(`url_page`, `date`) VALUES ('".$url."','".$date."')");
            ?>
        	<script language="javascript">
        	<!--
        		window.location = '/error404.html';
        	-->
        	</script>
        	<?php
        	//echo $strSQL;
        	exit;
        }
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { margin: 0; font-family: 'Inter', system-ui, sans-serif; background: var(--shop-bg-base); color: var(--shop-text-primary); }
    .marque-logo .card { width:100%; height:100%; overflow:hidden; justify-content:center; border-radius: 1rem; border: 1px solid var(--shop-border, #e5e7eb); transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .marque-logo .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1); border-color: var(--shop-primary, #5a31f4); }
    .marque-logo .card img { width:100%; object-fit:contain; height:-webkit-fill-available; padding: 1rem; }
    /* jQuery UI slider: brand purple */
    #price_range.ui-slider { height:5px !important; background:var(--shop-border,#E0DEFF) !important; border:none !important; border-radius:3px !important; width: 85% !important; margin: 1.5rem auto 1rem auto !important; }
    #price_range .ui-slider-range { background:var(--shop-primary,#5A31F4) !important; }
    #price_range .ui-slider-handle { width:16px !important;height:16px !important;top:-6px !important;border-radius:50% !important;background:var(--shop-primary,#5A31F4) !important;border:2px solid #fff !important;box-shadow:0 2px 6px rgba(90,49,244,.4) !important;cursor:pointer !important; }
    #price_range .ui-slider-handle:focus { outline:none !important; box-shadow:0 0 0 3px rgba(90,49,244,.25) !important; }
    /* Prevent sidebar horizontal overflow */
    .shop_sidebar_area { overflow-x: hidden; }
    /* Prevent product area from shrinking when few products are loaded */
    .amado_product_area { flex: 1; min-width: 0; }
  </style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>

    <?php 
       include("includes/categorie.php");
    ?>


  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
  <?php include('includes/script_panier.php'); ?>
	 
	 
	 
	<?php
    if ((isset($_GET['link']) && $_GET['link'] != '')){ 
    $reqprice = 'SELECT MIN(prix_vente) as min, MAX(prix_vente) as max FROM `produits` WHERE categorie="'.idCategBlog($_GET['link']).'" || idparent_categ="'.idCategBlog($_GET['link']).'"';
    $resprice = executeRequete($reqprice);
    $dataprice = mysqli_fetch_array($resprice);
	}elseif ((isset($_GET['promo']) )){ 
    $reqprice = 'SELECT MIN(prix_promo) as min, MAX(prix_promo) as max FROM `produits` WHERE prix_promo !="0.000"';
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

        var currentPage = 1;

		filter_data(1);

		function filter_data(page)
		{
            if(typeof page === 'undefined') page = 1;
            currentPage = page;
			$('.filter_data').html('<div style="min-height:200px;display:flex;align-items:center;justify-content:center;"><i class="fa fa-spinner fa-spin fa-2x" style="color:var(--shop-primary,#5A31F4);"></i></div>');
			var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var promo         = "<?php if(isset($_GET['promo'])) echo 'promo';else echo ''; ?>";
			var brand = get_filter('brand');
			var type = document.getElementById('typeProd').value;
			var link = document.getElementById('linkProd').value;
			var category = get_filter('category');
			var caracteristique = get_filter('caracteristique');
			$.ajax({
				url:"includes/fetch_data_test.php",
				method:"POST",
				data:{
                    action:action,
                    brand:brand,
                    category:category,
                    caracteristique:caracteristique,
                    type:type,
                    minimum_price:minimum_price,
                    maximum_price:maximum_price,
                    link:link,
                    promo:promo,
                    page:currentPage
                },
				success:function(data){
					$('.filter_data').html(data);
				}
			});
		}

        /* Exposed globally so pagination buttons in AJAX response can call this */
        window.filter_data_page = function(page){ filter_data(page); };

		function get_filter(class_name)
		{
			var filter = [];
			$('.'+class_name+':checked').each(function(){
				filter.push($(this).val());
			});
			/* Support for mobile select dropdowns */
			$('select.'+class_name).each(function(){
				if($(this).val() && $(this).val() !== '') {
					filter.push($(this).val());
				}
			});
			return filter;
		}

        /* Reset to page 1 on any filter change */
		$('.common_selector').on('click change', function(){
			filter_data(1);
		});

        $('#price_range').slider({
            range:true,
            min:<?php echo $dataprice['min'] ?? 0; ?>,
            max:<?php echo $dataprice['max'] ?? 1000; ?>,
            values:[<?php echo $dataprice['min'] ?? 0; ?>, <?php echo $dataprice['max'] ?? 1000; ?>],
            format:"DT",
            step:0.001,
            unit:'DT',
            stop:function(event, ui)
            {
                $('#price_show').html(ui.values[0] + ' DT - ' + ui.values[1] +' DT');
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                filter_data(1);
            }
        });

    });
    
    </script>
	
</body>

</html>