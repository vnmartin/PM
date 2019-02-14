<?php session_start(); if (isset($_SESSION['USR_LOGIN'])=="") { header("Location:/login.php"); } include("../header.php"); ?>
<?php
	if(!$_SERVER['QUERY_STRING']) { $select = $mysqli->query("SELECT * FROM members WHERE id = '$_SESSION[USER_ID]'"); while($row = $select->fetch_object()) { ?>
        <h1>Level Up</h1><div class="panel-body">
        <ol class="breadcrumb" style="text-align:center;">Congratulations on collecting enough cards to level up! Fill out the form below to receive your rewards.<br /><b>Please fill out one form for each level up!</b></ol>
<center>
		<form method="post" action="form_levelup.php?thanks" class="form">
		<input type="hidden" name="email" value="<?php echo $row->email; ?>" />
		<?php
		$level = $row->level;
		for($i=1; $i<=$num_lvlreg; $i++) {
			$randtype = 'regular';
			echo "<input type=\"hidden\" name=\"random$i\" value=\"";
			include ("random.php");
			echo "\" />\n";
		}
		if($num_lvlspc!=0) {
			for($i=1; $i<=$num_lvlspc; $i++) {
				$randtype = 'special';
				echo "<input type=\"hidden\" name=\"special$i\" value=\"";
					include ("random.php");
				echo "\" />\n";
			}
		}
		?>
		<label for="newlevel">New Level:</label> <select style="width: 50%;" name="newlevel" class="form-control">
		<?php
			echo "<option value=\""; echo ($level + 1); echo "\">"; echo ($level + 1); echo "</option>\n";
		?>
		</select>
        <label for="choice">Choice Card:</label>
		<?php
		for($i=1; $i<=$num_lvlchoice; $i++) {
			echo "<select style=\"width: 50%;\" name=\"choice$i\" class=\"form-control\">";
			echo "<option value=\"\">---</option>";
			$query = "SELECT * FROM `cards` WHERE masterable='Yes' AND released='Yes' ORDER BY filename ASC";
			$result = $mysqli->query($query);

			while($row2 = $result->fetch_object()) {
				$filename = stripslashes($row2->filename);
				$deckname = stripslashes($row2->deckname);
				echo "<option value=\"$filename\">$deckname ($filename)</option>";
			}
			echo "</select> <input style=\"width: 50%;\" type=\"text\" name=\"choicenum$i\" placeholder=\"00\" size=\"4\" maxlength=\"2\" class=\"form-control\" />";
		}
		?>
		<input type="submit" name="submit" value="Level Up!" class="btn btn-default" />
		</form>
	</center>
	</div>
		<?php } }
elseif($_SERVER['QUERY_STRING']=="thanks") {
	if(!empty($_POST['submit'])) {

			$id = htmlentities($mysqli->real_escape_string($_SESSION['USER_ID']));
			$name = htmlentities($mysqli->real_escape_string($_SESSION['USR_LOGIN']));
			$email = htmlentities($mysqli->real_escape_string($_POST['email']));
			$level = htmlentities($mysqli->real_escape_string($_POST['newlevel']));

			$update = "UPDATE members SET level='$level' WHERE id='$id'";
			$mysqli->query("INSERT INTO log (name, userid, reason, date) VALUES ('$_SESSION[USR_LOGIN]', '$_SESSION[USER_ID]', 'Level Up', '".time()."')");
			$mysqli->query("INSERT INTO `messages` (userid, username, subject, message, image, status, time) VALUES ('$_SESSION[USER_ID]', '$_SESSION[USR_LOGIN]', 'Level Up', 'leveled up to $level', '', '1', '".time()."')");

			$recipient = "$tcgemail";
			$subject = "Level Up Form";

			$message = "The following member has leveled up: \n";
			$message .= "Name: $name \n";
			$message .= "Email: $email \n";
			$message .= "New Level: $level \n";

			$headers = "From: $name <$email> \n";
			$headers .= "Reply-To: <$email>";

			$recipient2 = "$email";
			$subject2 = "$tcgname: Level Up Rewards";

			$message2 = "Congrats on leveling up to Level $level at $tcgname! Although you probably already picked up your rewards on the site, this copy has been sent to you as well in case you didn't or if you need to restore your card log.\n";
			for($i=1; $i<=$num_lvlchoice; $i++) {
				$card = "choice$i";
				$card2 = "choicenum$i";
				$message2 .= "$tcgcardurl";
				$message2 .= $_POST[$card];
				$message2 .= $_POST[$card2];
				$message2 .= ".$ext\n";
			}
			for($i=1; $i<=$num_lvlreg; $i++) {
				$card = "random$i";
				$message2 .= "$tcgcardurl";
				$message2 .= $_POST[$card];
				$message2 .= ".$ext\n";
			}
			if($num_lvlspc!=0) {
				for($i=1; $i<=$num_lvlspc; $i++) {
					$card = "special$i";
					$message2 .= "$tcgcardurl";
					$message2 .= $_POST[$card];
					$message2 .= ".$ext\n";
				}
			}
			$message2 .= "\nCongrats again and happy trading!\n";
			$message2 .= "-- $tcgowner\n";
			$message2 .= "$tcgname: $tcgurl\n";

			$headers2 = "From: $tcgname <$tcgemail> \n";
			$headers2 .= "Reply-To: <$tcgemail>";


			if (mail($recipient,$subject,$message,$headers)) {
				if($mysqli->query($update, $connect)) {
					mail($recipient2,$subject2,$message2,$headers2);



					?>
					<h3 class="panel-title">Congrats</h3></div><div class="panel-body">
					<div class="content">
					Congrats on leveling up, <?php echo $name; ?>! Here are your rewards. If you have leveled up more than once, please do not use the back button to fill out another form (you will receive the same random cards if you do). A copy of these rewards have been emailed to you.
					<br /><br />

					<center>
					<?php
					for($i=1; $i<=$num_lvlchoice; $i++) {
						$card = "choice$i";
						$card2 = "choicenum$i";
						echo "<img src=\"$tcgcardurl";
						echo $_POST[$card];
						echo $_POST[$card2];
						echo ".$ext\" />\n";
					}

					for($i=1; $i<=$num_lvlreg; $i++) {
						$card = "random$i";
						echo "<img src=\"$tcgcardurl";
						echo $_POST[$card];
						echo ".$ext\" />\n";
					}
					if($num_lvlspc!=0) {
						for($i=1; $i<=$num_lvlspc; $i++) {
							$card = "special$i";
							echo "<img src=\"$tcgcardurl";
							echo $_POST[$card];
							echo ".$ext\" />\n";
						}
					}
					?>
					</center>
					<br /><br />
					<b>Level Up:</b> <?php
					for($i=1; $i<=$num_lvlchoice; $i++) {
						$card = "choice$i";
						$card2 = "choicenum$i";
						echo $_POST[$card];
						echo $_POST[$card2];
						echo ", ";
						$choicelog = "choice$i";
						$choicelog1 = $_POST[$card2];
					}
					for($i=1; $i<=$num_lvlreg; $i++) {
						$card = "random$i";
						echo $_POST[$card];
						echo ", ";
					}
					if($num_lvlspc!=0) {
						for($i=1; $i<=$num_lvlspc; $i++) {
							$card = "special$i";
							echo $_POST[$card];
							echo ", ";
						}
					}
					echo " 20 <img src='images/coin.png'>";
				}
			}
			else { ?>
				<h3 class="panel-title">Error</h3></div><div class="panel-body">
				<div class="content">
				It looks like there was an error in processing your level up form. Send the information to <?php echo $tcgemail; ?> and we will send you your rewards ASAP. Thank you and sorry for the inconvenience.</div>
			<?php } } } ?>
<?php include("../footer.php"); ?>
