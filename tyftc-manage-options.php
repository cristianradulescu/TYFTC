<?php
/**
 * TYFTC settings administration panel.
 *
 * @package WordPress
 * @subpackage TYFTC
 */

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __('TYTC Settings');
$parent_file = 'options-general.php';

// handle form submit
if (isset($_POST['submit'])) {
  // check if tyftc is enabled
  $tyftc_enabled = isset($_POST['tyftc-enabled']) ? 1 : 0;
  update_option('tyftc-enabled', $tyftc_enabled);
  
  // if tyftc is enabled process the rest of the options
  if ($tyftc_enabled) {
    update_option('tyftc-popup-content', $_POST['tyftc-popup-content']);

    $popup_with = isset($_POST['tyftc-popup-width']) && is_numeric($_POST['tyftc-popup-width'])
                  ? intval($_POST['tyftc-popup-width']) : 100;
    update_option('tyftc-popup-width', $popup_with);

    $popup_height = isset($_POST['tyftc-popup-height']) && $_POST['tyftc-popup-height']
                  ? intval($_POST['tyftc-popup-height']) : 100;
    update_option('tyftc-popup-height', $popup_height);
  }
}

?>
<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php echo esc_html($title); ?></h2>
  <?php if (isset($_POST['submit'])): ?>
  <div id="setting-error-settings_updated" class="updated settings-error"> 
    <p><strong><?php echo _e('Settings saved.') ?></strong></p>
  </div>
  <?php endif; ?>
    
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=tyftc-manage">
    
    <table class="form-table">
      <tr valign="top">
        <th scope="col" colspan="2"><h3><?php _e('Options') ?></h3></th>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="tyftc-enabled"><?php _e('Enabled') ?></label></th>
        <td>
          <input name="tyftc-enabled" 
                 type="checkbox" 
                 id="tyftc-enabled" 
                 <?php echo 1 == get_option('tyftc-enabled', 0) ? 'checked' : '' ?> />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="tyftc-popup-width"><?php _e('Width') ?></label></th>
        <td>
          <input name="tyftc-popup-width" 
                 type="text" 
                 id="tyftc-popup-width" 
                 value="<?php echo get_option('tyftc-popup-width') ?>" 
                 class="small-text" /> px
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="tyftc-popup-height"><?php _e('Height') ?></label></th>
        <td>
          <input name="tyftc-popup-height" 
                 type="text" 
                 id="tyftc-popup-height" 
                 value="<?php echo get_option('tyftc-popup-height') ?>" 
                 class="small-text" /> px
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="tyftc-popup-content"><?php _e('Content') ?></label><br/>
        <span class="description"><?php _e('HTML or plain text') ?></span></th>
        <td>
          <textarea cols="80" rows="10" name="tyftc-popup-content" id="tyftc-popup-content"><?php echo get_option('tyftc-popup-content') ?></textarea>
          
          <br />
          <a id="tyftc-popup-trigger" class="colorbox-popup-trigger" href="#">Preview</a>
          <script>
            jQuery(document).ready(function(){
              jQuery('#tyftc-popup-trigger').click(function() {
                jQuery('#popup_content').html(jQuery('#tyftc-popup-content').val());
                jQuery(".colorbox-popup-trigger").colorbox({
                  width:parseInt(jQuery('#tyftc-popup-width').val()), 
                  height:parseInt(jQuery('#tyftc-popup-height').val()), 
                  inline:true,
                  href: "#popup_content"
                });
              });
            });
          </script>
          <div style="display:none"> 
            <div id="popup_content" style="padding:10px; background:#fff;">
            </div> 
          </div> 
        </td>
      </tr>
    </table>      
      
    <?php submit_button(); ?>
  </form>
    
</div>
  