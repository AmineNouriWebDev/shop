    <?php 
        include("../include.php");

        $id_ml    = $_POST['mod_liv'];
        $nom_ml   = moyen_paiement($_POST['mod_liv']);
        $stotal  = $_POST['sous_total'];
        
            $req = "SELECT * FROM `frais_livraison` WHERE min < $stotal AND max > $stotal  ORDER BY `id`";
			$res = executeRequete($req);
			$numres = mysqli_num_rows($res);
			if($numres > 0){
			while ($data = mysqli_fetch_array($res))
			{
												
				$id=afficheChamp($data['id']);
				//echo $id;
                $cout_ml1 = valeurFraisLivraison($id);
                $cout_ml  = number_format($cout_ml1,3, ',', ' ').' DT';
                
                $cout = $cout_ml;
                $sous_total1 = $cout + $stotal;
                $sous_total  = number_format($sous_total1,3, ',', ' ').' DT';
                $total  = number_format($sous_total1,3, '.', ' ');
                
			}
			}else{
			    
    			$req1 = "SELECT * FROM `frais_livraison` WHERE min < $stotal AND max ='0'  ORDER BY `id`";
    			$res1 = executeRequete($req1);
    			$numres1 = mysqli_num_rows($res1);
    			if($numres1 > 0){
    			while ($data1 = mysqli_fetch_array($res1))
    			{
    												
    				$id1=afficheChamp($data1['id']);
                    $cout_ml1 = valeurFraisLivraison($id1);
                    $cout_ml  = number_format($cout_ml1,3, ',', ' ').' DT';
                    
                    $cout = 'Gratuit';
                    $sous_total1 = $cout + $stotal;
                    $sous_total  = number_format($sous_total1,3, ',', ' ').' DT';
                    $total  = number_format($sous_total1,3, '.', ' ');
                    
    			}
    			}
			    
			}
        
        
        
         $json = array();
         $json = array('id_ml'=>$id_ml,'nom_ml'=>$nom_ml,'cout_ml'=>$cout_ml1,'cout_ml_f'=>$cout,'sous_total'=>$sous_total,'total'=>$total); 
         echo json_encode($json); //Encode json    
    ?>