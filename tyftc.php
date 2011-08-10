<?php
/*
Plugin Name: Thank you for the comment
Author: Cristian Radulescu
Version: 1.0
*/

// Check for location modifications in wp-config
// Then define accordingly
if ( !defined('WP_CONTENT_URL') ) {
	define('TYFTC_PLUGPATH',get_option('siteurl').'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
	define('TYFTC_PLUGDIR', ABSPATH.'/wp-content/plugins/'.plugin_basename(dirname(__FILE__)).'/');
} else {
	define('TYFTC_PLUGPATH',WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/');
	define('TYFTC_PLUGDIR',WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)).'/');
}

function tyftc_pages() {
	add_options_page('Manage &quot;Thank you for the comment&quot; options', 'TYFTC options', 'manage_options', 'tyftc-manage', 'tyftc_manage');
}

function tyftc_manage() {
//  set_current_screen();
  global $current_screen;
  require_once('tyftc-manage-options.php');
}

function tyftc_add_resources() {
  wp_enqueue_style('colorbox', TYFTC_PLUGPATH.'js/colorbox/colorbox.css');
  wp_print_styles('colorbox');
  
  wp_register_script('colorbox', TYFTC_PLUGPATH.'js/colorbox/jquery.colorbox-min.js');
  wp_print_scripts(array('jquery', 'colorbox'));
}


// We need some CSS to position the paragraph
function tyftc_post_redirect($location) {
  tyftc_add_resources();
	?>
  <p style="margin: 0 auto">
    <a class='example' href="http://2.bp.blogspot.com/_izVwjq5gV80/TB8uU1mdfoI/AAAAAAAAAQU/BzS_h6963So/s1600/Thank-you.jpg"></a>
  </p>
  <script>
		jQuery(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			jQuery(".example").colorbox({
        width:350, 
        height:350, 
        iframe:true,
        open: true,
        onClosed: function() { window.location.replace('<?php echo $location ?>') }
      });
		});
	</script>
  <?php
}

//add_action('comment_post_redirect', 'tyftc_post_redirect');
add_action('wp_head', 'tyftc_add_resources');
add_action('admin_menu', 'tyftc_pages');