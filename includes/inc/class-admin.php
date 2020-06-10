<?php if (!defined('ABSPATH')) exit;
/**
 * Print out social share icons and urls
 * 
 * @package MwbSocialShareAdmin
 * @version 0.1
 * @author Micah Kwaka
 */
class MwbSocialShareAdmin
{
  public $plugin;

  public function __construct()
  {
    $this->plugin = plugin_basename(__FILE__);
    self::includes();
    add_action('wp_enqueue_scripts', [$this, 'mwbSocialAssets'], 1);
    add_action('init', [$this, 'getMetaBox']);
  }

  /**
   * Includes other class files
   */
  public static function includes()
  {
    include_once 'acf-inc.php';
    include_once 'class-metabox.php';
  }

  /**
   * Add Admin page
   */
  public static function addOptionsPage()
  {
    if (function_exists('acf_add_options_page')) {
      acf_add_options_page([
        'page_title'      => 'MWB Social Share',
        'menu_title'      => 'MWB Social Share',
        'menu_slug'       => 'mwb-social-share-settings',
        'icon_url'        => 'dashicons-share',
        'post_id'         => 'mwb_social_share',
        'capability'      => 'edit_posts',
        'redirect'        => false,
        'update_button'   => 'Update Social Share',
        'updated_message' => 'Settings updated'
      ]);
    }
  }

  /**
   * Enquene css file
   */
  public function mwbSocialAssets()
  {
    wp_enqueue_style('mwv-social-share-css', MWB_SOCIAL_SHARE_ASSETS . '/css/social.css', [], MWB_SOCIAL_SHARE_ASSETS_VERSION);
  }

  /**
   * Get Cms options 
   * @return array $args
   */
  public function getAdminOptions()
  {
    return get_field('mwb_social_group', 'mwb_social_share');
  }

  /**
   * return meta box instance
   * @return object  MwbSocialShareAdminMetaBox instance
   */
  public function getMetaBox(): object
  {
    return (new MwbSocialShareAdminMetaBox());
  }
}
