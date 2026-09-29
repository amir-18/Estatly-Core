<?php
// Plugin Name: Estatly Core
// Author Name: Amir
// Description: Site Core Plugin Including Custom Post Types, Taxanomies and Shortcodes 
// Version: 1.0.0
// Required PHP: 7.4
// Text Domain: estatly-core


if(!define('ABSPATH')){
    exit;
}

define('ESTATLY_CORE_VERSION','1.0.0');
define('ESTATLY_CORE_PATH',plugin_dir_path(__FILE__));
define('ESTATLY_CORE_URL',plugin_dir_url(__FILE__));

// SAVES ACF JSON FILE IN PLUGIN ACF FOLDER

add_filter('acf/settings/save_json', function(){
    return ESTATLY_CORE_PATH . 'acf-json';
});

// SAVES ACF JSON FILE IN PLUGIN ACF FOLDER

// LOADS ACF JSON FILES FROM PLUGIN ACF FOLDER

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = ESTATLY_CORE_PATH . 'acf-json';
    return $paths;
});

// LOADS ACF JSON FILES FROM PLUGIN ACF FOLDER

// REQUIRING CPTS,SHORTCODES AND TAXANOMIES
require_once(ESTATLY_CORE_PATH . 'includes/cpt-property.php')
require_once(ESTATLY_CORE_PATH . 'includes/taxanomies.php')

// REQUIRING CPTS,SHORTCODES AND TAXANOMIES