<?php

/**
 * Plugin Name:  Google Reviews
 * Description:  A WordPress plugin that enables you to include Google reviews, GDPR-friendly
 * Version: 0.0.1
 * License: MIT License
 * Author: Tim Bernhard
 * Author URI: https://github.com/genietim
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

require_once( __DIR__ . '/includes/WpGoogleReviews.php' );

if ( class_exists( 'WpGoogleReviews' ) ) {
	$wpGoogleReviews = new WpGoogleReviews();
}
