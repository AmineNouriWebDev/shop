    <?php 
        include("../include.php");

        $frais_livraison = $_POST['frais_livraison'];
        $stotal  = $_POST['sous_total'];
        $total  = $_POST['total'];
        
            
                    
                    $cout = 'Gratuit';
                    $cout_ml1 ='';
                    $total1 = $total - $frais_livraison;
                    $total  = number_format($total1,3, ',', ' ').' DT';
                    $totalF = number_format($total1,3, '.', ' ');
                    
        
        
         $json = array();
         $json = array('cout_ml'=>$cout_ml1,'cout_ml_f'=>$cout,'total'=>$totalF,'sous_total'=>$total); 
         echo json_encode($json); //Encode json    
    ?>