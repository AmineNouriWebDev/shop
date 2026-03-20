<?php
$connexion = mysqli_connect('localhost', 'root', '', 'shop');

$check = mysqli_query($connexion, "SHOW COLUMNS FROM `optimisation_seo` LIKE 'title_home'");
if(mysqli_num_rows($check) == 0) {
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `title_home` VARCHAR(255) NULL AFTER `id`");
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `description_home` TEXT NULL AFTER `title_home`");
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `keywords_home` TEXT NULL AFTER `description_home`");
    echo "Columns added to optimisation_seo.\n";
} else {
    echo "Columns already exist.\n";
}

$check2 = mysqli_query($connexion, "SHOW COLUMNS FROM `site_configuration` LIKE 'developer_comment'");
if(mysqli_num_rows($check2) == 0) {
    mysqli_query($connexion, "ALTER TABLE `site_configuration` ADD COLUMN `developer_comment` TEXT NULL AFTER `theme_color`");
    echo "developer_comment added to site_configuration.\n";
} else {
    echo "developer_comment already exists.\n";
}

// Insert Test Data
$update = "UPDATE `site_configuration` SET developer_comment='<!-- \n  ========================================\n  DEVELOPER INFORMATION \n  Website Developer : Mohamed Amine Nouri\n  Company : MaxSolving\n  ======================================== \n-->'";
mysqli_query($connexion, $update);

$update_home = "UPDATE `optimisation_seo` SET title_home='Technoplus | L expert de la téléphonie et High-tech en Tunisie'";
mysqli_query($connexion, $update_home);

echo "Test data inserted.\n";
?>
