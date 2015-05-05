<?php

// Encryption technique from
// http://stackoverflow.com/questions/6833448/how-should-i-encrypt-my-data-in-a-php-application

require_once "config.php";
require_once "baker-lib.php";
require_once "util.php";

// echo("<pre>\n");var_dump($_SERVER);echo("</pre>\n");
$url = $_SERVER['REQUEST_URI'];
$pieces = explode('/',$url);
// echo("<pre>\n");var_dump($pieces);echo("</pre>\n");
$encrypted = basename($pieces[2],'.png');
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($PASSWORD), hex2bin($encrypted), MCRYPT_MODE_CBC, md5(md5($PASSWORD))), "\0");

// Make the badge
$file = 'badge-baker.png';
$png = file_get_contents($file);
$png2 = addOrReplaceTextInPng($png,"openbadges",curPageUrl()."/assert.php?id=".$encrypted);

header('Content-Type: image/png');
header('Content-Length: ' . strlen($png2));

echo($png2);
