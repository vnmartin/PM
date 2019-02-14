<?php 
include("settings.php");
include("header.php");

$connect = mysql_connect("$db_server", "$db_user", "$db_password");
mysql_select_db("$db_database", $connect);

$create_private = "CREATE TABLE `private` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `person` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `date` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `subject` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `message` longtext COLLATE latin1_general_ci NOT NULL,
  `read` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `name_delete` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `person_delete` varchar(3) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`))";

if (mysql_query($create_private, $connect)) {
   echo "The table was successfully created.<br />\n";
}
else {
   die("Error: ". mysql_error());
}
echo "For security purposes, please remove this file from your server!\n";

include("footer.php"); ?>
