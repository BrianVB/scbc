<?php
// --- This allow you to become subscribed to a user's updates

// --- Create the CURL request for the currently logged in user to allow a subscription of their items
$postfields = array(
	'client_id'=>'0dc18549a7804f55a9d16eff261d9416',
    'client_secret'=>'e74880a6551b4c1ab2ba7de302054117',
    'object'=>'user',
    'aspect'=>'media',
    'verify_token'=>'dummy',
    'callback_url'=>'http://beta.spacebrews.com/instagram_callback.php',
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/subscriptions/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
$result = curl_exec($ch);

echo $result;