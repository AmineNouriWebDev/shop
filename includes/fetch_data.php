<?php 


session_start();

include("../include.php");
include("../includes/script_panier.php");
 
if(isset($_POST["action"]) )
{

	
	$type_filter = $_POST["type"];
	$qty = "1";

	$output 	= '';
	
    if($type_filter == 'E' || $type_filter == 'A')
	{
		
		$query = "	SELECT DISTINCT pr.id, pr.link FROM produits pr, categories_blog ctg WHERE pr.etat = '1'";
        
		if(isset($_POST["link"]) && $_POST["link"]!= '' )
		{
			$link_filter =  $_POST["link"];
			$query .= "
			 AND pr.categorie ='".$link_filter."'
			";
		}
		if(isset($_POST["brand"]))
		{
			$brand_filter = implode("','", $_POST["brand"]);
			$query .= "
			 AND pr.marque IN('".$brand_filter."')
			";
		}
		if(isset($_POST["category"]))
		{
			$storage_filter = implode("','", $_POST["category"]);
			$query .= "
			 AND pr.categorie IN('".$storage_filter."')
			";
		}
		if(isset($_POST["search"]) && $_POST["search"]!= '' ){
        
            $search= url_rewrite($_POST["search"]);
                    		
            //$query .= " AND ( pr.titre LIKE '%$search%' OR pr.caracteristique LIKE '%$search%' OR pr.link LIKE '%$search%' OR ctg.titre LIKE '%$search%' OR ctg.link LIKE '%$search%') ";
            $query .= " AND ( pr.titre LIKE '%$search%' OR pr.link LIKE '%$search%' ) ";
                                
        }
		if(isset($_POST["caracteristique"]) && $_POST["caracteristique"]!= '' ){
        
            $caracteristique= url_rewrite($_POST["caracteristique"]);
                    		
            //$query .= " AND ( pr.titre LIKE '%$search%' OR pr.caracteristique LIKE '%$search%' OR pr.link LIKE '%$search%' OR ctg.titre LIKE '%$search%' OR ctg.link LIKE '%$search%') ";
            $query .= " AND ( pr.titre LIKE '%$caracteristique%' OR pr.link LIKE '%$caracteristique%' OR pr.caracteristique LIKE '%$caracteristique%' ) ";
                                
        }
            
        if(isset($_POST["categoryByTitre"]) && $_POST["categoryByTitre"]!= '' ){
            
                $ctg= $_POST["categoryByTitre"];
                        		
                //$query .= " AND ( ctg.titre LIKE '%$ctg%'  OR ctg.link LIKE '%$ctg%' OR  pr.idparent_categ = ctg.id OR pr.categorie = ctg.id AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' ) ) ) ";
                $query .= " AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' || id = '".idBySearchCategBlog($ctg)."' ) ) ";
                                     
        }
		
        if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
    	{
    		$query .= "
    		 AND pr.prix_vente BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
    		";
    	}
		
		$query .=" GROUP BY pr.id ORDER BY pr.prix_vente ASC";
		
		//echo $query; exit;

		$result 	= executeRequete($query);
		
		
		$total_row	= mysqli_num_rows($result);
		
		if($total_row > 0)
		{
			
			$output .= '
				
					<div class="row">
						<div class="col-sm-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a '.$total_row.' produits.</p>
									<div class="view d-flex">
										<a href="javascript:void(0)" id="grid" class="active"><i class="fa fa-th-large" aria-hidden="true"></i></a>
										<a href="javascript:void(0)" id="list"><i class="fa fa-bars" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>';
			$output .= '

					<div class="animated fadeInUp list" data-delay="1s">';
			while($row = mysqli_fetch_array($result))
			{
				if($row['id'])    $id_p    = $row['id']; 
				if($row['link'])  $link_p  = $row['link']; 
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 list-element list-group-item d-none">
							<div class="single-product-wrapper h-wrapper d-flex bg-light align-items-center text-center">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom bg-white px-3">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex mt-0 p-4 w-100 align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data" style="width: calc(100% - 300px);">
									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
										<div class="line"></div>';
										$output .= '<div class="text-left">'.tronquer(strip_tags(caracteristiqueProduits($id_p)),150).'</div>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-center" style="width:300px">';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
    									$output .= '<div class="d-flex align-items-center justify-content-center">
										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>
										</div>
										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';
								        } 
										$output .='
										    </div>
										</div>
									</div>
								</div>
							</div>
						</div>';
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 list-element grid-group-item d-block">
							<div class="single-product-wrapper border p-4 text-center hoverDiv">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data">
										<div class="line"></div>';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price text-left">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price text-left">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
										$output .= '<a href="'. lienProduits($link_p).'" class="text-left">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-right">
										<div class="cart text-center border-bottom"style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        } 
										$output .= '
										</div>
										<div class="cart text-center"style="width:50px;height:50px;" data-toggle="tooltip" data-placement="top" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#ababab"><i class="fa fa-eye"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>';

			}


			
            $output.= '</div>';

		}
		else
		{
				$output = '
				
					<div class="row">
						<div class="col-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a 0 produits.</p>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucun produit trouvée </h5></div>
				    </div>';
		}		
	}
	elseif($type_filter == 'E')
	{
	
		$query = "	SELECT DISTINCT pr.id, pr.link FROM produits pr, categories_blog ctg WHERE pr.etat = '1'  AND pr.type = 'E'";
        
		if(isset($_POST["link"]) && $_POST["link"]!= '' )
		{
			$link_filter =  $_POST["link"];
			$query .= "
			 AND pr.categorie ='".$link_filter."'
			";
		}
		if(isset($_POST["brand"]))
		{
			$brand_filter = implode("','", $_POST["brand"]);
			$query .= "
			 AND pr.marque IN('".$brand_filter."')
			";
		}
		if(isset($_POST["category"]))
		{
			$storage_filter = implode("','", $_POST["category"]);
			$query .= "
			 AND pr.categorie IN('".$storage_filter."')
			";
		}
		if(isset($_POST["search"]) && $_POST["search"]!= '' ){
        
            $search= url_rewrite($_POST["search"]);
                    		
            //$query .= " AND ( pr.titre LIKE '%$search%' OR pr.caracteristique LIKE '%$search%' OR pr.link LIKE '%$search%' OR ctg.titre LIKE '%$search%' OR ctg.link LIKE '%$search%') ";
            $query .= " AND ( pr.titre LIKE '%$search%' OR pr.link LIKE '%$search%' ) ";
                                
        }
            
        if(isset($_POST["categoryByTitre"]) && $_POST["categoryByTitre"]!= '' ){
            
                $ctg= $_POST["categoryByTitre"];
                        		
                //$query .= " AND ( ctg.titre LIKE '%$ctg%'  OR ctg.link LIKE '%$ctg%' OR  pr.idparent_categ = ctg.id OR pr.categorie = ctg.id AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' ) ) ) ";
                $query .= " AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' || id = '".idBySearchCategBlog($ctg)."' ) ) ";
                                     
        }
		
		$query .=" GROUP BY pr.id ORDER BY pr.prix_vente ASC";

		$result 	= executeRequete($query);
		
		$total_row 	= mysqli_num_rows($result);
		
		if($total_row > 0)
		{
			
			$output .= '
				
					<div class="row">
						<div class="col-sm-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a '.$total_row.' produits.</p>
									<div class="view d-flex">
										<a href="javascript:void(0)" id="grid"><i class="fa fa-th-large" aria-hidden="true"></i></a>
										<a href="javascript:void(0)" id="list" class="active"><i class="fa fa-bars" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>';
			$output .= '

					<div class="animated fadeInUp list" data-delay="1s">';
			while($row = mysqli_fetch_array($result))
			{
				if($row['id'])    $id_p    = $row['id']; 
				if($row['link'])  $link_p  = $row['link']; 
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 list-element list-group-item d-block">
							<div class="single-product-wrapper h-wrapper d-flex bg-light align-items-center border text-center hoverDiv">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom border-right  bg-white px-3">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex mt-0 p-4 w-100 align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data" style="width: calc(100% - 300px);">
									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
										<div class="line"></div>';
										$output .= '<div class="text-left">'.tronquer(strip_tags(caracteristiqueProduits($id_p)),150).'</div>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-center" style="width:300px">';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
    									$output .= '<div class="d-flex align-items-center justify-content-center">
										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>
										</div>
										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';
								        } 
										$output .='</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 list-element grid-group-item d-none">
							<div class="single-product-wrapper border p-4 text-center hoverDiv">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data">
										<div class="line"></div>';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price text-left">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price text-left">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
										$output .= '<a href="'. lienProduits($link_p).'" class="text-left">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-right">
										<div class="cart text-center border-bottom"style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        } 
										$output .= '
										</div>
										<div class="cart text-center"style="width:50px;height:50px;" data-toggle="tooltip" data-placement="top" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#ababab"><i class="fa fa-eye"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>';

			}
			
                $output.= '</div>';

		}
		else
		{
				$output = '
				
					<div class="row">
						<div class="col-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a 0 produits.</p>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucun équipement trouvé </h5></div>
				</div>';
		}
	
	
	}elseif($type_filter == 'A'){
		
		$query = " SELECT DISTINCT pr.id, pr.link FROM produits pr,categories_blog ctg WHERE pr.etat = '1'  AND pr.type = 'A'";
        
		if(isset($_POST["link"]) && $_POST["link"]!= '' )
		{
			$link_filter =  $_POST["link"];
			$query .= "
			 AND pr.categorie ='".$link_filter."'
			";
		}
		if(isset($_POST["brand"]))
		{
			$brand_filter = implode("','", $_POST["brand"]);
			$query .= "
			 AND pr.marque IN('".$brand_filter."')
			";
		}
		if(isset($_POST["category"]))
		{
			$storage_filter = implode("','", $_POST["category"]);
			$query .= "
			 AND pr.categorie IN('".$storage_filter."')
			";
		}
		if(isset($_POST["search"]) && $_POST["search"]!= '' ){
        
            $search= url_rewrite($_POST["search"]);
                    		
            //$query .= " AND ( pr.titre LIKE '%$search%' OR pr.caracteristique LIKE '%$search%' OR pr.link LIKE '%$search%' OR ctg.titre LIKE '%$search%' OR ctg.link LIKE '%$search%') ";
            $query .= " AND ( pr.titre LIKE '%$search%' OR pr.link LIKE '%$search%' ) ";
                                
        }
            
        if(isset($_POST["categoryByTitre"]) && $_POST["categoryByTitre"]!= '' ){
            
                $ctg= $_POST["categoryByTitre"];
                        		
                //$query .= " AND ( ctg.titre LIKE '%$ctg%'  OR ctg.link LIKE '%$ctg%' OR  pr.idparent_categ = ctg.id OR pr.categorie = ctg.id AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' ) ) ) ";
                $query .= " AND ( pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' || id = '".idBySearchCategBlog($ctg)."' ) ) ";
                                     
        }
		
		$query .=" GROUP BY pr.id ORDER BY pr.prix_vente ASC";

		$result 	= executeRequete($query);
		
		$total_row 	= mysqli_num_rows($result);
		
		if($total_row > 0)
		{
			
			$output .= '
				
					<div class="row">
						<div class="col-sm-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a '.$total_row.' produits.</p>
									<div class="view d-flex">
										<a href="javascript:void(0)" id="grid"><i class="fa fa-th-large" aria-hidden="true"></i></a>
										<a href="javascript:void(0)" id="list" class="active"><i class="fa fa-bars" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>';
			$output .= '

					<div class="animated fadeInUp list" data-delay="1s">'; 
			while($row = mysqli_fetch_array($result))
			{
				if($row['id'])    $id_p    = $row['id']; 
				if($row['link'])  $link_p  = $row['link']; 
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 list-element list-group-item d-block">
							<div class="single-product-wrapper h-wrapper d-flex bg-light align-items-center border text-center hoverDiv">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom border-right  bg-white px-3">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex mt-0 p-4 w-100 align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data" style="width: calc(100% - 300px);">
									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
										<div class="line"></div>';
										$output .= '<div class="text-left">'.tronquer(strip_tags(caracteristiqueProduits($id_p)),150).'</div>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-center" style="width:300px">';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
    									$output .= '<div class="d-flex align-items-center justify-content-center">
										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>
										</div>
										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';
								        } 
										$output .='</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
				
				$output .= '
				
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 list-element grid-group-item d-none">
							<div class="single-product-wrapper border p-4 text-center hoverDiv">
								<!-- Product Image -->
								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom">
									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">
								</a>
								<!--a href=" lienProduits($row[link]) class="product-img">
									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">
								</a-->

								<!-- Product Description -->
								<div class="product-description d-flex align-items-center justify-content-between">
									<!-- Product Meta Data -->
									<div class="product-meta-data">
										<div class="line"></div>';
										if(prixPromoProduits($id_p) != '0.000') { 
    									$output .= '<p class="product-price text-left">'.prixPromoProduits($id_p).' DT  <span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';
    									}else{
    									$output .= '<p class="product-price text-left">'.prixVenteProduits($id_p).' DT </p>';
    									}
    									if (etatStockProduits($id_p) == '1'){  
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';
								        }else{
                                        $output .= '    <p class="avaibility text-left m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';
								        } 
										$output .= '<a href="'. lienProduits($link_p).'" class="text-left">
											<h6>'. titreProduits($id_p).'</h6>
										</a>
									</div>
									<!-- Ratings & Cart -->
									<div class="ratings-cart text-right">
										<div class="cart text-center border-bottom"style="width:50px;height:50px;">';
										if (etatStockProduits($id_p) == '1'){  
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        }else{
                                        $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart('.afficheChamp($id_p).','.$qty.')" id="AddCart" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';
								        } 
										$output .= '
										</div>
										<div class="cart text-center"style="width:50px;height:50px;" data-toggle="tooltip" data-placement="top" title="Détails produit">
											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#ababab"><i class="fa fa-eye"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>';

			}
			
			$output.= '</div>';

		}
		else
		{
				$output = '
				
					<div class="row">
						<div class="col-12">
							<div class="product-topbar d-xl-flex align-items-end justify-content-between">
								<!-- Total Products -->
								<div class="total-products">
									<p> Il y a 0 produits.</p>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucune abonnement trouvée </h5></div>
				    </div>';
		}		
	}
	
	
		echo $output;
}
?>
	<div class="alert alert-success alert-dismissible mt-2" role="alert" id="myAlert" style="position: fixed; top: 0; right: 10px;z-index: 999999;display:none;">
		<img src="dist/img/cart.png" class="rounded mr-2" alt="...">
        <strong class="mr-auto"> Panier</strong>
		<hr>
		<p class="mb-0"> Succès ! votre produit à été ajouté au panier. <a href="cart.php" class="alert-link" style="font-size: 0.9rem;float: right;text-decoration: underline;">Voir votre panier</a></p>
		
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	
	<script type="text/javascript">
	
	$(document).ready(function(){

		var rowNumber = 3;
		var $post = $('.list-element');
		var fadeInSpeed = 500;

		// Add rows around posts
		for(var i = 0, length = $post.length; i < length; i += 6) {
			$post.slice(i, i+6).wrapAll('<div class="row clearfix"></div>');
		}

		// Add display container every 4 rows
		for(var i = 0, length = $post.length; i < length; i += rowNumber) {
			$post.parent().slice(i, i+rowNumber).wrapAll('<div class="postContainer"></div>');
		}

		// Add more button
		$('.postContainer').each(function(){
			$(this).append('<div class="loadMore"><button type="button" id="loadMoreBtn" class="portfolio-more-btn">Afficher plus de produits...</button></div>');
		});
		
		// Hide last more button
		$('.postContainer').last().find('.loadMore').fadeOut(0);
		
		// Hide all posts containers except the first one
		$('.postContainer').not(":first").fadeOut(0);
		
		// Display next posts container
		$('.list').on('click', '#loadMoreBtn', function(evt){
			evt.preventDefault();
			// Show next post container
			$(this).parents('.postContainer').next().fadeIn(fadeInSpeed);
			// Hide old button
			$(this).parent().fadeOut(0);
		});
	});

    $(document).ready(function() {
        $('#list').click(function(event){event.preventDefault();$(this).addClass('active'); $('#grid').removeClass('active'); $('.postContainer .grid-group-item').removeClass('d-block');$('.postContainer .grid-group-item').addClass('d-none');$('.postContainer .list-group-item').removeClass('d-none');$('.postContainer .list-group-item').addClass('d-block');});
        $('#grid').click(function(event){event.preventDefault();$(this).addClass('active'); $('#list').removeClass('active'); $('.postContainer .list-group-item').removeClass('d-block');$('.postContainer .list-group-item').addClass('d-none');$('.postContainer .grid-group-item').removeClass('d-none');$('.postContainer .grid-group-item').addClass('d-block');});
    });
	</script>

    
    <script type="text/javascript">
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();
		  function afficheGrid(x) {
              if (x.matches) { // If media query matches
                document.getElementById('list').style.display = 'none';
                $('#grid').addClass('active');
                $('.postContainer .list-group-item').removeClass('d-block');
                $('.postContainer .list-group-item').addClass('d-none');
                $('.postContainer .grid-group-item').removeClass('d-none');
                $('.postContainer .grid-group-item').addClass('d-block');
              } else {
                document.getElementById('list').style.display = 'block';
                $('#list').addClass('active');
                $('#grid').removeClass('active');
                $('.postContainer .grid-group-item').removeClass('d-block');
                $('.postContainer .grid-group-item').addClass('d-none');
                $('.postContainer .list-group-item').removeClass('d-none');
                $('.postContainer .list-group-item').addClass('d-block');
              }
            }
            
            var gr = window.matchMedia("(max-width: 992px)")
            afficheGrid(gr) // Call listener function at run time
            gr.addListener(afficheGrid) // Attach listener function on state changes
		});
	</script>

				

