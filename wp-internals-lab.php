<?php
/*
Plugin Name: WP Internals Lab
Description: Playground plugin for testing hooks, filters, REST API and more.
Version: 0.1.0
Author: Pablo Miralles
Author URI: https://github.com/pablo-miralles
Text Domain: wp-internals-lab
Domain Path: /languages
*/

define( 'WPIL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPIL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once WPIL_PLUGIN_PATH . '/includes/01-wordpress-bootstrap-process/playground.php';
require_once WPIL_PLUGIN_PATH . '/includes/02-rest-api/playground.php';
require_once WPIL_PLUGIN_PATH . '/includes/03-wp-cli/playground.php';
