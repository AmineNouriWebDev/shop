	<!-- Required meta tags -->    
	
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="media/site/<?php echo $favicon; ?>">    
        
    <title><?php if($title_page !='') echo $title_page; else echo 'Accueil'; ?></title>
    <meta name="description" content="<?php echo $description_page; ?>" />
    <meta name="keywords" content="<?php echo $keywords_page; ?>" />
    <meta name="author" content="maxsolving.com">
    <?php 
        if(isset($price) && $price!="" && $price!="0.000"){
    ?>
    <meta property="product:retailer_item_id" content="<?php echo $id; ?>" />
    <?php 
        }
    ?>
    <meta property="og:title" content="<?php if($title_page !='') echo $title_page; ?>" />
    <meta property="og:description" content="<?php echo $description_page; ?>" />
    <meta property="og:type" content="<?php if($typeOg !='' ) echo $typeOg ; else echo 'website'; ?>" />
    <meta property="og:url" content="<?php if($urlOg !='' ) echo $urlOg ; else echo lienAccueil(); ?>" />
    <meta property="og:image" content="<?php if($imgOg != '' ) echo $chemin_absolu.''.$imgOg; else echo $chemin_absolu."media/site/".$logo; ?>" />
    <?php 
        if(isset($price) && $price!="" && $price!="0.000"){
    ?>
    <meta property="product:price:amount" content="<?php echo str_replace(".",",",$price); ?>" />
    <meta property="product:price:currency" content="TND" />
    <meta property="og:availability" content="<?php echo $availability; ?>" />
    <?php 
        }
    ?> 
    