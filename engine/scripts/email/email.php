#!/usr/local/bin/php -q
<?php
// check atasnya penting! whm cpanel root kaya diatas
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
$email .= fread($fd, 1024);
}
fclose($fd);
 
// PARSE PARTS
$mime=new mime_parser_class;
$mime->ignore_syntax_errors = 1;
$parameters=array(
	'Data'=>$email,
);

$mime->Decode($parameters, $decoded);
$fromName = $decoded[0]['ExtractedAddresses']['from:'][0]['name'];
$fromEmail = $decoded[0]['ExtractedAddresses']['from:'][0]['address'];
$toEmail = $decoded[0]['ExtractedAddresses']['to:'][0]['address'];
$toName = $decoded[0]['ExtractedAddresses']['to:'][0]['name'];
$subject = $decoded[0]['Headers']['subject:'];
$removeChars = array('<','>');
$messageID = str_replace($removeChars,'',$decoded[0]['Headers']['message-id:']);
$replyToID = str_replace($removeChars,'',$decoded[0]['Headers']['in-reply-to:']);
//get the message body
if(substr($decoded[0]['Headers']['content-type:'],0,strlen('text/plain')) == 'text/plain' && isset($decoded[0]['Body'])){

	$body = $decoded[0]['Body'];

} elseif(substr($decoded[0]['Parts'][0]['Headers']['content-type:'],0,strlen('text/plain')) == 'text/plain' && isset($decoded[0]['Parts'][0]['Body'])) {

	$body = $decoded[0]['Parts'][0]['Body'];

} elseif(substr($decoded[0]['Parts'][0]['Parts'][0]['Headers']['content-type:'],0,strlen('text/plain')) == 'text/plain' && isset($decoded[0]['Parts'][0]['Parts'][0]['Body'])) {

	$body = $decoded[0]['Parts'][0]['Parts'][0]['Body'];

}

//send us the email to make sure it worked
$to      = 'rama@networks.co.id';
$subject = $subject;
$message = $body;
$headers = 'From: '. $toEmail . "\r\n" .
    'Reply-To: '. $toEmail . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
