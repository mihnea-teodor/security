<?php
// The password
$passphrase = 'My secret';
 
// Turn a human readable passphrase
// into a reproducible iv/key pair
 
$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
$opts = array('iv'=>$iv, 'key'=>$key);
 
// Open the file
$fp = fopen('secret-file.enc', 'rb');
 
// Add the Mcrypt stream filter
// We use Triple DES here, but you
// can use other encryption algorithm here
stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);
 
// Read the file contents
fpassthru($content);
?>