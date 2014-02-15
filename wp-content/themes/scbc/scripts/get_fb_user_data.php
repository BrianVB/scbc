<?php
ini_set('display_errors', 1);
include_once 'db_connect.php';

$accessToken = isset($_POST['accessToken']) ? mysql_real_escape_string($_POST['accessToken']) : '';
$expiresIn = isset($_POST['expiresIn']) ? mysql_real_escape_string($_POST['expiresIn']) : '';
$signedRequest = isset($_POST['signedRequest']) ? mysql_real_escape_string($_POST['signedRequest']) : '';
$userID = isset($_POST['userID']) ? mysql_real_escape_string($_POST['userID']) : '';
$fullJSON = isset($_POST['fullJSON']) ? mysql_real_escape_string($_POST['fullJSON']) : '';

$insert_user_sql = 'INSERT INTO scbc_fb_users SET'."\n".
		" accessToken='$accessToken', \n".
		" expiresIn='$expiresIn', \n".
		" signedRequest='$signedRequest', \n".
		" userID='$userID', \n".
		" fullJSON='$fullJSON', \n".
		" create_time=NOW(), \n".
		" update_time=NOW()";

$insert_user_query_result = mysql_query($insert_user_sql);

if(!$insert_user_query_result){
	mail('brian@spacebrews.com', 'failure to save a fb user', print_r($_POST, true));
	die('There was a problem inserting a new user: '.mysql_error());
}

?>