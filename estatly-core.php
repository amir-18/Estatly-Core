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
require_once ESTATLY_CORE_PATH . 'includes/seed-properties.php';
require_once ESTATLY_CORE_PATH . 'includes/seed-locations.php';


register_activation_hook(
	__FILE__,
	function () {
		estatly_register_property_cpt();
		estatly_register_taxonomies();
		flush_rewrite_rules();
	}
);


add_filter( 'acf/format_value/name=prop_price', function ( $value, $post_id, $field ) {
    if ( is_admin() ) {
        return $value; // edit screen par asli number rehne do
    }

    $n = (float) preg_replace( '/[^0-9.]/', '', $value );
    if ( ! $n ) {
        return $value;
    }

    if ( $n >= 10000000 ) {
        $out = rtrim( rtrim( number_format( $n / 10000000, 2 ), '0' ), '.' ) . ' Crore';
    } elseif ( $n >= 100000 ) {
        $out = rtrim( rtrim( number_format( $n / 100000, 2 ), '0' ), '.' ) . ' Lakh';
    } else {
        $out = number_format( $n );
    }

    $out = 'PKR ' . $out;

    if ( has_term( 'for-rent', 'listing_status', $post_id ) ) {
        $out .= ' / month';
    }

    return $out;
}, 10, 3 );
add_action( 'save_post_property', 'estatly_build_price_display' );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );