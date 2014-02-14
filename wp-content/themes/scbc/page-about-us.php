<?php get_header(); ?>
<div class="container">
	<div class="row row-offcanvas">
		<div class="col-xs-12 col-sm-9">
			<?php the_post(); ?>
			<?php the_content(); ?>
		</div>
		<div class="col-sm-3 sidebar-offcanvas">
			<div class="sidebar">
				<div id="about-menu-container" class="nav-container">
					<ul id="about-menu" class="nav">
						<li><a href="#mission-heading">The Statement of Universal Intent</a></li>
						<li><a href="#origin-heading">The Origin</a></li>
					</ul>
				</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/scbc/inc/_facebook.php'; ?>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('body').scrollspy({ target: '#about-menu-container' });
	$(window).on('load', function () {
		$("body").scrollspy('refresh')
	});
});
</script>
