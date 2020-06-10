<?php if (!defined('ABSPATH')) exit;

/**
 * Add MetaBox to admin page
 * @package MwbSocialShareAdminMetaBox
 * @version 0.1
 */
class MwbSocialShareAdminMetaBox
{
  public function __construct()
  {
    add_action('acf/input/admin_head', [$this, 'setMetabox'], 1);
    add_action('admin_enqueue_scripts', [$this, 'adminAssets']);
  }

  /**
   * Adds the meta box.
   * Predefine position the metabox
   */
  public function setMetabox()
  {
    if(!is_admin()) {
      return false;
    }
    
    $screen = get_current_screen() ?? null;
    
    if (empty($screen->post_type) && empty($screen->taxonomy)) {
      try {
        add_meta_box('more-info', 'Additional Info' , [$this, 'metaBoxContent'], 'acf_options_page', 'side', 'high', []);
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }

  /**
   * Prints out the content in the meta box
   */
  public function metaBoxContent()
  {
    printf(
      '<div class="mwb-container">
        <h4>PHP</h4>
        <label>Use this PHP snippet to include your inline MWB Social Share anywhere else in your template</label>
        <input class="shareCode" type="text" value="%s" readonly />
        <button class="button button-primary button-large copyDataBtn" type="button">Copy</button>
      </div>
      <div class="mwb-container">
        <h4>Shortcode</h4>
        <label>Use this shortcode to include your inline MWB Social Share anywhere else in your template</label>
        <input class="shareCode" type="text" value="%s" readonly />
        <button class="button button-primary button-large copyDataBtn" type="button">Copy</button>
      </div>',
      "<?php echo mwb_get_social_share()->getSocialHtml();?>",
      '[mwb_social_share]'
    );
  }

  /**
   * Load Metabox css and js files
   */
  public function adminAssets()
  {
    wp_enqueue_script('mwb-social-share-js', MWB_SOCIAL_SHARE_ASSETS . '/js/admin.js', array('jquery'), MWB_SOCIAL_SHARE_ASSETS_VERSION, true);
    wp_enqueue_style('mwb-social-share-css', MWB_SOCIAL_SHARE_ASSETS . '/css/admin.css', null, MWB_SOCIAL_SHARE_ASSETS_VERSION);
  }
}
