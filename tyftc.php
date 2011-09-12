<?php
/**
 * Plugin Name: Thank you for the comment
 * Author: Cristian Radulescu
 * Version: 1.0
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

/**
 * Add admin menu to dashboard
 */
function tyftc_admin_menu() {
	add_options_page('Manage &quot;TYFTC&quot; options', 'TYFTC', 'manage_options', 'tyftc-manage', 'tyftc_manage');
}

/**
 * Include management page in dashboard
 * 
 * @global string $current_screen 
 */
function tyftc_manage() {
  global $current_screen;
  require_once('tyftc-manage-options.php');
}

/**
 * Add custom resources on the frontend
 */
function tyftc_wp_head() {
  wp_enqueue_style('colorbox', TYFTC_PLUGPATH.'js/colorbox/colorbox.css');
  wp_print_styles('colorbox');

  wp_register_script('colorbox', TYFTC_PLUGPATH.'js/colorbox/jquery.colorbox-min.js');
  wp_register_script('tyftc-frontend', TYFTC_PLUGPATH.'js/tyftc.js');
  wp_print_scripts(array('jquery', 'colorbox', 'tyftc-frontend'));
}

/**
 * Override the default comment redirection
 * 
 * @param string $location
 * 
 * @return string 
 */
function tyftc_post_redirect($location) {
  // tyftc disabled
  if (1 != get_option('tyftc-enabled')) {
    return $location;
  }
  
  tyftc_wp_head();
	?>
  <a id="tyftc-popup-trigger" class="example" href="#"></a>
  <script>
		jQuery(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			jQuery(".example").colorbox({
        width:<?php echo get_option('tyftc-popup-width') ?>, 
        height:<?php echo get_option('tyftc-popup-height') ?>, 
        inline:true,
        href: "#popup_content",
        open: true,
        onClosed: function() { window.location.replace('<?php echo $location ?>') }
      });
      
      jQuery('#tyftc-popup-trigger').trigger('click');
		});
	</script>
	<div style="display:none"> 
		<div id="popup_content" style="padding:10px; background:#fff;">
        <?php echo get_option('tyftc-popup-content', 'Thank you!') ?>
		</div> 
	</div> 
  <?php
}

add_filter('comment_post_redirect', 'tyftc_post_redirect');
add_action('admin_menu', 'tyftc_admin_menu');
add_action('wp_head', 'tyftc_wp_head');