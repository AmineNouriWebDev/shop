<?php
/****** Categ ***/
function supprimerCategBlog($id){
	$requete = 'SELECT * FROM `categories_blog` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/blog/".nett($image));
    executeRequete("DELETE FROM `categories_blog` WHERE `id` = '". $id ."'");
    return true;
}

function linkCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}

function linkParentCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['idparent'] == 0){
	return linkCategBlog($data['id']);
	}else{
	return linkCategBlog($data['idparent']);
	}
}

function linkEnCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['linken']);
}
function typeCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['type']);
}
function idBySearchCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `link` = '".nett($id)."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}
function idparentCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['idparent']);
}

function idCategBlog($link)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['id']) ? afficheChamp($data['id']) : '';
}
function idEnCategBlog($link)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `linken` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}

function titreCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre']);
}
function titreCategories($link) 
{
	$requete = "SELECT * FROM `categories_blog` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre']);
}
function titreEnCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}
function photoCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/blog/'.afficheChamp($data['image']);
	} else { return ''; }
}

function ApercuCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}

function StatusCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function OrdreCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function etatCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function titre_pageCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre_page']);
}
function titre_pageEnCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre_pageen']);
}
function keywordsCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
function keywordsEnCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywordsen']);
}
function descriptionCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}
function descriptionEnCategBlog($id)
{
	$requete = "SELECT * FROM `categories_blog` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['descriptionen']);
}

/**** articles *****/
function supprimerArticle($id){
    $requete = 'SELECT * FROM `articles` WHERE `id` = "'.  $id.'"  ';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$photo 	= afficheChamp($data['photo']);
	unlink("../media/blog/".nett($photo));

    executeRequete("DELETE FROM `articles` WHERE `id` = '". $id ."'");
    return true;
}

function linkArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}
function idArticle($link)
{
	$requete = "SELECT * FROM `articles` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}
function titreArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function ContenuArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function ContenuCourtArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return tronquer(strip_tags($data['contenu']),150);
}

function CategArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}

function photoArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/blog/'.$data['photo'].'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/blog/indispo.jpg" border="0" width="60"  height="60" />';
	}
}
function photoArticleSite($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/blog/'.$data['photo'];
	}
}
function ApercuArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}
function DateArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['date']);
}
function OrdreArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function StatusArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function etatArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	} else{
	return '<img src="images/del.png" />';
	}
}
function titre_pageArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre_page']);
}
function descriptionArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}
function keywordsArticle($id)
{
	$requete = "SELECT * FROM `articles` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
?>