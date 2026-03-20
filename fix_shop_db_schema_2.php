<?php
$connexion = mysqli_connect('localhost', 'root', '', 'shop');

// Ignore AFTER theme_color in case it doesn't exist locally
$check2 = mysqli_query($connexion, "SHOW COLUMNS FROM `site_configuration` LIKE 'developer_comment'");
if(mysqli_num_rows($check2) == 0) {
    mysqli_query($connexion, "ALTER TABLE `site_configuration` ADD COLUMN `developer_comment` TEXT NULL");
    echo "developer_comment added to site_configuration.\n";
} else {
    echo "developer_comment already exists.\n";
}

// Ensure theme_color exists so frontend doesn't crash elsewhere
$check3 = mysqli_query($connexion, "SHOW COLUMNS FROM `site_configuration` LIKE 'theme_color'");
if(mysqli_num_rows($check3) == 0) {
    mysqli_query($connexion, "ALTER TABLE `site_configuration` ADD COLUMN `theme_color` VARCHAR(20) DEFAULT '#ffffff'");
}

$update = "UPDATE `site_configuration` SET developer_comment='<!-- \n  ========================================\n  DEVELOPER INFORMATION \n  Website Developer : Mohamed Amine Nouri\n  Company : MaxSolving\n  ======================================== \n-->'";
mysqli_query($connexion, $update);
echo "Data applied.\n";
?>
