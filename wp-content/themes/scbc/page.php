<?php
get_header(); 
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="post" id="post-<?php the_ID(); ?>">
            
                <div class="entry">
                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
	<?php get_footer(); ?>