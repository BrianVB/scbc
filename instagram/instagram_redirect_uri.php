<?php
// --- You have to be logged into Instagram on a website before you visit this page. 
// --- You can quickly get logged in by visiting a url of the following format: 
// --- https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=code

// --- This will show you your access token, which you can put as a constant in instagram_callback.php
// --- Create the CURL request for the currently logged in user to allow a subscription of their items
$postfields = array(
	'client_id'=>'0dc18549a7804f55a9d16eff261d9416',
    'client_secret'=>'e74880a6551b4c1ab2ba7de302054117',
    'grant_type'=>'authorization_code',
    'redirect_uri'=>'http://beta.spacebrews.com/instagram_redirect_uri.php',
    'code'=>$_GET['code'],
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/oauth/access_token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
$result = curl_exec($ch);

error_log($result);
echo $result;