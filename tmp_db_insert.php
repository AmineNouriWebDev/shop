<?php
include("connec.php");

$pages = [
    [
        'titre' => 'Politique de confidentialité',
        'link' => 'politique-de-confidentialite',
        'contenu' => '<h1>Politique de confidentialité</h1><p>Contenu à ajouter par l\'administration.</p>'
    ],
    [
        'titre' => 'Mentions Légales',
        'link' => 'mentions-legales',
        'contenu' => '<h1>Mentions Légales</h1><p>Contenu à ajouter par l\'administration.</p>'
    ],
    [
        'titre' => 'Politiques de retour',
        'link' => 'politiques-de-retour',
        'contenu' => '<h1>Politiques de retour</h1><p>Contenu à ajouter par l\'administration.</p>'
    ]
];

foreach ($pages as $p) {
    // Check if it already exists by link
    $res = mysqli_query($connexion, "SELECT id FROM site_menu WHERE link = '".$p['link']."'");
    if(mysqli_num_rows($res) == 0) {
        $q = "INSERT INTO site_menu (idparent, titre, link, contenu, etat, affichage_menu, affichage_footer) 
              VALUES (0, '".$p['titre']."', '".$p['link']."', '".mysqli_real_escape_string($connexion, $p['contenu'])."', 1, 0, 1)";
        mysqli_query($connexion, $q);
        echo "Inserted " . $p['titre'] . "<br>";
    } else {
        echo "Exists " . $p['titre'] . "<br>";
    }
}
?>
