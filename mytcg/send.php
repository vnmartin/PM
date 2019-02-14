<?php include("header.php");
require_once('settings.php'); 

if (isset($_SESSION["USER_ID"]))
{
$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
while($row=mysql_fetch_assoc($select)) {
?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="pm.css" rel="stylesheet">
<h1>Send a Message</h1>
<table border=0 width=90%>
<tr><td align=center><a href="inbox.php">Inbox</a> &#8226; <a href="outbox.php">Outbox</a> &#8226; <a href="send.php">Send a Message</a>
</td></tr>
<tr><td valign=top>
<?php
	$date = date("m/d/Y");

?>
<script language="javascript" type="text/javascript">
function addtext(text) {
     document.form.message.value += text;
 }
 </script>
<form method="post" name="form" action="send2.php">
<input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
<input type="hidden" name="name" id="name" value="<?php echo $tcgname; ?>"/>
<input type="hidden" name="read" id="read" value="Unread"/>
<center><table border="0" width=70%>
<tr><td align=center><select name="person">
	<option value="">To:</option>
	<?php
	$query2="SELECT * FROM `$table_members` WHERE `name`!='$row[name]' ORDER BY name ASC";
	$result2=mysql_query($query2);

	while($row2=mysql_fetch_assoc($result2)) {
		$name2=stripslashes($row2['name']);
		echo "<option value=\"$name2\">$name2</option>\n";
	}
	?>
	</select></td></tr>
	<tr><td align=center><input type="text" size="25" name="subject" id="subject" placeholder="Subject"></td></tr>
<tr><td align=center><a class=box href="#" onclick="addtext('[b]TEXT HERE[/b]'); return false" class="bbc"><span class="fa fa-bold"></span></a>
<a class=box href="#" onclick="addtext('[i]TEXT HERE[/i]'); return false" class="bbc"><span class="fa fa-italic"></span></a>
<a class=box href="#" onclick="addtext('[u]TEXT HERE[/u]'); return false" class="bbc"><span class="fa fa-underline"></span></a>
<a class=box href="#" onclick="addtext('[url=URL HERE]TEXT HERE[/url]'); return false" class="bbc"><span class="fa fa-link"></span></a></td></tr>
<tr><td><?php include("bbcode.php"); ?></td></tr>
<tr><td align=center><textarea cols="50" rows="8" name="message" id="message"></textarea></td></tr>
<tr><td align=center><input type="submit" name="send" id="send" value="Send" /></td></tr></table>
</td>
</tr>
</table>
</form>
</center>
<?php } } include("footer.php"); ?>