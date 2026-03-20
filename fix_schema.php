<?php
$connexion = mysqli_connect('localhost', 'root', '', 'technopl_db');

$check = mysqli_query($connexion, "SHOW COLUMNS FROM `optimisation_seo` LIKE 'title_home'");
if(mysqli_num_rows($check) == 0) {
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `title_home` VARCHAR(255) NULL AFTER `id`");
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `description_home` TEXT NULL AFTER `title_home`");
    mysqli_query($connexion, "ALTER TABLE `optimisation_seo` ADD COLUMN `keywords_home` TEXT NULL AFTER `description_home`");
    echo "Columns added to optimisation_seo.\n";
    
    // Insert initial data if row doesn't exist
    $res = mysqli_query($connexion, "SELECT id FROM `optimisation_seo` LIMIT 1");
    if (mysqli_num_rows($res) == 0) {
        mysqli_query($connexion, "INSERT INTO `optimisation_seo` (`title_home`) VALUES ('Technoplus')");
    }
} else {
    echo "Columns already exist.\n";
}
?>
