<?php include('header.php');
	$id=$_GET['id'];

		$update = "UPDATE private SET person_delete='Yes' WHERE id='$id'";

		if (mysql_query($update, $connect)) {
?>
          <h1>Success</h1>
<center>The message was successfully deleted.<br>
Go back to your <a href="inbox.php">inbox</a>?</center>
<?php		}
		else {
?><strong>Error</strong> 
<?php
			echo "There was an error and the message wasn't deleted.<br />\n";
			die("Error:". mysql_error());
?>
<?php
		}

include('footer.php'); ?>