<?php
// --- This is the URL that will be hit when a subscribed user publishes media
$reqest_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

// --- This needs to be different based on whether or not it's a GET or POST request
switch($reqest_method){
	case 'GET': error_log('GET METHOD USED');
		// --- How Instagram knows that we are the authenticated people
		echo $_GET['hub_challenge'];
		break;
	case 'POST': error_log('POST METHOD USED');

		break;
}


error_log(print_r($_REQUEST, true));
error_log(print_r($_SERVER, true));
?>