<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../connec.php");
include("includes/fonctions/fction_db.php");

$q_cat = "
    SELECT p_ctg.titre as categorie, ctg.titre as sous_categorie, COUNT(pr.id) as cnt
    FROM produits pr
    LEFT JOIN categories_blog ctg ON pr.categorie = ctg.id
    LEFT JOIN categories_blog p_ctg ON pr.idparent_categ = p_ctg.id
    GROUP BY pr.idparent_categ, pr.categorie
    ORDER BY p_ctg.titre, ctg.titre
";

$res = executeRequete($q_cat);
if (!$res) {
    echo "MySQL Error: " . mysqli_error(ouvrirCnx());
} else {
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
?>
