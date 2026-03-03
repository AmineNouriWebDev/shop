<?php
function executeRequete($requete)
{
	global $connexion;
	// Ensure connection exists (fallback if global is missing)
	if (!$connexion) {
		$conn=connexionBDD();
		$connexion = mysqli_connect($conn['serveur'],$conn['user_bdd'],$conn['user_pass'],$conn['name_bdd']);
		mysqli_set_charset($connexion, "utf8");
	}
	$resultat = mysqli_query($connexion,$requete) OR die(mysqli_error($connexion).' à la ligne '. __LINE__);
	return $resultat;
}
function ouvrirCnx()
{
	global $connexion;
	if (!$connexion) {
		$conn=connexionBDD();
		$connexion = mysqli_connect($conn['serveur'],$conn['user_bdd'],$conn['user_pass'],$conn['name_bdd']);
		mysqli_set_charset($connexion, "utf8");
	}
	return $connexion;
}

function afficheChamp($texte)
{
	if ($texte === null) return '';
	// Return text as-is in UTF-8 (no conversion needed)
	return $texte;
}
function afficheChamp1($texte)
{
	//$text=mb_convert_encoding($texte, 'UTF-8', 'ISO-8859-1');	
	return $texte;
}
function FormChampSpeciaux($texte)
{
	$text 	= htmlentities($texte );	
	return $text;
}

function formReception($texte)
{ 
	$texte = sanitize($texte);
	return $texte;
}
function formReception1($texte)
{ 
	$texte = mb_convert_encoding($texte, 'ISO-8859-1', 'UTF-8');
	return $texte;
}
function extraire($connexion,$requete)
{
     $resultat = mysqli_query($requete, $connexion);
     if ($resultat)
     {
          return $resultat;
     }
     else
     {
          echo '<br />Erreur dans la requête : '.$requete.' <br />';
          echo 'Message de MySQL : '.mysqli_errno($connexion) . ' <br />'.
               mysqli_error($connexion).' à la ligne : '.__LINE__;
		  exit();
     }
}
function afficheMaxOrdre($table, $ajoutOrdre = 3)
{
	$req = 'SELECT MAX(ordre) FROM `'.$table.'`';
	$res = executeRequete($req);
	$data = mysqli_fetch_row($res);
	$ajout = $data[0] + $ajoutOrdre ;

	return $ajout;
}
function auteur(){
$strSQL = "SELECT * FROM `editor` WHERE `ses_id`='".$_SESSION['sess_id']."'";
	$res = executeRequete($strSQL);
	$ligne = mysqli_fetch_array($res);
	if ($ligne && isset($ligne['editor_user_name'])) {
		return afficheChamp($ligne['editor_user_name']);
	}
	return '';
}
function auteur_id(){
$strSQL = "SELECT * FROM `editor` WHERE `ses_id`='".$_SESSION['sess_id']."'";
	$res = executeRequete($strSQL);
	$ligne = mysqli_fetch_array($res);
	if ($ligne && isset($ligne['editor_id'])) {
		return afficheChamp($ligne['editor_id']);
	}
	return '';
}

function auteur_name($id){
$strSQL = "SELECT * FROM `editor` WHERE `editor_id`='$id'";
	$res = executeRequete($strSQL);
	$ligne = mysqli_fetch_array($res);
	if ($ligne && isset($ligne['editor_user_name'])) {
		return afficheChamp($ligne['editor_user_name']);
	}
	return '';
}

function lister($connexion, $table, $nomchamp, $id)
{
     //écriture de la requete
     $requete = 'SELECT '.$nomchamp.', '.$id.' FROM '.$table.' ORDER BY '.$nomchamp.' ';

     //extraire la colonne
     $résultat = extraire($connexion, $requete);

     //affichage du composant HTML
     echo '<select name="'.$nomchamp.'">';
     echo '<option value="Choisir">';
     while($ligne = mysqli_fetch_object($resultat))
     {
          echo '<option value="'. $id .'">';
          echo $ligne->$nomchamp;
          echo '</option>';
     }
     echo '</select>';

     //pour libérer la mémoire
     mysqli_free_result($resultat);
}
function rewriteTitre($msg, $nombreMots = 7) {

	$msg = strtolower($msg);
	
	if ($nombreMots != 0)
	{
		$stringTab=explode(" ",$msg);  
		$NewString = ''; 
		/**/
		if ($nombreMots < count($stringTab) )
		{
			for($i=0;$i<$nombreMots;$i++)   
			{   
			  $NewString .= "$stringTab[$i]"." ";   
			}
		}
		else 
		{
			$NewString = $msg ;
		}
		$NewString = trim($NewString);
	}	
	else 
	{
		$NewString = trim($msg);
	}
	
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	$text = strtr($NewString,$tofind,$replac);
	
	$text = strtolower($text);
	
	$text = preg_replace('/[^a-zA-Z0-9]/', '-', $text);
	
	while (strstr($text, '--'))
		$text = str_replace('--', '-', $text);
	 
	return preg_replace('/-$/', '', $text);

	/*
	$destination = str_replace('é', 'e', $NewString);
	$destination = str_replace('è', 'e', $destination);
	$destination = str_replace('à', 'a', $destination);
	$destination = str_replace('ù', 'u', $destination);
	$destination = str_replace('ç', 'c', $destination);
	$destination = str_replace('ï', 'i', $destination);
	$destination = str_replace('"', '', $destination);
	$destination = str_replace('[', '', $destination);
	$destination = str_replace(']', '', $destination);
	$destination = str_replace('(', '', $destination);
	$destination = str_replace(')', '', $destination);
	$destination = str_replace('-', '-', $destination);
	$destination = str_replace('.', '', $destination);
	$destination = str_replace(' ', '-', $destination);
	$destination = str_replace(',', '', $destination);
	$destination = str_replace('?', '', $destination);
	$destination = str_replace('!', '', $destination);
	$destination = str_replace('*', 'X', $destination);
	$destination = str_replace('&', '', $destination);
	$destination = str_replace('=', '', $destination);
	$destination = str_replace('>', '', $destination);
	$destination = str_replace('<', '', $destination);
	$destination = str_replace('%', '', $destination);
	$destination = str_replace('$', 'Dollar', $destination);
	$destination = str_replace('£', 'Livre_Sterling', $destination);
	$destination = str_replace('€', 'Euro', $destination);
	$destination = str_replace('^', '', $destination);
	$destination = str_replace('|', '', $destination);
	$destination = str_replace('{', '', $destination);
	$destination = str_replace('²', '', $destination);
	$destination = str_replace('/', '', $destination);
	$destination = str_replace('\'', '', $destination);
	$destination = str_replace('\\', '', $destination);
	$destination = str_replace(':', '', $destination);
	
	return $destination;  
	*/ 
}

function emailAnnonce($idreponse) 
{
	$requete = "SELECT * FROM `reponses_annonces` WHERE `id` = '".$idreponse."'";
	//echo $requete;
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$ida 	= $data['idannonce'];
	$requete1 = "SELECT * FROM `annonces` WHERE `id` = '".$ida."'";
	//echo $requete1;
	$resultat1 = executeRequete($requete1);
	$data1 = mysqli_fetch_array($resultat1);
	$email 	= $data1['email'];
	return $email;
}

function alerter($from,$to,$sujet,$msg){
        $m= new Mail; // create the mail
		$m->From( $from );
		$m->To( $to );
		$m->Subject( $sujet );
		$m->Body( $msg);	// set the body
		$m->Priority(3) ;	// set the priority to Low 
		$m->Send();	// send the mail
}
?>