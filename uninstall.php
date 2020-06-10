<?php 

/**
 * @package MwbSocialShare
 */

if (!defined('WP_UNINSTALL_PLUGIN')) die;

$option_name = 'mwb-social-share-settings';
 
delete_option($option_name);
 
// for site options in Multisite
delete_site_option($option_name);
 
