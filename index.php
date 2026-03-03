<?php

include("include.php");
if (lienAccueil()) {
    $requete = "SELECT * FROM `site_menu` WHERE `link` = 'accueil' ";
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if ($data['id'] != "") {
        $id = afficheChamp($data['id']);
        $titre = afficheChamp($data['titre']);
        $contenu = afficheChamp($data['contenu']);
        $description_page = afficheChamp($data['description']);
        $title_page = afficheChamp($data['titre_page']);
        $keywords_page = afficheChamp($data['keywords']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('includes/script-header.php'); ?>
    <?php include('includes/script_panier.php'); ?>

</head>

<body>
    <?php include('includes/feedback.php'); ?>

    <?php include('includes/top-bar.php'); ?>

    <?php include('includes/header.php'); ?>

    <?php include('includes/contenu.php'); ?>

    <?php include('includes/footer.php'); ?>

    <?php include('includes/script-footer.php'); ?>

</body>

</html>