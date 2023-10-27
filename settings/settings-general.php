<?php

/**
 * Define your settings
 *
 * The first parameter of this filter should be wpsf_register_settings_[options_group],
 * in this case "bewe_wp_google_reviews".
 *
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's important as it differentiates your options from others.
 *
 * To use the tabbed example, simply change the second param in the filter below to 'wpsf_tabbed_settings'
 * and check out the tabbed settings function on line 156.
 */

add_filter('wpsf_register_settings_bewe_wp_google_reviews', 'bewe_wp_google_reviews_settings');

/**
 * Tabless example.
 *
 * @param array $wpsf_settings Settings.
 */
function bewe_wp_google_reviews_settings($wpsf_settings)
{

  $wpsf_settings[] = array(
    'section_id' => 'general',
    'section_title' => __('General Settings', 'wp-google-reviews'),
    'section_description' => __('', 'wp-google-reviews'),
    'section_order' => 1,
    'fields' => [
      [
        'id' => 'google_api_key',
        'title' => __('Google Places API Key', 'wp-google-reviews'),
        'type' => 'text',
        'desc' => __('If you want to restrict the API key, and the IP of this server stays constant, it is ', 'wp-google-reviews') . $_SERVER['SERVER_ADDR'],
        'default' => ''
      ],
    ]
  );

  return $wpsf_settings;
}
