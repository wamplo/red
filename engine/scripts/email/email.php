#/usr/local/lib/php –q
<?php
 
// read from stdin
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd))
{
	$email .= fread($fd, 1024);
}
fclose($fd);
 
 
mail('rama@networks.co.id','From my email pipe!','"' . $email . '"');
 
?>