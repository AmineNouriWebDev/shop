	<!-- Required meta tags -->    
    <?php 
    if(!isset($developer_comment)) {
        // Fallback scope fetch if index.php lost the connec.php variable
        if(isset($connexion) && $connexion) {
            $dc_res = mysqli_query($connexion, "SELECT developer_comment FROM site_configuration LIMIT 1");
            if($dc_res && $dc_row = mysqli_fetch_assoc($dc_res)) {
                $developer_comment = $dc_row['developer_comment'];
            }
        }
    }
    if(isset($developer_comment) && $developer_comment != ''): 
    ?>
    <?php echo $developer_comment; ?>
    <?php endif; ?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicons Optimisés -->
    <link rel="icon" href="media/site/<?php echo $favicon; ?>" type="image/png" sizes="192x192" />
    <link rel="apple-touch-icon" href="media/site/<?php echo $favicon; ?>" />
    <link rel="icon" href="media/site/<?php echo $favicon; ?>" type="image/png" sizes="32x32" />
    <link rel="icon" href="media/site/<?php echo $favicon; ?>" type="image/png" sizes="16x16" />
    <link rel="shortcut icon" href="media/site/<?php echo $favicon; ?>" type="image/x-icon" />
    
    <!-- PWA Manifest — Permet l'installation sur mobile/desktop -->
    <link rel="manifest" href="<?php echo $chemin_absolu; ?>manifest.webmanifest.php">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo isset($nom_site) ? htmlspecialchars($nom_site, ENT_QUOTES) : 'Offipro'; ?>">
        
    <title><?php if(isset($title_page) && $title_page !='') echo $title_page; else echo 'Accueil'; ?></title>
    <meta name="description" content="<?php echo isset($description_page) ? $description_page : ''; ?>" />
    <meta name="keywords" content="<?php echo isset($keywords_page) ? $keywords_page : ''; ?>" />
    <meta name="author" content="maxsolving.com">
    
    <?php if(isset($theme_color) && $theme_color !=''): ?>
    <meta name="theme-color" content="<?php echo $theme_color; ?>">
    <?php else: ?>
    <meta name="theme-color" content="#ffffff">
    <?php endif; ?>

    <?php if(isset($google_search_console) && $google_search_console != ''): ?>
    <meta name="google-site-verification" content="<?php echo $google_search_console; ?>" />
    <?php endif; ?>

    <?php if(isset($analytics) && $analytics != ''): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analytics; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $analytics; ?>');
    </script>
    <?php endif; ?>

    <?php 
        if(isset($price) && $price!="" && $price!="0.000"){
    ?>
    <meta property="product:retailer_item_id" content="<?php echo $id; ?>" />
    <?php 
        }
        
        // OpenGraph Defaults to avoid warnings
        $og_type = (isset($typeOg) && $typeOg != '') ? $typeOg : 'website';
        $og_url  = (isset($urlOg) && $urlOg != '') ? $urlOg : current_url();
        $og_img  = (isset($imgOg) && $imgOg != '') ? $chemin_absolu.$imgOg : $chemin_absolu."media/site/".(isset($logo) ? $logo : '');
    ?>
    <meta property="og:title" content="<?php if(isset($title_page) && $title_page !='') echo $title_page; else echo 'Accueil'; ?>" />
    <meta property="og:description" content="<?php echo isset($description_page) ? $description_page : ''; ?>" />
    <meta property="og:type" content="<?php echo $og_type; ?>" />
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    <meta property="og:image" content="<?php echo $og_img; ?>" />
    
    <?php 
        if(isset($price) && $price!="" && $price!="0.000"){
    ?>
    <meta property="product:price:amount" content="<?php echo str_replace(".",",",$price); ?>" />
    <meta property="product:price:currency" content="TND" />
    <meta property="og:availability" content="<?php echo isset($availability) ? $availability : 'in stock'; ?>" />
    <?php 
        }
    ?> 

    <?php if(isset($facebook_pixel) && $facebook_pixel != ''): ?>
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo $facebook_pixel; ?>');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo $facebook_pixel; ?>&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    <?php endif; ?>
    
    <!-- JSON-LD Structured Data: Organization -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?php echo isset($nom_site) ? htmlspecialchars($nom_site, ENT_QUOTES) : 'Technoplus'; ?>",
      "url": "<?php echo $chemin_absolu; ?>",
      "logo": "<?php echo $chemin_absolu; ?>media/site/<?php echo isset($logo) ? $logo : ''; ?>",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "<?php echo isset($tel) ? $tel : ''; ?>",
        "contactType": "customer service"
      }
    }
    </script>
    
    <!-- JSON-LD Structured Data: WebSite -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "<?php echo isset($nom_site) ? htmlspecialchars($nom_site, ENT_QUOTES) : 'Technoplus'; ?>",
      "url": "<?php echo $chemin_absolu; ?>"
      <?php if(isset($url_recherche)): ?>
      ,"potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo $chemin_absolu; ?>recherche.php?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
      <?php endif; ?>
    }
    </script>
    
    <?php if(isset($typeOg) && $typeOg == 'Product' && isset($price) && $price != "0.000"): ?>
    <!-- JSON-LD Structured Data: Product -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": "<?php echo isset($titre) ? htmlspecialchars($titre, ENT_QUOTES) : (isset($title_page) ? htmlspecialchars($title_page, ENT_QUOTES) : ''); ?>",
      "image": "<?php echo $og_img; ?>",
      "description": "<?php echo isset($description_page) ? htmlspecialchars($description_page, ENT_QUOTES) : ''; ?>",
      "sku": "<?php echo isset($id) ? $id : ''; ?>",
      "offers": {
        "@type": "Offer",
        "url": "<?php echo $og_url; ?>",
        "priceCurrency": "TND",
        "price": "<?php echo $price; ?>",
        "availability": "http://schema.org/<?php echo (isset($availability) && $availability == 'in stock') ? 'InStock' : 'OutOfStock'; ?>",
        "seller": {
          "@type": "Organization",
          "name": "<?php echo isset($nom_site) ? htmlspecialchars($nom_site, ENT_QUOTES) : 'Technoplus'; ?>"
        }
      }
    }
    </script>
    <?php endif; ?>
    