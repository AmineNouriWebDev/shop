<?php
$conn = mysqli_connect('localhost', 'root', '', 'shop');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$sql1 = "CREATE TABLE IF NOT EXISTS `conf_kits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT '0',
  `etat` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$sql2 = "CREATE TABLE IF NOT EXISTS `conf_etapes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kit` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `ordre` int(11) DEFAULT '0',
  `choix_multiple` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

mysqli_query($conn, $sql1);
mysqli_query($conn, $sql2);

mysqli_query($conn, "TRUNCATE TABLE conf_kits");
mysqli_query($conn, "TRUNCATE TABLE conf_etapes");

mysqli_query($conn, "INSERT INTO `conf_kits` (`id`, `titre`, `description`, `ordre`, `etat`) VALUES (1, 'Système Filaire (DVR/NVR)', 'Kit complet avec enregistreur, disque dur et caméras filaires', 1, 1)");
mysqli_query($conn, "INSERT INTO `conf_kits` (`id`, `titre`, `description`, `ordre`, `etat`) VALUES (2, 'Caméra WiFi (Sans fil)', 'Caméras autonomes avec carte mémoire', 2, 1)");

echo "Tables created.";
?>
