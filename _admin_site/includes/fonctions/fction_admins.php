<?php
function supprimerAdmin($id){
$requete = 'SELECT * FROM `editor`';
	$res = executeRequete($requete);
	$nb = mysqli_num_rows($res);
	if($nb==1){
	 echo '<script language="javascript">alert(\'Impossible de supprimer cet administrateur\');
	</script>';
	 return false;
	 }
	 else{
	executeRequete("DELETE FROM `editor` WHERE `editor_id` = '". $id ."'");
	return true;
	}
}
function societeClient($id)
{
	$requete = 'SELECT * FROM `editor` WHERE `editor_group`=2 and `editor_id` = "'. $id .'"';
	$res = executeRequete($requete);
	
	$data = mysqli_fetch_array($res);
	return strtoupper(afficheChamp($data['company']));
}
function nomSocieteClient($id)
{
	$requete = 'SELECT * FROM `editor` WHERE `editor_group`=2 and `editor_id` = "'. $id .'"';
	//echo $requete;
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	if(afficheChamp($data['company'])!='') return strtoupper(afficheChamp($data['company']));
	else return afficheChamp($data['editor_name']." ".$data['editor_surname']);
}
function derniereConnexionAdmin($id){
	$requete = 'SELECT * FROM `editor_state` WHERE `editor_id` = "'. $id .'" ORDER BY entree DESC ';
	//echo $requete;
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	if(afficheChamp($data['entree'])!='') return afficheChamp(date("d-m-Y H:i",$data['entree']));
	
}
function emailClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
if($data['editor_email'] != "") return $data['editor_email'];
}
function nomClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
 $res = executeRequete($req);
$data = mysqli_fetch_array($res);
if($data['editor_name'] != "") return strtoupper($data['editor_name']);
 
}
function prenomClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
if($data['editor_surname'] != "") return ucfirst($data['editor_surname']);
}
function loginClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
if($data['editor_user_name'] != "") return $data['editor_user_name'];
}
function mpClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
if($data['mdp'] != "") return $data['mdp'];
}
/*
function emailClt($idclient){
$req = "SELECT * FROM `editor` WHERE `editor_id`='".$idclient."'";
echo "ok2"; exit;
$res = executeRequete($req);
$data = mysql_fetch_array($res);
if($data['editor_email'] != "") return $data['editor_email'];
}
function alerterEmailClient($type,$idclient,$idcampagne){
	if(emailClt($idclient)!="") {
		$email=emailClt($idclient);
		if($type=="1"){ // creation nouvelle campagne
			$sujet = "Nouvelle campagne: ".campagne($idcampagne)."";
			$message = "Bonjour,<br />
			La campagne ".campagne($idcampagne)." est créé sur votre compte client.<br /><br />
			L'équipe ONLYTECH.TN";
			$destinataire = "'".$email."'";
			$headers = "From: \"ONLYTECH\"<contact@onlytech.tn>\n";
			$headers .= "Reply-To: contact@onlytech.tn\n";
			$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
			if(mail($destinataire,$sujet,$message,$headers))
			{
			return true;
			}
		} 
		echo "ok"; 
		//exit;
		
	//}
}
*/
?>