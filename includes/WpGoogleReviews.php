<?php

use SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException;
use SKAgarwal\GoogleApi\PlacesApi;

require_once __DIR__ . "/../vendor/autoload.php";

class WpGoogleReviews
{

    /**
     * @var string
     */
    private $plugin_path;

    /**
     * @var WordPressSettingsFramework
     */
    private $wpsf;

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(__FILE__) . '/../';

        // Include and create a new WordPressSettingsFramework
        require_once(__DIR__ . '/../wp-settings-framework/wp-settings-framework.php');
        $this->wpsf = new WordPressSettingsFramework($this->plugin_path . 'settings/settings-general.php', 'bewe_wp_google_reviews');

        // Add admin menu
        add_action('admin_menu', array($this, 'add_settings_page'), 20);

        // Add an optional settings validation filter (recommended)
        add_filter($this->wpsf->get_option_group() . '_settings_validate', array(&$this, 'validate_settings'));

        // add us
        // add_action('wp_enqueue_scripts', array($this, 'load_dependencies'));
        add_shortcode('google-review', array($this, 'output_google_reviews'));
    }

    /**
     * Validate settings.
     * 
     * @param $input
     *
     * @return mixed
     */
    function validate_settings($input)
    {
        // Do your settings validation here
        // Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
        return $input;
    }

    /**
     * Add settings page.
     */
    function add_settings_page()
    {
        $this->wpsf->add_settings_page(array(
            'parent_slug' => 'tools.php',
            'page_title'  => __('Google Reviews', 'wp-google-reviews'),
            'menu_title'  => __('Google Reviews', 'wp-google-reviews'),
        ));
    }

    /**
     * Load our dependencies
     * @return void 
     */
    public function load_dependencies()
    {
        wp_enqueue_script('wp-google-reviews', plugins_url('assets/build/bundle.js', dirname(__FILE__)), array(), time(), true);
        wp_enqueue_style('wp-google-reviews', plugins_url('assets/build/bundle.css', dirname(__FILE__)), array(), time());

        // Optional
        wp_localize_script('wp-google-reviews', 'wordpress_object', array(
            'plugins_url' => plugins_url('/', dirname(__FILE__)),
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }

    /**
     * Load and output the google reviews 
     * 
     * @param array $attributes 
     * @return string 
     * @throws GooglePlacesApiException 
     */
    public function output_google_reviews($attributes = array(), $content = null, $tag = '')
    {
        if (empty($attributes) || !array_key_exists('place-id', $attributes)) {
            return <<<EOD
                <div>Please enter a Google Place's id as the parameter `place-id` to the shortcode.</div>
            EOD;
        }

        try {
            $placeDetails = $this->load_google_reviews($attributes['place-id']);
            return '<wp-google-reviews style="display:block" data-reviews="' . esc_attr(json_encode($placeDetails)) . '" data-proxy-url="' .
                plugins_url('wp-google-reviews-proxy.php', dirname(__FILE__))
                . '"></wp-google-reviews>';
        } catch (\SKAgarwal\GoogleApi\Exceptions\GooglePlacesApiException $e) {
            return <<<EOD
                <div>Failed to fetch details from Google. Please check your API Key. Error: {$e->getErrorMessage()}</div>
            EOD;
        }
    }

    public function load_google_reviews(string $placeId)
    {
        $cache_key = 'wp-google-reviews-' . $placeId . get_locale();
        $transient_key = 'wp_google_reviews_' . md5($placeId . get_locale());

        // Try wp_cache first
        $cached_data = wp_cache_get($cache_key);
        if ($cached_data) {
            return $cached_data;
        }

        // Fallback to transients
        $transient_data = get_transient($transient_key);
        if ($transient_data) {
            // Store back in wp_cache for faster access during this request
            wp_cache_set($cache_key, $transient_data, 2 * 24 * HOUR_IN_SECONDS);
            return $transient_data;
        }

        $this->load_dependencies();
        $settings = $this->wpsf->get_settings();
        $googlePlaces = new PlacesApi($settings['general_google_api_key']);
        $placeDetails = $googlePlaces->placeDetails($placeId, [
            'language' => get_locale(),
            'fields' => 'name,icon,photo,url,rating,reviews'
        ]);

        // Store in both caches
        wp_cache_set($cache_key, $placeDetails, 2 * 24 * HOUR_IN_SECONDS);
        set_transient($transient_key, $placeDetails, 2 * 24 * HOUR_IN_SECONDS);

        return $placeDetails;
    }
}
