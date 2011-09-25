#!/usr/bin/php
<?php
// read in email from stdin
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
$email .= fread($fd, 1024);
}
fclose($fd);
 
//send us the email to make sure it worked
mail('rama@networks.co.id','someone sent us an email at pipe@damnsemicolon.com',"Here is the the full email:\n\n$email");
?>