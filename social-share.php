<?php
defined('ABSPATH') || exit;
/**
 * Plugin Name: MWB Social Share
 * Plugin URI: https://mwb-agency.com
 * Description: A Social Share plugin that renders the social share icons
 * Version: 0.0.1
 * Requires PHP: 7.0
 * Author: Micah Kwaka
 * Author URI: https://mwb-agency.com
 * Text Domain: mwb-social-share
 * @package MwbSocialShare
 */

defined('ABSPATH') || exit;

if (!defined('MWB_SOCIAL_SHARE_PLUGIN_FILE')) {
  define('MWB_SOCIAL_SHARE_PLUGIN_FILE', __FILE__);
}

// Include the main class.
if (!class_exists('MwbSocialShare')) {
  include_once dirname( MWB_SOCIAL_SHARE_PLUGIN_FILE ). '/includes/class-social-share.php';
}


// When trying to active the plugin
register_activation_hook( __FILE__, function() {
  if (!function_exists('is_plugin_active')) {
		require_once(ABSPATH . '/wp-admin/includes/plugin.php');
  }
  
  // can the user activate plugins and are all dependencies met?
  if(current_user_can('activate_plugins')) {
    // check if we have any dependency errors
    $error = acf_dependency_error();

    if($error !== false) {
      // Deactivate the plugin.
      deactivate_plugins( plugin_basename( __FILE__ ));

      // error printing the message to the admin
			die(admin_message($error)); // WPCS: XSS ok.
    }
  }
});

// Add Settings links in plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links){
  $settings_links = [sprintf('<a href="%s">%s</a>', 'options-general.php?page=mwb-social-share-settings', 'Settings')];
  return array_merge($settings_links, $links);
});


/**
 * Returns the main instance.
 *
 * @since  2.1
 * @return MwbSocialShare
 */

function mwb_get_social_share()
{
  if (isset($GLOBALS['mwb-get-social-share'])) {
    return $GLOBALS['mwb-get-social-share'];
  }

  return new MwbSocialShare();
}

mwb_get_social_share();

/**
 * Are all the plugins we need installed
 * @return bool
 */
function acf_dependency_error():bool {
  if(!function_exists('is_plugin_active')) {
    require_once(ABSPATH . '/wp-admin/includes/plugin.php');
  }

  // list all the plugin dependencies
	$dependencies = [
		'acf' => [
			'name' => 'Advanced Custom Fields (ACF) Pro',
			'file' => 'advanced-custom-fields-pro/acf.php',
			'version' => '5.8.11'
		]
  ];
  
  foreach ($dependencies as $key => $dependency) {
    // first check if it's active
    if (!is_plugin_active( $dependency['file'])) {
      return $dependency['name'] . ' is not active';
    }
		
		// then check the version
    $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $dependency['file']);
    
    if (!version_compare($plugin_data['Version'], $dependency['version'], '>=')) {
      return $dependency['name'] . ' is not the correct version. Please install version ' . $dependency['version'] . '.';
    }
  }

  return false;
}