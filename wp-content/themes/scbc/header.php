<?php
$page_title = scbc_get_the_title();
$page_description = scbc_get_the_meta_desc();
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $page_title; ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo auto_version('/wp-content/themes/scbc/css/normalize.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo auto_version('/wp-content/themes/scbc/css/bootstrap.min.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo auto_version('/wp-content/themes/scbc/style.css'); ?>" media="screen, projection" />
	<meta name="description" content="<?php echo $page_description; ?>" />
  	<meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID; ?>" />
  	<!-- <meta property="fb:page_id" content="246784288705094" /> -->
	<meta property="og:title"  content="<?php echo $page_title; ?>" />
	<meta property="og:description"  content="<?php echo $page_description; ?>" />
	<meta property="og:url"    content="<?php echo "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI']; ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script>
jQuery(document).ready(function($) {
	$.ajaxSetup({ cache: true });
	$.getScript('//connect.facebook.net/en_UK/all.js', function(){
		FB.init({
			appId: '<?php echo FACEBOOK_APP_ID; ?>',
			cookie : true,
			xfbml : true
		});     

		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') { // the user is logged in and has authenticated your app

			} else if (response.status === 'not_authorized') { // the user is logged in to Facebook, but has not authenticated your app

			} else { // the user isn't logged in to Facebook.
				$(".fb-like").html('This replaces like buttons for non-logged-into-fb users');
			}
		});


		FB.Event.subscribe('auth.authResponseChange', function(response) {
			if (response.status === 'connected') {
				$('#age-verification-modal').modal('hide');
			} else if (response.status === 'not_authorized') {
				
			} else {
				
			}
		});
	});
});

// Here we run a very simple test of the Graph API after login is successful. 
// This testAPI() function is only called in those cases. 
function testAPI() {
	console.log('Welcome!  Fetching your information.... ');
	FB.api('/me', function(response) {
		console.log('Good to see you, ' + response.name + '.');
	});
}
</script>
	<header>
	<?php if(is_front_page()): ?>
		<div class="container">	
			<a href="/"><img id="logo" src="/wp-content/themes/scbc/img/logo.png" alt="Space Craft Brewing Company" /></a>
			<div id="hr-1" class="logo-hr"></div>
			<div id="hr-2" class="logo-hr"></div>
			<h1 id="logo_text">Space Craft Brewing Co</h1>
			<div id="hr-3" class="logo-hr"></div>
			<div id="hr-4" class="logo-hr"></div>
		</div>
	<?php endif; ?>
		<div id="navigation">
			<div id="menu-main-navigation" class="container">
				<div class="row">
					<div class="col-xs-4 col-sm-2"><a href="/">Home</a></div>
					<div class="col-xs-4 col-sm-2"><a href="/about-us/">About</a></div>
					<div class="col-xs-4 col-sm-2"><a href="/beer/">Spacebrews</a></div>
					<div class="col-xs-4 col-sm-2"><a href="/merch/">Merch</a></div>
					<div class="col-xs-4 col-sm-2"><a href="/news/">News</a></div>
					<div class="col-xs-4 col-sm-2"><a href="/contact-us/">Contact</a></div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->