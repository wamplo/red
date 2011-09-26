#!/usr/local/bin/php -q
<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

// read in email from stdin
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}

fclose($fd);

// handle email
$lines = explode("\n", $email);

// empty vars
$from = "";
$subject = "";
$headers = "";
$message = "";
$splittingheaders = true;
for ($i=0; $i < count($lines); $i++) {
    if ($splittingheaders) {
        // this is a header
        $headers .= $lines[$i]."\n";

        // look out for special headers
        if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
            $subject = $matches[1];
        }
        if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
            $from = $matches[1];
        }
        if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
            $to = $matches[1];
        }
    } else {
        // not a header, but message
        $message .= $lines[$i]."\n";
    }

    if (trim($lines[$i])=="") {
        // empty line, header section has ended
        $splittingheaders = false;
    }
}

$fheaders  = 'From: Netcoid <hermes-the-messenger@netcoid.com>; charset=UTF-8; Content-Type: text/html';

$fmessage = $message;
$fsubject = 'Re: ' . $subject;
$to = $from;
//send us the email to make sure it worked
// check xss dan utf 8 cpanel kalo edit
mail($to, $fsubject, $fmessage, $fheaders);
?>