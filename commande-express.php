<?php 
session_start();
include("include.php");

//... Ton code inchangé jusqu'à :

if(isset($_POST['action']) && $_POST['action']=="cmd_express" ){
    
    $_SESSION['panier']['typeCMD'] = 'cmd_express';
    $moyen_livraison   = sanitize($_SESSION['shipping']);
    $moyen_paiement    = sanitize($_POST['paymentMethod']);
    $datec             = timestampTD(date("d/m/Y H:i:s"));
    $montant_globale   = str_replace(' ','',sanitize($_POST['soustotal']));
    $globale           = str_replace(' ','',sanitize($_POST['total']));
    $nom               = sanitize($_POST['nom']);
    $prenom            = sanitize($_POST['prenom']);
    $email             = sanitize($_POST['email']);
    $adresse           = sanitize($_POST['adresse']);
    $ville             = sanitize($_POST['ville']);
    $cp                = sanitize($_POST['cp']);
    $phone             = sanitize($_POST['tel']);
    $commentaire       = sanitize($_POST['commentaire']);
    $frais_livraison   = sanitize($_POST['frais_livraison']);
    $prod_cmd          = sanitize($_POST['prod_cmd']);
    $qte_cmd           = sanitize($_POST['qte_cmd']);
    $etat              = '1';
    $descriptionCmd    ='';

    $nbArticles=count($_SESSION['panier']['idcart']);
    if($nbArticles > 0){
        for ($i=0 ;$i < $nbArticles ; $i++) {
            $subGlobal = $montant_globale + $_SESSION['panier']['price'][$i];
            $subGlobal = str_replace(' ','',$subGlobal);
        }
    }else{
        $subGlobal = $montant_globale;
    }

    $requete = 'INSERT INTO `commandes` 
    ( `date`, `sous_total`, `total`, `moyen_paiement`,`frais_livraison`,`nom`,`prenom`,`email`, `adresse`, `ville`, `cp`, `tel`, `commentaire`,  `etat`,`cmd_express`) 
    VALUES
    ( "'. $datec .'", "'. $subGlobal .'", "'. $globale .'", "'. $moyen_paiement .'","'.$frais_livraison.'", "'. $nom .'","'. $prenom .'","'. $email .'","'. $adresse .'", "'. $ville .'", "'. $cp .'","'. $phone .'", "'. $commentaire .'", "'.$etat.'","'.$_SESSION['panier']['typeCMD'].'")';
    $connexion = ouvrirCnx() or die("erreur cnx");
    $resultat  = mysqli_query($connexion, $requete);    
    $id_cmd    = mysqli_insert_id($connexion);
    $nombre_cmd =  sprintf("%05d", $id_cmd);
    $code_cmd  = date("y").date("m").$nombre_cmd;

    $cmd = $id_cmd;

    $client = $nom.' '.$prenom;

    $headersMail  = 'MIME-Version: 1.0' . "\r\n";
    $headersMail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headersMail .= 'From:'.$nomSite.' <info@technoplus.tn>'. "\r\n";
    $sujet    = sujetEmail(9);
    $sujet    = str_replace('%%NCMD%%',$cmd,$sujet);
    $contenumsg =  messageEmail(9);
    $contenumsg =  str_replace('%%NOMCLT%%',$client,$contenumsg);
    $contenumsg =  str_replace('%%MNTCMD%%',totalCommande($cmd),$contenumsg);
    $contenumsg =  str_replace('%%DETAILSCMD%%',detailsCommande($cmd),$contenumsg);
    $contenumsg .= '<br/> Commentaire : '.$commentaire;
    mail($email_contact, $sujet, $contenumsg, $headersMail, "-f ".$email_contact."");

    $requete_cmd = 'UPDATE `commandes` set `code`="'.$code_cmd.'" WHERE `id`="'.$id_cmd.'"';
    $resultat_cmd = executeRequete($requete_cmd); 

    $totalLCMD = $qte_cmd * $montant_globale;

    $requete_ligneExp  =  "INSERT INTO `ligne_commande` 
    (`idcommande`, `id_produit`, `quantite`, `prix`, `prix_promo`, `total`, `etat`)
    VALUES
    ('". $id_cmd ."', '". $prod_cmd ."', '". $qte_cmd ."', '". $montant_globale ."', '". $montant_globale ."', '". $totalLCMD ."',  '".$etat."')";
    $resultat_ligneExp = executeRequete($requete_ligneExp);

    $descriptionCmd.=$qte_cmd.' x '.titreProduits($prod_cmd);

    $nbArticles=count($_SESSION['panier']['idcart']);
    if($nbArticles > 0){
        $total_globale ="";
        for ($i=0 ;$i < $nbArticles ; $i++) {
            if($_SESSION['panier']['promo'][$i]) {
                $prix1 = $_SESSION['panier']['promo'][$i];
                $totalProduit = $_SESSION['panier']['promo'][$i]*$_SESSION['panier']['qte_prd'][$i];
            } else {
                $prix1 = $_SESSION['panier']['price'][$i];
                $totalProduit = $_SESSION['panier']['price'][$i]*$_SESSION['panier']['qte_prd'][$i];
            }
            $prix  = $_SESSION['panier']['promo'][$i];
            $total = $_SESSION['panier']['qte_prd'][$i] * $prix1;

            $descriptionCmd .= $_SESSION['panier']['qte_prd'][$i].' x '.titreProduits($_SESSION['panier']['idcart'][$i]);

            $total_globale = $total_globale + $total;

            $requete_ligne  =  "INSERT INTO `ligne_commande` 
            (`idcommande`, `id_produit`, `quantite`, `prix`, `prix_promo`, `total`, `etat`)
            VALUES
            ('". $id_cmd ."', '". $_SESSION['panier']['idcart'][$i] ."', '". $_SESSION['panier']['qte_prd'][$i] ."', '". $_SESSION['panier']['price'][$i] ."', '". $_SESSION['panier']['promo'][$i] ."', '". $totalProduit ."',  '".$etat."')";
            $resultat_ligne = executeRequete($requete_ligne);

            $quantite_produit = quantiteProduits($_SESSION['panier']['idcart'][$i])-$_SESSION['panier']['qte_prd'][$i];

            $requete2 = 'UPDATE `produits` set `quantite`="'. $quantite_produit .'" WHERE `id`="'.$_SESSION['panier']['idcart'][$i].'"';
            $result2  = executeRequete($requete2);
        } 
    }

    // Gestion des modes de paiement
    if($moyen_paiement == 10){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
        $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express Paiement en ligne:".$urlOg);
        
        // ... Partie paiement en ligne (commentée) ...

    }

    if($moyen_paiement == 11){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
        $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express / Paiement D17:".$urlOg);
    }

    if($moyen_paiement == 12){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
        $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express / Paiement Paypal:".$urlOg);
    }

    // *** Ajout Western Union ***
    if($moyen_paiement == 13){
        $urlOg .= $descriptionCmd;
        $urlOg = rtrim($urlOg," / ");
        $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode("Commande Express / Paiement Western Union : ".$urlOg);
    }

    $msg="Votre commande a été bien enregistrée.";

    unset($_SESSION['panier']);
    
    // Ouvrir la fenêtre selon le mode de paiement (10,11,12,13)
    if($moyen_paiement == 10 || $moyen_paiement == 11 || $moyen_paiement == 12 || $moyen_paiement == 13){
    ?>
        <script language="javascript
