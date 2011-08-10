<?php
/**
 * TYFTC settings administration panel.
 *
 * @package WordPress
 * @subpackage TYFTC
 */

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __('TYFTC Settings');
$parent_file = 'options-general.php';

/**
 * Display JavaScript on the page.
 *
 * @package WordPress
 * @subpackage General_Settings_Screen
 */
function tyftc_add_js() {
?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		
	});
//]]>
</script>
<?php
}
add_action('admin_head', 'tytc_add_js');
?>

<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php echo esc_html($title); ?></h2>
    
  <form method="post" action="options.php">
    <?php settings_fields('tyftc'); ?>
  
    <table class="form-table">
      <tr valign="top">
        <th scope="row"><label for="blogname"><?php _e('Site Title') ?></label></th>
        <td><input name="blogname" type="text" id="blogname" value="<?php form_option('blogname'); ?>" class="regular-text" /></td>
      </tr>
      <?php do_settings_fields('tyftc', 'default'); ?>
    </table>
      
    <?php do_settings_sections('tyftc'); ?>
  
    <?php submit_button(); ?>
  </form>
    
</div>
  