<?php
get_header(); 
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 bottom-sep">
            <?php the_post(); the_content(); ?>
            <div class="visible-xs"></div>
        </div>
        <div class="col-xs-12 col-sm-6" id="map-container">
            <iframe width="100%" height="339" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?t=m&amp;q=574+field+street+manchester+ny&amp;ie=UTF8&amp;hq=&amp;hnear=574+Field+St,+Clifton+Springs,+Ontario,+New+York+14432&amp;z=11&amp;ll=43.040082,-77.152909&amp;output=embed"></iframe>
        </div>
    </div>
</div>
<?php get_footer(); ?>