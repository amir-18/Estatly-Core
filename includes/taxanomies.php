<?php
/**
 * Registers taxonomies for the "property" post type.
 *
 * @package Estatly_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatly_register_taxonomies() {

	// 1. Property Type: hierarchical.
	register_taxonomy(
		'property_type',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Property Types', 'estatly-core' ),
				'singular_name' => __( 'Property Type', 'estatly-core' ),
			),
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'property-type' ),
		)
	);

	// 2. Property Location: hierarchical.
	register_taxonomy(
		'property_location',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Locations', 'estatly-core' ),
				'singular_name' => __( 'Location', 'estatly-core' ),
			),
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'location' ),
		)
	);

	// 3. Listing Status: non-hierarchical.
	register_taxonomy(
		'listing_status',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Listing Status', 'estatly-core' ),
				'singular_name' => __( 'Listing Status', 'estatly-core' ),
			),
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'status' ),
		)
	);

	// 4. Property Amenity: non-hierarchical.
	register_taxonomy(
		'property_amenity',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Amenities', 'estatly-core' ),
				'singular_name' => __( 'Amenity', 'estatly-core' ),
			),
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => false,
			'rewrite'           => array( 'slug' => 'amenity' ),
		)
	);
}
add_action( 'init', 'estatly_register_taxonomies' );