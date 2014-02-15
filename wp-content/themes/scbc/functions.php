<?php
/**
* @package SpaceCraftBrewingCompany
* @subpackage SCNCWP
*/

/**
 * @var array of Months with their numbers as keys
 */
$months = array(
  1=>'January',
  2=>'February',
  3=>'March',
  4=>'April',
  5=>'May',
  6=>'June',
  7=>'July',
  8=>'August',
  9=>'September',
  10=>'October',
  11=>'November',
  12=>'December',
);

/**
 * We want this to be in the meta tags and used on pages to avoid using the function twice we'll store it in a global variable
 */
$featured_image_data = '';

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
    echo '<input type="hidden" name="_brew_noncename" id="_brew_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
 
    // Get the abv data if its already been entered
    $abv = get_post_meta($post->ID, '_brew_abv', true);
 
    // Echo out the field
    echo '<input type="text" name="_brew_abv" value="' . $abv  . '" class="widefat" placeholder="e.g. &ldquo;7.5&rdquo;" />';

}


add_action('save_post', 'save_brew_meta', 1, 2); // save the custom fields
// Save the abv 
function save_brew_meta($post_id, $post) {
  if($post->post_type == 'brew' && isset($_POST['save'])){ // --- Only run this if we're saving a brew

    // --- verify
    if ( !wp_verify_nonce( $_POST['_brew_noncename'], plugin_basename(__FILE__) )) {
		  wp_die('This brew was not processed properly.');
    }
 
    // --- authorized?
    if ( !current_user_can( 'edit_post', $post->ID )){
      wp_die('You do not have permissions to do that.');
    }

    $brew_meta['_brew_abv'] = $_POST['_brew_abv'];
 
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
  if($post->post_type == 'event' && isset($_POST['save'])){
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
  add_image_size( 'news-thumb', 300);
  add_image_size( 'page-content-img', 400);
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
}

add_filter( 'image_size_names_choose', 'scbc_image_sizes_choose' );
function scbc_image_sizes_choose( $sizes ) {
  $custom_sizes = array(
    'news-thumb' => 'News Thumb',
    'page-content-img' => 'Page Content Image'
  );
  return array_merge( $sizes, $custom_sizes );
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
 * Gets our latest image from our instagram account
 * @author Brian VB
 */
define('FACEBOOK_PAGE_ACCESS_TOKEN','CAAURZBW1weO0BAK9CSivMDlEqVAZCZBK2Ru17ZA2X6n0jaLpk1JzRBwkaZBjZCOPORoIClIWIcz1iSViTUjOG2fZAxOXnqFQYFlbpJwZBzC5RNpvaEHpzpeLZAQ7B8epZBtmzDbrawttWZAvypZB5PZBfOQesZAikIT53VfzjDpef5zA71GA9x55RuWRd5yZAxyOsuyu6kZD'); 
define('FACEBOOK_APP_ID','1427137864169709');
define('FACEBOOK_APP_SECRET','dcae2f1dd3cc68e44a07a1f03037536e');

/**
 * Gets the latest facebook post from our SCBC page
 * This didn't work right off the bat because we are an alcohol related site and have permissions issues. 
 * I had to create a facebook app to be able to manage my SCBC page. Then I followed instructions at this URL for getting my access token: http://itslennysfault.com/get-facebook-access-token-for-graph-api
 * That token had a brief expiration, though, so I had to follow the instructions here to get a token that should last for 60 days: https://developers.facebook.com/docs/roadmap/completed-changes/offline-access-removal/#extend_token 
 * Another resource: https://developers.facebook.com/docs/facebook-login/access-tokens/#extending
 * I then went to the facebook graph API page (https://developers.facebook.com/tools/explorer/121632337907271/?method=GET&path=15709719%3Ffields%3Daccounts) and searched for /me/accounts with my access token in the top bar
 * Once in there I found the access token under SCBC and THAT is the tokent that I use below
 * Once you are all done with this you can debug and make sure it's all right here: https://developers.facebook.com/tools/debug/accesstoken
 * When I use that new access token and do /me in the explorer, it's my page. When I debug it, it includes the profile ID for my page as well so I know it's good
 * Then, once I have that token I can use it to make calls for the SCBC page. That token is at the end of the URL below.
 */
function get_latest_facebook(){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/SpaceCraftBrewing?fields=posts.limit(1)&method=GET&format=json&suppress_http_code=1&access_token='.FACEBOOK_PAGE_ACCESS_TOKEN);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result_raw = curl_exec($ch);
  $result_decoded = json_decode($result_raw,true);
  
  if(isset($result_decoded['posts']['data'][0])){
    $post = $result_decoded['posts']['data'][0];
    if($post['type'] == 'photo'){
      preg_match('/_(\d+)/', $post['id'], $matches);
      return '<p><a href="http://facebook.com/SpaceCraftBrewing/posts/'.$matches[1].'/" target="_blank" title="View on Facebook">'.$post['story'].'</a></p><a href="http://facebook.com/SpaceCraftBrewing/posts/'.$matches[1].'/" target="_blank" title="View on Facebook"><img src="'.$post['picture'].'"/><span style="vertical-align:middle;margin-left: 30px;">View More &hellip;</span></a>';
    } else {
      return '<p>'.$post['message'].'</p>';
    }
  } else {
    return false;
  }
}

/**
 * Uses cURL to follow the URL to the final location of the image. We do this to hide our access token
 * @return string the url/src of the facebook icon image
 */
function get_facebook_icon_url(){ 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/SpaceCraftBrewing/picture?access_token='.FACEBOOK_PAGE_ACCESS_TOKEN);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
}

/**
 * Checks to see if a user uses our facebook app
 */
function uses_facebook_app(){
  require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/scbc/classes/facebook/facebook.php');
  $facebook = new Facebook(array(
    'appId'  => FACEBOOK_APP_ID,
    'secret' => FACEBOOK_APP_SECRET,
  ));

  $facebook_user = $facebook->getUser();
  if ($facebook_user) {
    return true;
  }
}


/**
 * Makes sure that a user is legally allowed to be viewing the content
 */
function verify_age($dob_array){
  $date_str = $dob_array['year'].'-'.$dob_array['month'].'-'.$dob_array['day'];
  if( strtotime($date_str) < strtotime('-21 years') ){
    return true;
  }
  return false;
}

/**
 * Shows a verification modal if the user hasn't verified their age
 */
function gate_site(){
  if( ! (isset($_COOKIE['verified']) || is_page('kiddie-ride') ) ) { // --- Only gate if they aren't verified 
    if(isset($_POST['dob'])){
      if(verify_age($_POST['dob'])){
        setcookie('verified','1',time()+60*60*24*365,'/');
      } else {
        wp_redirect( home_url().'/kiddie-ride/');
      }
    } elseif(uses_facebook_app()){
      setcookie('verified','1',time()+60*60*24*365,'/');
    } else {
      add_action('wp_footer','show_verification_modal');
    }
  }
}
add_action('template_redirect','gate_site');

/**
 * Include the HTML for the age verification modal
 */
function show_verification_modal(){
  include_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/scbc/inc/_verification_dialog.php';
}

/**
 * Returns the post object for a featured image of a post so we can get caption, title, etc.
 * @return WP_post object for the featured image
 */
function get_post_featured_image_data() {
  global $post;
  $thumb_id = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_post($thumb_id);

  if ($thumbnail_image && !empty($thumbnail_image->guid)) {
    return $thumbnail_image;
  } else {
    return false;
  }
}

/**
 * Add meta tags in the head sections
 */
function sb_add_meta_tags(){
  // --- Add general tags for our page to be recognized on Facebook
  
  
  if(is_single()){
    // --- Store featured image data in a global variable for reuse
    global $featured_image_data;
    $featured_image_data = get_post_featured_image_data();
    echo '<meta property="og:type"   content="article" />'."\n";
    echo '<meta property="og:image"  content="'.$featured_image_data->guid.'" />'."\n";
  }
}

add_action( 'after_setup_theme', 'sb_ahoy', 16 );
/**
 * Do some major cleaning up of automatic WP things
 */
function sb_ahoy() {

  // launching operation cleanup
  add_action( 'init', 'sb_head_cleanup' );
  // remove WP version from RSS
  add_filter( 'the_generator', 'sb_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'sb_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'sb_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'sb_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'sb_add_scripts', 999 );

  // --- Add meta tags we want on apporpriate pages
  add_action('wp_head', 'sb_add_meta_tags');
} /* end sb ahoy */

function sb_head_cleanup() {
  // category feeds
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  // post and comment feeds
  remove_action( 'wp_head', 'feed_links', 2 );
  // EditURI link
  remove_action( 'wp_head', 'rsd_link' );
  // windows live writer
  remove_action( 'wp_head', 'wlwmanifest_link' );
  // index link
  remove_action( 'wp_head', 'index_rel_link' );
  // previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // start link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // links for adjacent posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // WP version
  remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'sb_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'sb_remove_wp_ver_css_js', 9999 );

} /* end sb head cleanup */

// remove WP version from RSS
function sb_rss_version() { return ''; }

// remove WP version from scripts
function sb_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}

// remove injected CSS for recent comments widget
function sb_remove_wp_widget_recent_comments_style() {
  if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
    remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
  }
}

// remove injected CSS from recent comments widget
function sb_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
  }
}

// remove injected CSS from gallery
function sb_gallery_style($css) {
  return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/**
 * Load in the javascripst necessary to run the site
 */
function sb_add_scripts(){
  if( !is_admin() ){
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', '/wp-content/themes/scbc/js/bootstrap.min.js');
  } 
}

/**
 * Show the brews in the admin area in the same order we want them on the front end
 * @author Brian VB
 */
function set_brews_admin_order($wp_query) {
  if (is_admin()) {
    $post_type = $wp_query->query['post_type'];
    if ( $post_type == 'brew') {
      $wp_query->set('orderby', 'menu_order');
      $wp_query->set('order', 'ASC');
    }
  }
}
add_filter('pre_get_posts', 'set_brews_admin_order');