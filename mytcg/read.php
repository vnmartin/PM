<?php include("header.php");
require_once('settings.php'); 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID specified.");
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM private WHERE id='$id' LIMIT 1";

if (isset($_SESSION["USER_ID"]))
{
$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
while($row=mysql_fetch_assoc($select)) {

$update = "UPDATE private SET `read`='Read' WHERE `id`='$id' LIMIT 1";
if (mysql_query($update, $connect)) {

$sql8 = mysql_query("SELECT * FROM private WHERE id='$id'");
$row4 = mysql_fetch_assoc($sql8);
$subject = $row4[subject];
$person = $row4[name];

?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="pm.css" rel="stylesheet">
<h1><?php echo $subject; ?></h1>
<table border=0 width=90%>
<tr><td align=center><a href="inbox.php">Inbox</a> &#8226; <a href="outbox.php">Outbox</a> &#8226; <a href="send.php">Send a Message</a>
</td></tr>
<tr><td valign=top>
<?php
$sql2 = "SELECT * FROM private WHERE id = '$id'";
$result2 = mysql_query ($sql2) or print ("Can't select message from table.<br />" . $sql . "<br />" . mysql_error());
while($row2 = mysql_fetch_array($result2)) {
include ("bbcode_replace.php");

$formatted_comment = str_replace($bbcode, $bbcode_replace, stripslashes($row2['message']));
$formatted_comment = str_replace($emoticons, $emoticons_replace, $formatted_comment);
    printf("<div style=\"float: left;\"><img src=/cards/mc-%s.png><br>%s</div>" . $formatted_comment . " ", stripslashes($row2['name']), stripslashes($row2['date']));
    printf("<br>");
}
?>
</td></tr>
</table>
<h1>Reply</h1>
<?php
	$date = date("m/d/Y");

?>
  <script language="javascript" type="text/javascript">
function addtext(text) {
     document.form.message.value += text;
 }
 </script>
<form method="post" name="form" action="reply.php">
<input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
<input type="hidden" name="name" id="name" value="<?php echo $row[name] ?>"/>
<input type="hidden" name="read" id="read" value="Unread"/>
<input type="hidden" name="person" id="person" value="<?php echo $person; ?>"/>
<center><table border="0" width=70%>
<tr><td align=center><input type="text" size="30" name="subject" id="subject" value="Re: <?php echo $subject; ?>"></td></tr>
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
<?php } } } else { echo "<B>Error</b>"; }

include("footer.php"); ?>