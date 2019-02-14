<?php require_once('settings.php'); 
include('header.php');

if(!$_SERVER['QUERY_STRING']) {

	$date = date("m/d/Y");
	?>
<link href="pm.css" rel="stylesheet">
<script language="javascript" type="text/javascript">
function addtext(text) {
     document.form.message.value += text;
 }
 </script>

	<h1>Message All Members</h1>
	Need to contact all of <?php echo $tcgname; ?>'s members? Use this form.
	<br /><br />
	<center><a href="inbox.php">Inbox</a> &#8226; <a href="outbox.php">Outbox</a> &#8226; <a href="msg_allmem.php">Message All Mem</a> &#8226; <a href="msg_mem.php">Message a Mem</a></center>
	<form method="post" action="msg_allmem.php?email">
		<input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
		<input type="hidden" name="name" id="name" value="<?php echo $tcgname; ?>"/>
		<input type="hidden" name="read" id="read" value="Unread"/>
	<table width=60%>
		<tr><td class="title" width=30%>Subject:</td><td class="cell" width=70%><input type="text" size="25" name="subject" id="subject" /></td></tr>
		<tr><td valign="top" class=title>Message:</td><a href="#" onclick="addtext('[b]TEXT HERE[/b]'); return false" class="bbc"><b>B</b></a>
<a href="#" onclick="addtext('[i]TEXT HERE[/i]'); return false" class="bbc"><i>I</i></a>
<a href="#" onclick="addtext('[u]TEXT HERE[/u]'); return false" class="bbc"><u>U</u></a><br>
<a href="#" onclick="addtext(':)'); return false"><img src="mytcg/img/smile.png" alt=":)" /></a>
<a href="#" onclick="addtext(':('); return false"><img src="mytcg/img/frown.png" alt=":(" /></a>
<a href="#" onclick="addtext(':x'); return false"><img src="mytcg/img/x.png" alt=":x" /></a>
<a href="#" onclick="addtext(';)'); return false"><img src="mytcg/img/wink.png" alt=";)" /></a>
<a href="#" onclick="addtext(':p'); return false"><img src="mytcg/img/tongue.png" alt=":P" /></a>
<a href="#" onclick="addtext(':o'); return false"><img src="mytcg/img/oh.png" alt=":o" /></a>
<a href="#" onclick="addtext(':heart:'); return false"><img src="mytcg/img/heart.png" alt=":heart:" /></a>
<a href="#" onclick="addtext('O.O'); return false"><img src="mytcg/img/eyes.png" alt="O.O" /></a>
<a href="#" onclick="addtext(':D'); return false"><img src="mytcg/img/grin.png" alt=":D" /></a>
<a href="#" onclick="addtext('-.-'); return false"><img src="mytcg/img/psh.png" alt="-.-" /></a><br><td class=cell><textarea name="message" rows="5" cols="50"></textarea></td></tr>
		<tr><td colspan=2 class=title><input type="submit" name="submit" value=" Send! " /></td></tr>
	</table>
	</form>
	<?php
}

elseif($_SERVER['QUERY_STRING']=="email") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
		exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
		$exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
		$profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
		$spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
		$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";
		
		if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
			exit("<h1>Error</h1>\nKnown spam bots are not allowed.<br /><br />");
			}
			foreach ($_POST as $key => $value) {
				$value = trim($value);
				if (empty($value)) {
					exit("<h1>Error</h1>\nEmpty fields are not allowed. Please go back and fill in the form properly.<br /><br />");
				}
				elseif (preg_match($exploits, $value)) {
					exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.<br /><br />");
				}
				elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
					exit("<h1>Error</h1>\nThat kind of language is not allowed through our form.<br /><br />");
				}
				
				$_POST[$key] = stripslashes(strip_tags($value));
			}
			$date = htmlspecialchars(strip_tags($_POST['date']));
			$name = htmlspecialchars(strip_tags($_POST['name']));
			$subject = htmlspecialchars(strip_tags(mysql_real_escape_string($_POST['subject'])));
			$read = htmlspecialchars(strip_tags($_POST['read']));
			$message = $_POST['message'];
			$message2 = nl2br($message);

		if (!get_magic_quotes_gpc()) {
			$name = addslashes($name);
			$message = addslashes($message);
		}
			?>
			
			<h1>Messaged</h1>
			Your message was sent to the following:<br />
			<?php
			$select=mysql_query("SELECT * FROM `$table_members` ORDER BY `name`");
			while($row=mysql_fetch_assoc($select)) {
			$person = $row[name];

			$result = "INSERT INTO private (`name`, `person`, `date`, `subject`, `message`, `read`) VALUES ('$name', '$person', '$date', '$subject', '$message2', '$read')";			
			if (mysql_query($result, $connect)) {
				echo "Success: $row[name]<br />\n";
			}
			else {
				echo "Failed: $row[name]<br />\n";
			}
			}
	}
}

include('footer.php'); ?>