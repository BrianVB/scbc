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
	<title><?php scbc_the_title(); ?></title>
	<meta name="description" content="<?php scbc_the_meta_desc(); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo auto_version('/wp-content/themes/scbc/css/bootstrap.min.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo auto_version('/wp-content/themes/scbc/style.css'); ?>" media="screen, projection" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header>
		<div class="container">	
			<a href="/"><img id="logo" src="/wp-content/themes/scbc/img/logo.png" alt="Space Craft Brewing Company" /></a>
			<div id="hr-1" class="logo-hr"></div>
			<div id="hr-2" class="logo-hr"></div>
			<h1 id="logo_text">Space Craft Brewing Co</h1>
			<div id="hr-3" class="logo-hr"></div>
			<div id="hr-4" class="logo-hr"></div>
		</div>
		<div id="navigation">
		<?php wp_nav_menu( array( 
			'theme_location' => 'header-menu',
			'sort_column' => 'menu_order',
			'container_class' => 'container',
			'fallback_cb' => 'menu_fallback' ,
			'menu_class' => 'clearfix'
		) ); ?>
		</div>	
	</header><!-- #masthead -->