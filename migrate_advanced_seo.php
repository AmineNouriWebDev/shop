<?php
$c = mysqli_connect('localhost', 'root', '', 'technopl_db');

$queries = [
    "ALTER TABLE `optimisation_seo` ADD COLUMN `title_home` VARCHAR(255) NULL AFTER `id`",
    "ALTER TABLE `optimisation_seo` ADD COLUMN `description_home` TEXT NULL AFTER `title_home`",
    "ALTER TABLE `optimisation_seo` ADD COLUMN `keywords_home` TEXT NULL AFTER `description_home`",
    "ALTER TABLE `site_configuration` ADD COLUMN `developer_comment` TEXT NULL AFTER `theme_color`"
];

foreach ($queries as $query) {
    echo $query . " -> ";
    var_dump(mysqli_query($c, $query));
    echo "\n";
}
?>
