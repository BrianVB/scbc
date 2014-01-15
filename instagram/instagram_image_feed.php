<?php
// --- This allow you to become subscribed to a user's updates
define('ACCSES_TOKEN','627033820.0dc1854.7d632257d0ec49b1b691ccae23075539'); // --- Get this after the user logs in and is successfully confirmed on your redirect_uri
define('USER_ID','627033820'); // --- You get this by succeeding with the instagram_subscribe.php page

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/'.USER_ID.'/media/recent/?access_token='.ACCSES_TOKEN.'&count=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result_raw = curl_exec($ch);

$result_decoded = json_decode($result_raw,true);
var_dump($result_decoded);
print_r($result_decoded);