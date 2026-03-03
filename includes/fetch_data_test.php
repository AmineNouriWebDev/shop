<?php 





session_start();



include("../include.php");

//include("../includes/script_panier.php");

 

if(isset($_POST["action"]) )

{



	

	$type_filter = $_POST["type"];

	$qty = "1";



	$output 	= '';

	

	if(isset($_POST["caracteristique"])){

	    $inreq =' , `caracteristique_prod` cp ';

	}else{

	   $inreq =''; 

	}

        

        if($type_filter !='' ){

	

		$query = "	SELECT DISTINCT pr.id, pr.link, pr.categorie FROM produits pr, categories_blog ctg ".$inreq." WHERE pr.etat = '1'"; //" AND pr.type='E'";

            

        }else{

	

		$query = "	SELECT DISTINCT pr.id, pr.link, pr.categorie FROM produits pr, categories_blog ctg ".$inreq." WHERE pr.etat = '1'"; //" AND pr.type='E' ";

            

        }

        

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

		if(isset($_POST["caracteristique"])){

        

            $caracteristiques = $_POST["caracteristique"];

            

            $query .= " AND ";

            

            //var_dump($_POST["caracteristique"]);

            

            foreach($caracteristiques as $caracteristique){

                

                $val = idvaleurCaracteristiques($caracteristique);

                $car = idcaracCaracteristiques($caracteristique);

                    		

                $query .= " ( cp.idproduit = pr.id  AND cp.valeur='".$val."' AND cp.idcarac = '".$car."') OR";

            

            }

            

            $query = rtrim($query,'OR');

                                

        }

		if(isset($_POST["search"]) && $_POST["search"]!= '' ){

        

            $search= str_replace (" "," ",$_POST["search"]);

                    		

            $query .= " AND ( pr.titre LIKE '%$search%' OR pr.link LIKE '%$search%' ) ";

                                

        }

		if(isset($_POST["marque"]) && $_POST["marque"]!= '' ){

        

            $search= idraisonMarque($_POST["marque"]);

                    		

            $query .= " AND ( pr.marque LIKE '%$search%' ) ";

                                

        }

            

        if(isset($_POST["categoryByTitre"]) && $_POST["categoryByTitre"]!= '' ){

            

            $ctg= $_POST["categoryByTitre"];

                        		

            $query .= " AND ( 

                            pr.categorie IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' || id = '".idBySearchCategBlog($ctg)."' ) 

                            OR  

                            pr.idparent_categ IN ( SELECT id FROM categories_blog WHERE idparent = '".idBySearchCategBlog($ctg)."' || id = '".idBySearchCategBlog($ctg)."' ) 

                        ) ";

                                     

        }

        if(isset($_POST["promo"]) && $_POST["promo"]!='')

    	{

    		$query .= "

    		 AND pr.prix_promo !='0.000'

    		";

    		

            if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))

        	{

        		$query .= "

        		 AND pr.prix_promo BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'

        		";

        	}

    	}else{

            if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))

        	{

        		$query .= "

        		 AND pr.prix_vente BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'

        		";

        	}

    	}

    	

    	if(isset($_POST["promo"]) && $_POST["promo"]!='')

    	{

		

		$query .=" GROUP BY pr.categorie ORDER BY pr.prix_promo ASC";

		

    	}else{

    	    

		$query .=" GROUP BY pr.id ORDER BY pr.prix_vente ASC";

    	    

    	}

        

        //echo $query;

		

		$result 	= executeRequete($query);

		

		$result2 	= executeRequete($query);

		

		$total_row 	= mysqli_num_rows($result);

		

		$total_row2 	= mysqli_num_rows($result2);
//echo $query;
		

		if($_POST['promo']){

		    

		if($total_row > 0)

		{

			

			$output .= '

				

					<div class="row">

						<div class="col-sm-12">

							<div class="product-topbar d-xl-flex align-items-end justify-content-between">

								<!-- Total Products -->

								<div class="total-products">';

								if(isset($_POST["promo"]) && $_POST["promo"]!='')

    	                        {}else{

								$output .= '<p> Il y a '.$total_row.' produits.</p>';

    	                        }

    	                        $output .= '

									<div class="view d-flex">

										<a href="javascript:void(0)" id="grid" class="active"><i class="fa fa-th-large" aria-hidden="true"></i></a>

										<a href="javascript:void(0)" id="list"><i class="fa fa-bars" aria-hidden="true"></i></a>

									</div>

								</div>

							</div>

						</div>

					</div>';

                

    			while($row11 = mysqli_fetch_array($result))

    			{

    			    $output .= '

    					<div class="animated fadeInUp list" data-delay="1s">';

    					$output .= '<div class="title my-4 p-3 bg-danger text-white font-weight-bold d-none">Sélection '.titreCategories(linkCategBlog(categorieProduits($row11['id']))).'</div>

    					

    					<div class="list-promo d-none">

    					<div class="row">

    					';

    			

                    	$query1 = "	SELECT DISTINCT id, link FROM produits WHERE etat = '1' AND categorie ='".$row11['categorie']."'"; //AND type='E'";

                            

                        if(isset($_POST["promo"]) && $_POST["promo"]!='')

                    	{

                    		$query1 .= "

                    		 AND prix_promo !='0.000'

                    		";

                    		

                            if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))

                        	{

                        		$query1 .= "

                        		 AND prix_promo BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'

                        		";

                        	}

                    	}

                    	

                    	if(isset($_POST["promo"]) && $_POST["promo"]!='')

                    	{

                		

                		$query1 .=" GROUP BY id ORDER BY prix_promo ASC";

                		

                    	}	

                    	

		

		                $result1 	= executeRequete($query1);

		                

            			while($row1 = mysqli_fetch_array($result1))

            			{

            				if($row1['id'])    $id_p    = $row1['id']; 

            				if($row1['link'])  $link_p  = $row1['link']; 

    				

    				

    				$output .= '

    				

    						

    						<div class="col-xs-12 d-block full-screen col-sm-12 mb-5">

    							<div class="single-product-wrapper h-wrapper d-flex align-items-center text-center">

    								<!-- Product Image -->

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom  bg-white px-3">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>

    								<!--a href=" lienProduits($row[link]) class="product-img">

    									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">

    								</a-->

    

    								<!-- Product Description -->

    								<div class="product-description d-flex mt-0 h-100 p-2 align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data" style="width: calc(100% - 300px);">

    									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">

    											<h6>'. titreProduits($id_p).'</h6>

    										</a>

    										<div class="line"></div>';

    										$output .= '<div class="text-left" style="font-size:12px">'./*tronquer(*/strip_tags(courtContenuProduits($id_p))/*,200)*/.'</div>';

    										

    									$output .='

    									</div>

    									<div class="bg-light rounded h-100 py-2" style="width:100px"> <!--h4 style="font-size: 14px;">Disponibilité</h4-->';

    									    if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        }

    								    $output .= '

    									</div>

    									<!-- Ratings & Cart -->

    									<div class="ratings-cart text-center" style="width:200px">';

    									    if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div style="height:60px;overflow:hidden;text-align:center"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="background: #fff;width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

        									

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

        									 

        									$output .= '<div class="d-flex align-items-center justify-content-center">

    										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>

    										</div>

    										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';

    								        } 

    										$output .='</div>

    										</div>

    									</div>

    								</div>

    							</div>

    						</div>';

    						

    				

    					$output .= '

    						<div class="col-xs-12 col-sm-12 d-none mobile-screen mb-5">

    						

    									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">

    											<h6>'. titreProduits($id_p).'</h6>

    										</a>

    										<div class="line"></div>';

    						$output .= '

    							<div class="single-product-wrapper h-wrapper d-flex align-items-center text-center">

    								<!-- Product Image -->

    								<div>

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom  bg-white px-3">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>';

    								if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        }

    								$output .= '

    								<div class="d-flex align-items-center justify-content-center">

    										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>

    										</div>

    										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';

    								        } 

    										$output .='</div>

    										</div>

    								</div>

    

    								<!-- Product Description -->

    								<div class="product-description d-flex mt-0 h-100 p-2 align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data" style="width: calc(100% - 300px);">';

    										$output .= '<div class="text-left" style="font-size:12px">'./*tronquer(*/strip_tags(courtContenuProduits($id_p))/*,200)*/.'</div>';

    										

    									$output .='

    									</div>

    									<!-- Ratings & Cart -->

    									<div class="ratings-cart text-center" style="width:200px">';

    									    if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div style="height:60px;overflow:hidden;text-align:center"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="background: #fff;width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

        									

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

        									 

        									$output.='

    									</div>

    								</div>

    							</div>

    						</div>';

            			}

                    $output.= '</div>

                    </div>

                    </div>';

    			}

    			

    

    		}

    		

    	

    	    if($total_row2 > 0)

    		{

    			

    

    			while($row22 = mysqli_fetch_array($result2))

    			{

    			

    			$output .= ' <div class="animated fadeInUp list-grid" data-delay="1s">';

    					$output .= '<div class="title my-4 p-3 bg-danger text-white d-block font-weight-bold">Sélection '.titreCategories(linkCategBlog(categorieProduits($row22['id']))).'</div>

    					

    					<div class="list-grid-promo d-block">

    					<div class="row">

    					';

    			

                    	$query3 = "	SELECT DISTINCT id, link FROM produits WHERE etat = '1' AND categorie ='".$row22['categorie']."'";

                            

                        if(isset($_POST["promo"]) && $_POST["promo"]!='')

                    	{

                    		$query3 .= "

                    		 AND prix_promo !='0.000'

                    		";

                    		

                            if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))

                        	{

                        		$query3 .= "

                        		 AND prix_promo BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'

                        		";

                        	}

                    	}

                    	

                    	if(isset($_POST["promo"]) && $_POST["promo"]!='')

                    	{

                		

                		$query3 .=" GROUP BY id ORDER BY prix_promo ASC";

                		

                    	}	

                    	

		                //echo $query3;

		                

		                $result3 	= executeRequete($query3);

		                

            			while($row3 = mysqli_fetch_array($result3))

            			{

            				if($row3['id'])    $id_p    = $row3['id']; 

            				if($row3['link'])  $link_p  = $row3['link']; 

            				

            				$output .= '

    				

    						

    						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-3 ">

    							<div class="single-product-wrapper border p-2 text-center hoverDiv">

    								<!-- Product Image -->

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>

    								<!--a href=" lienProduits($row[link]) class="product-img">

    									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">

    								</a-->

    

    								<!-- Product Description -->

    								<div class="product-description d-flex flex-column align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data">

    									    <a href="'. lienProduits($link_p).'">

    											<h6>'. titreProduits($id_p).'</h6>

    										</a>

    										<div class="line"></div>';

    										if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div style="height:60px;overflow:hidden"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

        									if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility m-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility m-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        } 

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price ">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

    										$output .= '

    									</div>

    									<!-- Ratings & Cart -->

    									<div class="ratings-cart d-flex w-100 justify-content-between">

    										<div class="cart">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="top"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>';

    								        } 

    										$output .= '		

    										</div>

    										<div class="cart" data-toggle="tooltip" data-placement="top" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline"><i class="fa fa-eye" style="color:#ababab"></i> Voir détails</a>

    										</div>

    									</div>

    								</div>

    							</div>

    						</div>';

    

    			    }

    			

                    $output.= '</div></div></div>';

    		    }

    

    		}

    		

    		if($total_row2 < 0 && $total_row < 0)

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

    						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucun produit trouvé </h5></div>

    				</div>';

    		}

		}else{

		    

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

    				

    						

    						<div class="col-xs-12 col-sm-12 list-element mb-5 list-group-item full-screen d-none">

    							<div class="single-product-wrapper h-wrapper d-flex align-items-center text-center">

    								<!-- Product Image -->

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom  bg-white px-3">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>

    								<!--a href=" lienProduits($row[link]) class="product-img">

    									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">

    								</a-->

    

    								<!-- Product Description -->

    								<div class="product-description d-flex mt-0 h-100 p-2 align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data" style="width: calc(100% - 300px);">

    									    <a href="'. lienProduits($link_p).'" class="text-left mb-3">

    											<h6>'. titreProduits($id_p).'</h6>

    										</a>

    										<div class="line"></div>';

    										$output .= '<div class="text-left" style="font-size:12px">'./*tronquer(*/strip_tags(courtContenuProduits($id_p))/*,200)*/.'</div>';

    										

    									$output .='

    									</div>

    									<div class="bg-light rounded h-100 py-2" style="width:100px"> <!--h4 style="font-size: 14px;">Disponibilité</h4-->';

    									    if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        }

    								    $output .= '

    									</div>

    									<!-- Ratings & Cart -->

    									<div class="ratings-cart text-center" style="width:200px">';

    									    if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div style="height:60px;overflow:hidden;text-align:center"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="background: #fff;width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

        									

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

        									 

        									$output .= '<div class="d-flex align-items-center justify-content-center">

    										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>

    										</div>

    										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';

    								        } 

    										$output .='</div>

    										</div>

    									</div>

    								</div>

    							</div>

    						</div>';

    						

    					$output .= '

    						<div class="col-xs-12 col-sm-12 list-element mb-2 list-group-item mobile-screen d-none">

    						

    						    <a href="'. lienProduits($link_p).'" class="text-left bg-light d-block p-2 mb-2">

    								<h6>'. titreProduits($id_p).'</h6>

    							</a>';

    						    

    						    $output .= '

    							<div class="single-product-wrapper  border-bottom h-wrapper d-flex align-items-center h-auto pb-2 text-center">

    								<!-- Product Image -->

    								<div style="max-width:180px">

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom w-auto bg-white px-1 border border-light rounded">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>';

    								if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility mb-0" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility mb-0" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        }

    								    

    								$output .= '

    								<div class="d-flex align-items-center justify-content-center">

    										<div class="cart text-center mx-2 border border-warning rounded bg-warning" style="width:50px;height:50px;" data-toggle="tooltip" data-placement="bottom" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline" style="padding:.75rem;color:#fff"><i class="fa fa-eye"></i></a>

    										</div>

    										<div class="cart text-center mx-2 border border-warning rounded bg-white" style="width:50px;height:50px;">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier" style="padding:.75rem"><img src="dist/img/cart.png" alt="" class="img-fluid"></button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="bottom"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: #ececec;opacity: 0.5;padding:.75rem" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid"></button> ';

    								        } 

    										$output .='</div>

    										</div>

    								</div>

    

    								<!-- Product Description -->

    								<div class="product-description d-flex mt-0 w-100 h-100 p-2 align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data text-left" >';

    									    if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div class="mb-2" style="height:60px;overflow:hidden;"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="background: #fff;width: 80px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

        									 

    										$output .= '<div class="text-left" style="font-size:12px">'.tronquer(strip_tags(courtContenuProduits($id_p)),500).'</div>';

    										

        									$output.='

    									</div>

    								</div>

    							</div>

    						</div>';

    

    			}

    			

                    $output.= '</div>';

    

    		}

    		

    	

    	    if($total_row2 > 0)

    		{

    			$output .= '

    

    					<div class="animated fadeInUp list-grid" data-delay="1s">';

    			while($row2 = mysqli_fetch_array($result2))

    			{

    				if($row2['id'])    $id_p    = $row2['id']; 

    				if($row2['link'])  $link_p  = $row2['link']; 

    				

    				

    				$output .= '

    				

    						

    						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-3 list-element-grid grid-group-item d-block">

    							<div class="single-product-wrapper border p-2 text-center hoverDiv">

    								<!-- Product Image -->

    								<a href="'. lienProduits($link_p).'" class="product-img hover-zoom">

    									<img src="'. photoProduitsSite($id_p).'" alt="" class="img-fluid">

    								</a>

    								<!--a href=" lienProduits($row[link]) class="product-img">

    									<img src=" photoEquipementsSite($row[id])" alt="" class="img-fluid">

    								</a-->

    

    								<!-- Product Description -->

    								<div class="product-description d-flex flex-column align-items-center justify-content-between">

    									<!-- Product Meta Data -->

    									<div class="product-meta-data">

    									    <a href="'. lienProduits($link_p).'">

    											<h6>'. titreProduits($id_p).'</h6>

    										</a>

    										<div class="line"></div>';

    										if(marquesProduits($id_p) != '0' && ApercuMarque(marquesProduits($id_p)) !='') { 

        									$output .= '<div style="height:60px;overflow:hidden"><img src="'.photoMarqueSite(marquesProduits($id_p)).'" class="img-fluid" style="width: 120px;height: -webkit-fill-available; object-fit: contain;"> </div>';

        									}

        									if (etatStockProduits($id_p) == '1'){  

                                            $output .= '    <p class="avaibility" style="color:#20d34a;font-size:14px;text-transform:uppercase"><i class="fa fa-circle"></i> En Stock</p>';

    								        }else{

                                            $output .= '    <p class="avaibility" style="color:#6b6b6b;font-size:14px;text-transform:uppercase"><i class="fa fa-circle rupture"></i> En Rupture</p>';

    								        } 

    										if(prixPromoProduits($id_p) != '0.000') { 

        									$output .= '<p class="product-price ">'.prixPromoProduits($id_p).' DT  <br/><span style="text-decoration:line-through;color:#aaa;font-size: 22px;">'.prixVenteProduits($id_p).' DT</span> </p>';

        									}else{

        									$output .= '<p class="product-price">'.prixVenteProduits($id_p).' DT </p>';

        									}

    										$output .= '

    									</div>

    									<!-- Ratings & Cart -->

    									<div class="ratings-cart d-flex w-100 justify-content-between">

    										<div class="cart">';

    										if (etatStockProduits($id_p) == '1'){  

                                            $output .= ' <button type="button" data-toggle="tooltip" data-placement="top"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" class="btn btn-primary-outline" title="Ajouter au panier"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>';

    								        }else{

                                            $output .= ' <button data-toggle="tooltip" data-placement="top"  onclick="addToCart(event, '.afficheChamp($id_p).','.$qty.')" style="background: unset;opacity: 0.5;" class="btn btn-primary-outline" disabled title="En rupture"><img src="dist/img/cart.png" alt="" class="img-fluid" width="15px"> Ajouter au panier</button>';

    								        } 

    										$output .= '		

    										</div>

    										<div class="cart" data-toggle="tooltip" data-placement="top" title="Détails produit">

    											<a href="'. lienProduits($link_p).'"  class="btn btn-primary-outline"><i class="fa fa-eye" style="color:#ababab"></i> Voir détails</a>

    										</div>

    									</div>

    								</div>

    							</div>

    						</div>';

    

    			}

    			

                    $output.= '</div>';

    

    		}

    		

    		if($total_row2 < 0 && $total_row < 0)

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

    						<div class="col-12 col-sm-12"><h5 class="text-center"> Aucun produit trouvé </h5></div>

    				</div>';

    		}

		    

		}

	

	

	

		echo $output;

}

?>



	

	<script type="text/javascript">

	

	$(document).ready(function(){



		var rowNumber = 4;

		var $post = $('.list-element');

		var $post2 = $('.list-element-grid');

		var fadeInSpeed = 500;



		// Add rows around posts

		for(var i = 0, length = $post.length; i < length; i += 4) {

			$post.slice(i, i+4).wrapAll('<div class="row clearfix"></div>');

		}

		// Add rows around posts

		for(var i = 0, length = $post2.length; i < length; i += 4) {

			$post2.slice(i, i+4).wrapAll('<div class="row clearfix"></div>');

		}



		// Add display container every 4 rows

		for(var i = 0, length = $post.length; i < length; i += rowNumber) {

			$post.parent().slice(i, i+rowNumber).wrapAll('<div class="postContainer"></div>');

		}

		// Add display container every 4 rows

		for(var i = 0, length = $post2.length; i < length; i += rowNumber) {

			$post2.parent().slice(i, i+rowNumber).wrapAll('<div class="postContainerGrid"></div>');

		}



		// Add more button

		$('.postContainer').each(function(){

			$(this).append('<div class="loadMore"><button type="button" id="loadMoreBtn" class="portfolio-more-btn d-none">Afficher plus de produits...</button></div>');

		});

		// Add more button

		$('.postContainerGrid').each(function(){

			$(this).append('<div class="loadMore"><button type="button" id="loadMoreBtn" class="portfolio-more-btn d-block">Afficher plus de produits...</button></div>');

		});

		

		// Hide last more button

		$('.postContainer').last().find('.loadMore').fadeOut(0);

		// Hide last more button

		$('.postContainerGrid').last().find('.loadMore').fadeOut(0);

		

		// Hide all posts containers except the first one

		$('.postContainer').not(":first").fadeOut(0);

		// Hide all posts containers except the first one

		$('.postContainerGrid').not(":first").fadeOut(0);

		

		// Display next posts container

		$('.list').on('click', '#loadMoreBtn', function(evt){

			evt.preventDefault();

			// Show next post container

			$(this).parents('.postContainer').next().fadeIn(fadeInSpeed);

			// Hide old button

			$(this).parent().fadeOut(0);

		});

		// Display next posts container

		$('.list-grid').on('click', '#loadMoreBtn', function(evt){

			evt.preventDefault();

			// Show next post container

			$(this).parents('.postContainerGrid').next().fadeIn(fadeInSpeed);

			// Hide old button

			$(this).parent().fadeOut(0);

		});

	});



    $(document).ready(function() {

        $('#list').click(function(event){

            event.preventDefault();

            $(this).addClass('active');

            $('#grid').removeClass('active');

            $('.postContainerGrid .grid-group-item').removeClass('d-block');

            $('.postContainerGrid .grid-group-item').addClass('d-none');

            $('.list-grid-promo').removeClass('d-block');

            $('.list-grid-promo').addClass('d-none');

            $('.postContainer .list-group-item').removeClass('d-none');

            $('.postContainer .list-group-item').addClass('d-block');

            $('.list .title').removeClass('d-none');

            $('.list .title').addClass('d-block');

            $('.list-grid .title').removeClass('d-block');

            $('.list-grid .title').addClass('d-none');

            $('.list-promo').removeClass('d-none');

            $('.list-promo').addClass('d-block');

            $('.postContainer .portfolio-more-btn').removeClass('d-none');

            $('.postContainer .portfolio-more-btn').addClass('d-block');

            $('.postContainerGrid .portfolio-more-btn').removeClass('d-block');

            $('.postContainerGrid .portfolio-more-btn').addClass('d-none');

        });

        $('#grid').click(function(event){

            event.preventDefault();

            $(this).addClass('active');

            $('#list').removeClass('active');

            $('.postContainer .list-group-item').removeClass('d-block');

            $('.postContainer .list-group-item').addClass('d-none');

            $('.list-grid-promo').removeClass('d-none');

            $('.list-grid-promo').addClass('d-block');

            $('.postContainerGrid .grid-group-item').removeClass('d-none');

            $('.postContainerGrid .grid-group-item').addClass('d-block');

            $('.list-promo').removeClass('d-block');

            $('.list-promo').addClass('d-none');

            $('.list-grid .title').removeClass('d-none');

            $('.list-grid .title').addClass('d-block');

            $('.list .title').removeClass('d-block');

            $('.list .title').addClass('d-none');

            $('.postContainerGrid .portfolio-more-btn').removeClass('d-none');

            $('.postContainerGrid .portfolio-more-btn').addClass('d-block');

            $('.postContainer .portfolio-more-btn').removeClass('d-block');

            $('.postContainer .portfolio-more-btn').addClass('d-none');

        });

    });

	</script>



    

    <script type="text/javascript">

		$(document).ready(function(){

		  $('[data-toggle="tooltip"]').tooltip();

		  function afficheGrid(x) {

              if (x.matches) { // If media query matches

                /*document.getElementById('list').style.display = 'none';

                $('#grid').addClass('active');

                $('.postContainer .list-group-item').removeClass('d-block');

                $('.postContainer .list-group-item').addClass('d-none');

                $('.postContainerGrid .grid-group-item').removeClass('d-none');

                $('.postContainerGrid .grid-group-item').addClass('d-block');

                $('.postContainerGrid .portfolio-more-btn').removeClass('d-none');

                $('.postContainerGrid .portfolio-more-btn').addClass('d-block');

                $('.postContainer .portfolio-more-btn').removeClass('d-block');

                $('.postContainer .portfolio-more-btn').addClass('d-none');*/

                

                document.getElementById('grid').style.display = 'none';

                $('#list').addClass('active');

                $('#grid').removeClass('active');

                $('.postContainerGrid .grid-group-item').removeClass('d-block');

                $('.postContainerGrid .grid-group-item').addClass('d-none');

                $('.postContainer .list-group-item').removeClass('d-none');

                $('.postContainer .list-group-item').addClass('d-block');

                $('.postContainer .portfolio-more-btn').removeClass('d-none');

                $('.postContainer .portfolio-more-btn').addClass('d-block');

                $('.postContainer .mobile-screen').addClass('d-block');

                $('.postContainerGrid .portfolio-more-btn').removeClass('d-block');

                $('.postContainer .full-screen').addClass('d-none');

                $('.postContainer .full-screen').removeClass('d-block');

                $('.postContainerGrid .portfolio-more-btn').addClass('d-none');

                

                

              } /*else {

                document.getElementById('list').style.display = 'block';

                $('#list').addClass('active');

                $('#grid').removeClass('active');

                $('.postContainerGrid .grid-group-item').removeClass('d-block');

                $('.postContainerGrid .grid-group-item').addClass('d-none');

                $('.postContainer .list-group-item').removeClass('d-none');

                $('.postContainer .list-group-item').addClass('d-block');

                $('.postContainer .portfolio-more-btn').removeClass('d-none');

                $('.postContainer .portfolio-more-btn').addClass('d-block');

                $('.postContainerGrid .portfolio-more-btn').removeClass('d-block');

                $('.postContainerGrid .portfolio-more-btn').addClass('d-none');

              }*/

            }

            

            var gr = window.matchMedia("(max-width: 992px)")

            afficheGrid(gr) // Call listener function at run time

            gr.addListener(afficheGrid) // Attach listener function on state changes

		});

	</script>



				




