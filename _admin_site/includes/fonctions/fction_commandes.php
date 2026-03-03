<?php
function numCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}
function code_envoiCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['code_envoi']);
}

function cmd_expressCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['cmd_express']);
}
function ref_paiementCommande($ref)
{
	$requete = "SELECT * FROM `commandes` WHERE `ref_paiement` = '".$ref."'";
	$resultat = executeRequete($requete);
	$numR = mysqli_num_rows($resultat);
	$data = mysqli_fetch_array($resultat);
	if($numR > 0 )
	return true;
	else
	return false;
}
function referencePaiementCommande($id) {
$car=6;
$string = "";
$chaine = "abcdefghijklmnpqrstuvwxy1234567890";
srand((double)microtime()*1000000);
for($i=0; $i<$car; $i++) {
$string .= $chaine[rand()%strlen($chaine)];
}
return $string."-".$id;
}
function dateCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return timestampTDtodate($data['date']);
}
function datePaiementCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['date_paiement']!='')
	return timestampTDtodate($data['date_paiement']);
}
function orderIdByRefCommande($ref)
{
	$requete = "SELECT * FROM `commandes` WHERE `ref_paiement` = '".$ref."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['id'];
}
function idclientCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['idclient'];
}
function notificationCommande($id)
{
	$requete = 'SELECT * FROM `historique_etat_commande` WHERE `id`="'.$id.'"';  

	$resultat = executeRequete($requete);

	$data = mysqli_fetch_array($resultat);
    
    if($data['notif_client'] == 0)
	    return "Non";
	else 
	    return 'Oui';
}
function fraisCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['frais_livraison'];
}
function adresseCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['adresse'] != '')
	return $data['adresse'];
	else
	return adresseClient(idclientCommande($data['id']));
}
function villeCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['ville'] != '')
	return $data['ville'];
	else
	return villeClient(idclientCommande($data['id']));
}
function cpCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['cp'] != '0')
	return $data['cp'];
	else
	return cpClient(idclientCommande($data['id']));
}
function telCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['tel'] != '')
	return $data['tel'];
	else
	return telClient(idclientCommande($data['id']));
}
function emailCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['email'] != '')
	return $data['email'];
	else
	return emailClient(idclientCommande($data['id']));
}

function clientCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['nom'] != '' || $data['prenom'] != '')
	return $data['nom'].' '.$data['prenom'].'<br/>'.emailCommande($id);
	else
	return nomClient($data['idclient']).' '. prenomClient($data['idclient']).'<br/>'.emailCommande($id);
}
function produitCommande($id)
{
	$requete = "SELECT * FROM `ligne_commande` WHERE `idcommande` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return titreProduits($data['id_produit']);
}
function qteCommande($id)
{
	$requete = "SELECT * FROM `ligne_commande` WHERE `idcommande` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['quantite']);
}
function soustotalCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['sous_total'])." TND";
}
function totalCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['total'])." TND";
}

function moyen_paiementCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['moyen_paiement']){
	    $idm = $data['moyen_paiement'];
	    $req = "SELECT * FROM `moyens_paiement` WHERE `id` = '".$idm."'";
    	$res = executeRequete($req);
    	$data1 = mysqli_fetch_array($res);
	
	    return afficheChamp($data1['moyen']);
	}
}

function totalCommandeNumerique($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['total']);
}
function etatCommande($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if (afficheChamp($data['etat']==1)) return "<span class='badge badge-primary'>".etat_commandes(1)."</span>";
	if (afficheChamp($data['etat']==2)) return "<span class='badge badge-success'>".etat_commandes(2)."</span>";
	if (afficheChamp($data['etat']==3)) return "<span class='badge badge-info'>".etat_commandes(3)."</span>";
	if (afficheChamp($data['etat']==4)) return "<span class='badge badge-danger'>".etat_commandes(4)."</span>";
	if (afficheChamp($data['etat']==8)) return "<span class='badge badge-danger'>".etat_commandes(8)."</span>";	
	if (afficheChamp($data['etat']==9)) return "<span class='badge badge-success'>".etat_commandes(9)."</span>";		
}
function detailsURLCommande($id)
{
	$requete_cmd = 'SELECT * FROM `ligne_commande` WHERE `idcommande`="'.$id.'"';  
	//echo $requete_cmd;
    $resultat_cmd = executeRequete($requete_cmd);
    $detailscmd ='';
    // $row_cmd =  mysqli_num_rows($resultat_cmd);
    while ($datacmd = mysqli_fetch_array($resultat_cmd))  {
            $detailscmd .=$datacmd['quantite']."x".produitCommande($datacmd['idcommande']);
    }
    return $detailscmd;
}
function detailsCommande($id)
{
	$requete_cmd = 'SELECT * FROM `ligne_commande` WHERE `idcommande`="'.$id.'"';  
	//echo $requete_cmd;
           $resultat_cmd = executeRequete($requete_cmd);
           //$row_cmd =  mysqli_num_rows($resultat_cmd);
           $detailscmd="<ul>";
           while ($datacmd = mysqli_fetch_array($resultat_cmd))  {
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Produit : </b>";
                $detailscmd.=qteCommande($datacmd['idcommande']).' x '.produitCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Date commande : </b>";
                $detailscmd.=dateCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Adresse commande : </b>";
                $detailscmd.=adresseCommande($datacmd['idcommande']).' '.cpCommande($datacmd['idcommande']).' ,'.villeCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Moyen paiement : </b>";
                $detailscmd.=moyen_paiementCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Etat commande : </b>";
                $detailscmd.=etatCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Sous total : </b>";
                $detailscmd.=soustotalCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Total : </b>";
                $detailscmd.=totalCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
          }
           $detailscmd.="</ul>";
          return $detailscmd;
}
function detailsPaiementCommande($id)
{
	$requete_cmd = 'SELECT * FROM `ligne_commande` WHERE `idcommande`="'.$id.'"';  
	//echo $requete_cmd;
           $resultat_cmd = executeRequete($requete_cmd);
           // $row_cmd =  mysqli_num_rows($resultat_cmd);
           $detailscmd="<ul>";
           while ($datacmd = mysqli_fetch_array($resultat_cmd))  {
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Produit : </b>";
                $detailscmd.=qteCommande($datacmd['idcommande']).' x '.produitCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Moyen paiement : </b>";
                $detailscmd.=moyen_paiementCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Date paiement : </b>";
                $detailscmd.=datePaiementCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Etat commande : </b>";
                $detailscmd.=etatCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
                $detailscmd.="<li style='list-style: inside; font-size:14px;margin-bottom:10px'> <b> Total : </b>";
                $detailscmd.=totalCommande($datacmd['idcommande']);
                $detailscmd.="</li>";
          }
           $detailscmd.="</ul>";
          return $detailscmd;
}
function BenificairesCommande($id)
{
	$requete_cmd = 'SELECT * FROM `ligne_commande` WHERE `idcommande`="'.$id.'"';  
	//echo $requete_cmd;
           $resultat_cmd = executeRequete($requete_cmd);
           $benefcmd="<ul>";
           $p=1;
           while ($datacmd = mysqli_fetch_array($resultat_cmd))  {
           	  $benefcmd.="<li>";
              // $benefcmd.="".afficheChamp($datacmd['nombenef'])."<br />";
              //$benefcmd.=''.afficheChamp($datacmd['telbenef']).'<br />';
              //$benefcmd.=''.afficheChamp($datacmd['emailbenef']).'<br />';
              $benefcmd.="</li>";
              //echo $p."".$benefcmd;
              $p++;

          }
           $benefcmd.="</ul>";
          return $benefcmd;
}



/************* etat commade ***********/
function etat_commandes($id)
{
    $requete = "SELECT * FROM `etat_commandes` WHERE `id` = '". $id ."'";
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['etat']);	
}
function supprimeretatcommande($id)
{
	executeRequete("DELETE FROM `etat_commandes` WHERE `id` = '". $id ."'");
    return true;
}
?>