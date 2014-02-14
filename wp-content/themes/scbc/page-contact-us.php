<?php
get_header(); 
?>
<div class="container">
    <div class="row row-offcanvas">
        <div class="col-xs-12 col-sm-6 bottom-sep" id="contact-form-container">
            <?php the_post(); the_content(); ?>
            <div class="visible-xs"></div>
        </div>
        <div class="col-xs-12 col-sm-6" id="map-container">
            <iframe width="100%" height="339" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?t=m&amp;q=574+field+street+manchester+ny&amp;ie=UTF8&amp;hq=&amp;hnear=574+Field+St,+Clifton+Springs,+Ontario,+New+York+14432&amp;z=11&amp;ll=43.040082,-77.152909&amp;output=embed"></iframe>
        </div>
        <div class="col-sm-3 visible-xs sidebar-offcanvas">
			<div class="sidebar">
				<div id="contact-container" class="nav-container">
					<ul id="contact-menu" class="nav">
						<li><a href="#contact-form-container">Contact Form</a></li>
						<li><a href="#map-container">Map</a></li>
					</ul>
				</div>
				<div class="like-container">
					<div class="clearfix">
						<a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><img class="facebook-icon" src="<?php echo get_facebook_icon_url(); ?>" alt="Space Craft Brewing Facebook Icon"/></a>
						<div>
							<a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><strong>Space Craft Brewing Company</strong></a><br />
							<div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php get_footer(); ?>