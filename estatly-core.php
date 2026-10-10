<?php
/**
 * Plugin Name: Estatly Core
 * Description: Property CPT, taxonomies, shortcodes and ACF JSON sync for Estatly.
 * Version:     0.1.0
 * Author:      Your Name
 * Text Domain: estatly-core
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATLY_CORE_VERSION', '0.1.0' );
define( 'ESTATLY_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ESTATLY_CORE_URL', plugin_dir_url( __FILE__ ) );

add_filter(
	'acf/settings/save_json',
	function () {
		return ESTATLY_CORE_PATH . 'acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = ESTATLY_CORE_PATH . 'acf-json';
		return $paths;
	}
);

require_once ESTATLY_CORE_PATH . 'includes/cpt-property.php';
require_once ESTATLY_CORE_PATH . 'includes/taxonomies.php';
require_once ESTATLY_CORE_PATH . 'includes/shortcodes.php';

register_activation_hook(
	__FILE__,
	function () {
		estatly_register_property_cpt();
		estatly_register_taxonomies();
		flush_rewrite_rules();
	}
);

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );