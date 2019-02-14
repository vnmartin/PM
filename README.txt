MyTCG PM Add-On version V 2.0 10/10/2014
Created by Nina
http://absolute-chaos.net
webmistress@absolute-chaos.net
Copyright 2014 Absolute-Chaos.Net
All rights reserved.

CONTENTS OF THIS FILE
---------------------
* General Usage Notes
* About
* Requirements
* Update
* Installation
* How to use
* Extra

GENERAL USAGE NOTES
--------------------
- You may not redistribute this script without permission.
- You may not claim this script as yours.
- You must link back if using the script.

ABOUT
-----
This is a private messaging script. That allows you to send messages between members.

REQUIREMENTS
------------
- MyTCG

UPDATE
------
With the update came a lot of changes. Before updating please back up all PM Script files. All pages in this script have been modified and will affect any changes you made on your current pages.
- New emoticons
- Styled pages. This is in a css file named pm.css You may edit this to change the colors to your PM Script.
- No Peak. This feature makes it so a person cannot view a message that is not theirs.
- Fixed admin panel. Error with messaging all members.
- Added 2 new pages. bbcode.php and bbcode_replace.php Do not edit these pages unless you know what you are doing.

INSTALLATION
------------
1. Upload the files in the mytcg folder into your mytcg folder. Upload the rest of the files either in your main folder or a sub directory of choice.

2. Direct your url to http://tcgurl/mytcg/install.php This will create the database for the friend script. Once completed please delete install.php

3. If you placed the files into a sub directory please go back and change the paths to the page to be sure that everything works appropriately. If you did not do this then you have successfully installed MyTCG Friends Add-On.

HOW TO USE
----------
Supply a link to the inbox.php outbox.php and send.php to your members. So they are able to send messages.

In the mytcg folder theres go to the inbox.php file there are links above on the page to your outbox.php message a single member and message all members.

Thank you for using my script! XD

EXTRA
-----
Display number of new messages script.
<?php
$count = mysql_query("SELECT * FROM private WHERE `read`='Unread' AND `person`='$row[name]'");
$num = mysql_num_rows($count);

if ($num == 1) {
  echo "<a href=/inbox.php style=\"color: red;\">$num Message</a>";
}
elseif ($num > 1) {
  echo "<a href=/inbox.php style=\"color: red;\">$num Messages</a>";
}
else {
echo "<a href=/inbox.php>$num Messages</a>";
}
?>

For more emoticons go to: http://hundone.deviantart.com/art/Pidgin-Old-Tango-Smilies-63215859