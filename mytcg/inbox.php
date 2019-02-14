<?php include("header.php");
require_once('settings.php'); 
?>
<link href="pm.css" rel="stylesheet">
<?php
if (isset($_SESSION["USER_ID"]))
{
$blog_postnumber = 25;

if(!isset($_GET['page'])) {
	$page = 1;
}
else {
	$page = (int)$_GET['page'];
}
$from = (($page * $blog_postnumber) - $blog_postnumber);

?>
<h1>View Messages: Inbox</h1>
<center><a href="inbox.php">Inbox</a> &#8226; <a href="outbox.php">Outbox</a> &#8226; <a href="send.php">Send a Message</a>
<table border=0 class="table-stripes" width="90%">
<tr><th width="50%">Subject</th><th width="15%">From</th><th width="15%">Sent on</th><th width="10%">Status</th><th width="10%">Delete?</th></tr>
<?php $select3 = mysql_query("SELECT * FROM private WHERE person='$tcgname' AND person_delete='No' ORDER BY id DESC LIMIT $from, $blog_postnumber");
while($row3=mysql_fetch_assoc($select3)) {
echo "<tr><td><a href=\"read.php?id=$row3[id]\">$row3[subject]</a></td>";
echo "<td>$row3[name]</td>";
echo "<td>$row3[date]</td>";
echo "<td align=center>$row3[read]</td>";
echo "<td align=center><a href=delete_inbox.php?id=$row3[id]><div style=\"color: red;\">&#x2716;</div></a></td></tr>";
}?>
</table>

<?php
$total_results = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM private WHERE person='$tcgname' AND person_delete='No';"));

$total_pages = ceil($total_results['num'] / $blog_postnumber);

$prev = ($page - 1); //the previous page

$next = ($page + 1); //the next page



if ($page > 1) echo "<a href=inbox.php?page=$prev><<  Previous</a> ";



// type out links to first 3 pages

$i = 1;

while($i <= 3 && $i <= $total_pages){

if ($page == $i) {

echo "$i ";

} else {

echo "<a href=inbox.php?page=$i>$i</a> ";

}

$i++;

}



if($total_pages > 3){

//i.e. there's a "gap" between 3 and $prev

if($prev > 4 ) echo ' ... ';



// the following ensures that  = page -1, page, page + 1  is always typed out

if( $prev >= 4 ) echo "<a href=inbox.php?page=". $prev .">".$prev ."</a> ";

if( $prev >= 3 && $next <= $total_pages) echo "$page ";

if( $next < $total_pages) echo "<a href=inbox.php?page=". $next .">". $next ."</a> ";



//i.e. there's a "gap" between $next and $total_pages

if( $next < $total_pages - 1) echo '...';



if($page == $total_pages) {

echo "$total_pages "; //don't link last page if it's also the current one

} else {

echo "<a href=inbox.php?page=$total_pages>$total_pages</a> ";

}

}


if ($page < $total_pages) echo "<a href=inbox.php?page=$next>Next >></a>";
?></center>
</td></tr>
</table>
<h1>Version</h1>
<?php
if (ini_get('allow_url_fopen') == '1') {
	$installed = file_get_contents('pm.txt');
	$version = file_get_contents('http://absolute-chaos.net/check/pm.txt');
	if ($version !== false) {
		if ($installed == $version) { //version numbers are the same
			echo "You are using PM Script version ".$installed.". That is the latest version.";
		}
		else if ($installed != $version) { //version numbers are not the same
			echo "<p>You are using PM Script version ".$installed.". Please update to <a href=\"http://www.absolute-chaos.net/scripts.php\" target=_blank>PM Script ".$version."</a>.";
		}
	}
	else {
		// an error happened
		echo "Could not check for updates. Please make sure you use the latest version of <a href=\"http://www.absolute-chaos.net/scripts.php\">PM Script</a>.";
	}
}
else {
   echo "Could not check for updates. Please make sure you use the latest version of <a href=\"http://www.absolute-chaos.net/scripts.php\">PM Script</a>.";
}
<?php } include("footer.php"); ?>