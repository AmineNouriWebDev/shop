<?php

include('../../include.php');

if(isset($_POST['id_carac']) && !empty($_POST['id_carac'])) {
    
    $carac = explode(',',$_POST['id_carac']);
    
    //var_dump($id_carac);
    foreach( $carac as $id_carac){
?>


<?php
    $select3 = "SELECT * FROM `valeur_caracteristique` WHERE `idcarac` = '".$id_carac."' ORDER BY `id` ASC";
	//echo $select3;
	$result3 = executeRequete($select3);
    while($data3 = mysqli_fetch_array($result3)){
?>
    <option value="<?php echo $data3['id']; ?>"  <?php if(caracteristiques_val_prod($id_carac,$_GET['id'],$data3['id'])==true) echo "selected";?>><?php echo titreCaracteristiques($id_carac).' : '.$data3['valeur']; ?></option>
<?php
  }
        
    }
}
?>