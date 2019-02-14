<?php
include("settings.php");

if (isset($_POST['send'])) {

    if (empty($_POST['subject']) || empty($_POST['person']) || empty($_POST['message'])) {
        die("You have forgotten to fill in one of the required fields!.");
    }

    $date = htmlspecialchars(strip_tags($_POST['date']));
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $person = htmlspecialchars(strip_tags($_POST['person']));
    $subject = htmlspecialchars(strip_tags($_POST['subject']));
    $read = htmlspecialchars(strip_tags($_POST['read']));
    $message = $_POST['message'];
    $message = nl2br($message);

    if (!get_magic_quotes_gpc()) {
        $name = addslashes($name);
        $person = addslashes($person);
        $message = addslashes($message);
    }

    $result = "INSERT INTO private (`name`, `person`, `date`, `subject`, `message`, `read`, `name_delete`, `person_delete`) VALUES ('$name', '$person', '$date', '$subject', '$message', '$read', 'No', 'No')";
	mysql_query($result, $connect) or die(mysql_error());

    header("Location: outbox.php");
}
else {
    die("Error: you cannot access this page directly.");
}
?>