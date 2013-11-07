<?php
/**
* @package SpaceCraftBrewingCompany
* @subpackage SCNCWP
*/

/**
Register the Sidebars
*/
if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
		'name' => 'Beer Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'Post Sidebar',						   
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'Blog Sidebar',						   
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}
/**
	End Registering the Sidebars
*/


/*************************************************
	Create a custom post type for our delicous beers!
****************************************************************/

add_action('init', 'register_brews');
function register_brews(){
  $labels = array(
    'name' => _x('Brews', 'post type general name'),
    'singular_name' => _x('Brew', 'post type singular name'),
	'add_new' => _x( 'Add New', 'add' ),
	'add_new_item' => __( 'Add New Brew' ),
	'edit_item' => __( 'Edit Brew' ),
	'new_item' => __( 'New Brew' ),
	'view_item' => __( 'View Brew' ),
	'search_items' => __( 'Search Brews' ),
	'not_found' =>  __( 'No Brew Found' ),
	'not_found_in_trash' => __( 'No Brew Found in trash' ),
	'parent_item_colon' => ''    
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => true,
	'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'excerpt','comments'),
    'menu_position' => 20,
	'register_meta_box_cb' => 'add_brew_metaboxes',
	'taxonomies' => array('hops')
  ); 
  register_post_type('brew',$args);
}
// --- add the meta box for the abv to the brews
function add_brew_metaboxes() {
    add_meta_box('brew_meta', 'Alcohol by volume', 'brew_meta_html', 'brew', 'advanced', 'high');
}

// --- Put form html into the abv meta box
function brew_meta_html() {
    global $post;
 
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="meta_noncename" id="meta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
    // Get the abv data if its already been entered
    $abv = get_post_meta($post->ID, '_abv', true);
 
    // Echo out the field
    echo '<input type="text" name="_abv" value="' . $abv  . '" class="widefat" placeholder="e.g. &ldquo;7.5&rdquo;" />';

}


add_action('save_post', 'save_brew_meta', 1, 2); // save the custom fields
// Save the abv 
function save_brew_meta($post_id, $post) {
  if($post->post_type == 'brew'){ // --- Only run this if we're saving a brew
    // --- verify
    if ( !wp_verify_nonce( $_POST['brew_noncename'], plugin_basename(__FILE__) )) {
		  wp_die('This brew was not processed properly.');
    }
 
    // --- authorized?
    if ( !current_user_can( 'edit_post', $post->ID )){
      wp_die('You do not have permissions to do that.');
    }

    $brew_meta['_abv'] = $_POST['_abv'];
 
    // Add abv value as a custom field
    foreach ($brew_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) return; 

        if(get_post_meta($post->ID, $key, FALSE)) { 
            update_post_meta($post->ID, $key, $value);
        } else {
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key);
    }
  }
}


function add_sb_taxonomies() {
    // Add new "Locations" taxonomy to Posts
    register_taxonomy('hops', 'brew', array(
        'labels' => array(
            'name' => _x( 'Hops', 'taxonomy general name' ),
            'singular_name' => _x( 'Hop', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Hops' ),
            'all_items' => __( 'All Hops' ),
            'edit_item' => __( 'Edit Hop' ),
            'update_item' => __( 'Update Hop' ),
            'add_new_item' => __( 'Add New Hop' ),
            'new_item_name' => __( 'New Hop Name' ),
            'menu_name' => __( 'Hops' ),
        ),
    ));
}
add_action( 'init', 'add_sb_taxonomies', 0 );


/******************************************************************
  Start support having post thumbnails for your post images
*******************************************************************/
add_action( 'init', 'register_events' );
function register_events() {
  $event_labels = array( 
          'name' => 'Events',
        'singular_name' => 'Event' ,
        'add_new' => 'Add New',
        'add_new_item' => __( 'Add New Event' ),
        'edit_item' => __( 'Edit Event' ),
        'new_item' => __( 'New Event' ),
        'view_item' => __( 'View Event' ),
        'search_items' => __( 'Search Events' ),
        'not_found' =>  __( 'No events found' ),
        'not_found_in_trash' => __( 'No events found in Trash' )
  );
  register_post_type( 
      'event',
      array(
        'labels' => $event_labels,
        'public' => true,
        'supports' => array('title','editor','page-attributes'),
        'taxonomies' => array('course_categories', 'event_type'),
        'register_meta_box_cb' => 'add_event_metaboxes'
      )
  );
}

// --- Order events by their custom order in the back end
function set_event_admin_order($wp_query) {
  if (is_admin()) {
    if ( $wp_query->query['post_type'] == 'event') {
      $wp_query->set('orderby', 'menu_order');
      $wp_query->set('order', 'ASC');
    }
  }
}
add_filter('pre_get_posts', 'set_event_admin_order');


// --- add the meta box for the link to the ctas
function add_event_metaboxes() {
    add_meta_box('event_meta', 'Event Details', 'event_meta', 'event', 'advanced', 'high');
}

// --- Put form html into the link meta box
function event_meta() {
    global $post;
 
    // Get the link data if its already been entered
    $date = get_post_meta($post->ID, '_event_date', true);
    $time = get_post_meta($post->ID, '_event_time', true);
    $location = get_post_meta($post->ID, '_event_location', true);
    $price = get_post_meta($post->ID, '_event_price', true);

    // --- Create a nonce for security
    echo '<input type="hidden" name="_event_noncename" id="_event_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';

    // Echo out the field
    echo '<label for="_event_date">Event Date</label>';
    echo '<input type="text" name="_event_date" id="_event_date" value="' . $date  . '" class="widefat" />';
    echo '<label for="_event_time">Time</label>';
    echo '<input type="text" name="_event_time" id="_event_time" value="' . $time  . '" class="widefat" />';
    echo '<label for="_event_location">Location</label>';
    echo '<input type="text" name="_event_location" id="_event_location" value="' . $location  . '" class="widefat" />';
    echo '<label for="_event_price">Price</label>';
    echo '<input type="text" name="_event_price" id="_event_price" value="' . $price  . '" class="widefat" />';
}

add_action('save_post', 'save_event_meta', 1, 2); // save the custom fields
function save_event_meta($post_id, $post){
  if($post->post_type == 'event'){
    // --- Authenticate
    if ( !wp_verify_nonce( $_POST['_event_noncename'], plugin_basename(__FILE__) )) {
      wp_die('This event was not processed properly.');
    }
 
    // --- only allow authorized users
    if ( !current_user_can( 'edit_post', $post->ID )){
      wp_die('You do not have permissions to do that.');
    }
   
    // --- get the variables
    $event_meta['_event_date'] = $_POST['_event_date'];
    $event_meta['_event_time'] = $_POST['_event_time'];
    $event_meta['_event_location'] = $_POST['_event_location'];
    $event_meta['_event_price'] = $_POST['_event_price'];

    // --- save the data
    foreach ($event_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }
}


// --- Add a column to the list of events so we can see the date too
function event_columns($columns){
  unset($columns['date']); // --- We want our date not theirs which is the publish date
  $columns['_event_date'] = 'Event Date';
  $columns['_event_time'] = 'Event Time';
  $columns['_event_location'] = 'Location';
  $columns['_event_price'] = 'Price';
  return $columns;
}
add_filter('manage_edit-event_columns', 'event_columns');

// --- Add a column to the list of events so we can see the date too
function event_column_values($name){
  global $post;
  switch($name){
    case '_event_date':
      echo get_post_meta($post->ID, '_event_date', true);
      break;  
    case '_event_time':
      echo get_post_meta($post->ID, '_event_time', true);
      break;  
    case '_event_location':
      echo get_post_meta($post->ID, '_event_location', true);
      break;  
    case '_event_price':
      echo get_post_meta($post->ID, '_event_price', true);
      break;  
    case 'menu_order':
      echo $post->menu_order; 
      break;
  }
}
add_action('manage_event_posts_custom_column', 'event_column_values');

// --- Get all of the custom values for an event ready for the templalte
function get_event_meta(){
  $event_meta = array();
  $metadata = get_post_custom();
  $meta_keys_to_skip = array('_edit_last','_edit_lock');
  foreach($metadata as $key => $value){
    if(in_array($key, $meta_keys_to_skip)){continue;} 
    $event_meta[$key] = unserialize(unserialize($value[0]));
  }
  return $event_meta;
}

/******************************************************************
	Start support having post thumbnails for your post images
*******************************************************************/
if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
  add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
}

/******************************************************************
	Add excerpt support for pages for meta desc if empty
*******************************************************************/
add_post_type_support('page', 'excerpt');

/******************************************************************
	Add a menu to the top navigation area
*******************************************************************/
function register_menus() {
  register_nav_menus(array( 'header-menu' => __( 'Header Menu' )));
}
add_action( 'init', 'register_menus' );

// --- Fallback in case the menu in our theme doesn't exist yet
function menu_fallback(){
	$listpages = wp_list_pages("sort_column=menu_order&depth=2&title_li=&echo=0");
	$linktextpattern = '/\<a (.*?)\>(.*?)\<\/a\>/';
	$replacement = '<a $1><span>$2</span></a>';
	$navhtml = preg_replace ($linktextpattern, $replacement, $listpages);
	echo $navhtml;
}

/******************************************************************
	Meta Data for SEO
*******************************************************************/
add_action('add_meta_boxes', 'add_seo_metaboxes');
function add_seo_metaboxes() {
    add_meta_box('seo_meta_tags', 'Meta Data', 'seo_meta_html', 'page', 'normal');
}

function seo_meta_html() {
    global $post;
 
    echo '<input type="hidden" name="seometa_noncename" id="seometa_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
    $seo_title = get_post_meta($post->ID, '_seo_title', true);
    $seo_meta_desc = get_post_meta($post->ID, '_seo_meta_desc', true);
 
    echo '<label for="_seo_title">Page Title</label><input type="text" name="_seo_title" id="_seo_title" value="' . $seo_title  . '" class="widefat" />';
    echo '<label for="_seo_desc">Meta Description</label><textarea name="_seo_meta_desc" id="_seo_meta_desc" class="widefat" >'. $seo_meta_desc  .'</textarea>';
}

add_action('save_post', 'save_seo_meta', 1, 2);
function save_seo_meta($post_id, $post) {
    if ( isset($_POST['seometa_noncename']) && !wp_verify_nonce( $_POST['seometa_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
    }
 
    if ( !current_user_can( 'edit_post', $post->ID )){
        return $post->ID;
	}
 
    $cta_meta['_seo_title'] = isset($_POST['_seo_title']) ? $_POST['_seo_title'] : '';
    $cta_meta['_seo_meta_desc'] = isset($_POST['_seo_meta_desc']) ? $_POST['_seo_meta_desc'] : '';
 
    foreach ($cta_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) return;
        if(get_post_meta($post->ID, $key, FALSE)) { 
            update_post_meta($post->ID, $key, $value);
        } else { 
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); 
    }
 
}

function scbc_get_the_title(){
	global $post;
	$title_array = get_post_custom_values('_seo_title', $post->ID);
	if(is_array($title_array)){
		$title = array_pop($title_array);
	}else{
		return wp_title('&laquo;', false, 'right').get_bloginfo('name');
	}
	return $title;
}

function scbc_the_title(){
	echo scbc_get_the_title();	
}

function scbc_get_the_meta_desc(){
	global $post;
	$meta_description_array = get_post_custom_values('_seo_meta_desc', $post->ID);
	if(is_array($meta_description_array)){
		$meta_description = array_pop($meta_description_array);
	}else{
		return get_the_excerpt();
	}
	return $meta_description;
}

function scbc_the_meta_desc(){
	echo scbc_get_the_meta_desc();	
}


/***
 *	Add the modified time onto files we want versioned to force reloading
 */
function auto_version($file)
{
  if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
    return $file;

  $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
  return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
}

//add_action('init', 'cloneRole');
function cloneRole()
{
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $editor = $wp_roles->get_role('editor');
    //Adding a 'new_role' with all admin caps
    $fairy = $wp_roles->add_role('fairy', 'Fairy', $editor->capabilities);
    $fairy->add_cap( 'edit_theme_options' );
}

/**
 * Custom output of comments for Spacebrews
 * @since 2.7.0
 *
 * @param object $comment Comment data object.
 * @param int $depth Depth of comment in reference to parents.
 * @param array $args
 */
function spacebrews_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;

  extract($args, EXTR_SKIP);
?>
  <div <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

  <div class="clearfix">
    <div class="comment-author vcard grid_1">
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite>:'), get_comment_author_link()) ?>
    </div>
    <div class="comment-bubble">
    <?php if ($comment->comment_approved == '0') : ?>
      <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
      <br />
    <?php endif; ?>

      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
              <?php
                      /* translators: 1: date, 2: time */
                      printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'&nbsp;&nbsp;','' );
              ?>
      </div>

      <?php comment_text() ?>

      <div class="reply">
      <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
    </div>
  </div>
<?php
}

/**
 * Gets our latest image from our instagram account
 * @author Brian VB
 */
define('INSTAGRAM_ACCSES_TOKEN','627033820.0dc1854.7d632257d0ec49b1b691ccae23075539'); 
define('INSTAGRAM_USER_ID','627033820');

function get_latest_instagram(){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/'.INSTAGRAM_USER_ID.'/media/recent/?access_token='.INSTAGRAM_ACCSES_TOKEN.'&count=1');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result_raw = curl_exec($ch);
  $result_decoded = json_decode($result_raw,true);

  if(isset($result_decoded['data'][0])){
    return $result_decoded['data'][0];
  } else {
    return false;
  }
}

/**
 * Gets the latest facebook post from our SCBC page
 * This didn't work right off the bat because we are an alcohol related site and have permissions issues.
 * Visit the open graph API call making page: https://developers.facebook.com/tools/explorer?method=GET&path=SpaceCraftBrewing%3Ffields%3Dposts.limit(1)
 * First, put myself in that thing, and request a token for myself
 * Then, once I have that token I can use it to make calls for the SCBC page. That token is at the end of the URL below.
 */
function get_latest_facebook(){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/SpaceCraftBrewing?fields=posts.limit(1)&method=GET&format=json&suppress_http_code=1&access_token=CAACEdEose0cBAOuuBW55eW0KZBBptiz5Ou2S52y0752p7zKMRF3cUfpBpICuFfCkj1FZA30tYuLAkLPvnXTCI07NWT2zCZBHKvjDxiOZA2VffnCxkqC6Vp5uQ19YhelH2JL3mipYUohmn7xiQfQipExfZA7d6dlrtUoZBTZAnzG3qIqG6ELoZApH4MIy178C5ec0hHvnQxrHSgZDZD');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result_raw = curl_exec($ch);
  $result_decoded = json_decode($result_raw,true);

  if(isset($result_decoded['posts']['data'][0])){
    return $result_decoded['posts']['data'][0];
  } else {
    return false;
  }
}
?>