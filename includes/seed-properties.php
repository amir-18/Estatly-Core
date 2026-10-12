<?php
/**
 * WP-CLI seeder: dummy property listings for development.
 *
 * Usage:
 *   wp estatly seed-properties            Create dummy listings (no images)
 *   wp estatly seed-properties --images   Also download placeholder photos
 *   wp estatly seed-properties --clean    Delete all dummy listings and images
 *
 * Requires the terms to exist first (seed locations, then add property types,
 * listing statuses and amenities). Safe to run more than once.
 *
 * @package Estatly_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find a term by walking a name path, e.g. array( 'Lahore', 'DHA Lahore', 'Phase 6' ).
 *
 * @param string $taxonomy Taxonomy name.
 * @param array  $path     Names from top level down to the leaf.
 * @return int[] Term IDs for every level (ancestors first), or empty array if any level is missing.
 */
function estatly_find_term_path( $taxonomy, array $path ) {
	$parent = 0;
	$ids    = array();

	foreach ( $path as $name ) {
		$found = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'name'       => $name,
				'parent'     => $parent,
				'hide_empty' => false,
				'number'     => 1,
				'fields'     => 'ids',
			)
		);

		if ( is_wp_error( $found ) || empty( $found ) ) {
			return array();
		}

		$parent = (int) $found[0];
		$ids[]  = $parent;
	}

	return $ids;
}

/**
 * Find a flat term (no parent) by name.
 *
 * @param string $taxonomy Taxonomy name.
 * @param string $name     Term name.
 * @return int Term ID or 0.
 */
function estatly_find_flat_term( $taxonomy, $name ) {
	$term = get_term_by( 'name', $name, $taxonomy );
	return $term ? (int) $term->term_id : 0;
}

/**
 * Dummy listing definitions.
 *
 * 'type' is the property_type path, 'location' is the property_location path.
 * 'fields' maps ACF field names to values.
 *
 * @return array
 */
function estatly_get_dummy_properties() {
	return array(
		array(
			'key'       => 'dummy-1',
			'title'     => 'Modern 10 Marla House with Private Pool',
			'type'      => array( 'Residential', 'House' ),
			'location'  => array( 'Lahore', 'DHA Lahore', 'Phase 6' ),
			'status'    => 'For Sale',
			'label'     => 'Featured',
			'amenities' => array( 'Swimming Pool', 'Gym', 'Security System', 'Garden', 'WiFi', 'Central AC' ),
			'fields'    => array(
				'prop_price' => 85000000, 'prop_area' => 2800, 'prop_parking' => 2, 'prop_year_built' => 2022, 'prop_listed_by' => 'owner',
				'prop_beds' => 4, 'prop_baths' => 4, 'prop_living_rooms' => 1, 'prop_kitchens' => 1,
				'prop_address' => 'House 12, Street 5, DHA Phase 6, Lahore', 'prop_lat' => 31.4697, 'prop_lng' => 74.4112,
			),
		),
		array(
			'key'       => 'dummy-2',
			'title'     => 'Spacious Family House with Garden',
			'type'      => array( 'Residential', 'House' ),
			'location'  => array( 'Islamabad', 'E-11' ),
			'status'    => 'For Sale',
			'label'     => 'Featured',
			'amenities' => array( 'Garden', 'Security System', 'Parking', 'WiFi' ),
			'fields'    => array(
				'prop_price' => 78000000, 'prop_area' => 4000, 'prop_parking' => 3, 'prop_year_built' => 2019, 'prop_listed_by' => 'agent',
				'prop_beds' => 5, 'prop_baths' => 5, 'prop_living_rooms' => 2, 'prop_kitchens' => 2,
				'prop_address' => 'Street 14, E-11/2, Islamabad', 'prop_lat' => 33.6844, 'prop_lng' => 72.9800,
			),
		),
		array(
			'key'       => 'dummy-3',
			'title'     => 'Elegant 1 Kanal House',
			'type'      => array( 'Residential', 'House' ),
			'location'  => array( 'Lahore', 'DHA Lahore', 'Phase 5' ),
			'status'    => 'For Sale',
			'label'     => '',
			'amenities' => array( 'Swimming Pool', 'Garden', 'Security System', 'Central AC' ),
			'fields'    => array(
				'prop_price' => 145000000, 'prop_area' => 4500, 'prop_parking' => 4, 'prop_year_built' => 2021, 'prop_listed_by' => 'owner',
				'prop_beds' => 5, 'prop_baths' => 6, 'prop_living_rooms' => 2, 'prop_kitchens' => 2,
				'prop_address' => 'House 40, Street 9, DHA Phase 5, Lahore', 'prop_lat' => 31.4750, 'prop_lng' => 74.4000,
			),
		),
		array(
			'key'       => 'dummy-4',
			'title'     => 'Modern 5 Marla House',
			'type'      => array( 'Residential', 'House' ),
			'location'  => array( 'Lahore', 'Bahria Town', 'Sector C' ),
			'status'    => 'For Rent',
			'label'     => '',
			'amenities' => array( 'Security System', 'Parking', 'WiFi' ),
			'fields'    => array(
				'prop_price' => 110000, 'prop_area' => 1250, 'prop_parking' => 1, 'prop_year_built' => 2020, 'prop_listed_by' => 'owner',
				'prop_beds' => 3, 'prop_baths' => 3, 'prop_living_rooms' => 1, 'prop_kitchens' => 1,
				'prop_address' => 'Street 3, Sector C, Bahria Town, Lahore', 'prop_lat' => 31.3650, 'prop_lng' => 74.1800,
			),
		),
		array(
			'key'       => 'dummy-5',
			'title'     => 'Luxury Apartment with Sea View',
			'type'      => array( 'Residential', 'Apartment' ),
			'location'  => array( 'Karachi', 'Clifton', 'Block 8' ),
			'status'    => 'For Rent',
			'label'     => 'Featured',
			'amenities' => array( 'Gym', 'Security System', 'Parking', 'Central AC', 'WiFi' ),
			'fields'    => array(
				'prop_price' => 120000, 'prop_area' => 1800, 'prop_parking' => 1, 'prop_year_built' => 2018, 'prop_listed_by' => 'agent',
				'prop_beds' => 3, 'prop_baths' => 3, 'prop_living_rooms' => 1, 'prop_kitchens' => 1,
				'prop_address' => 'Block 8, Clifton, Karachi', 'prop_lat' => 24.8138, 'prop_lng' => 67.0300,
			),
		),
		array(
			'key'       => 'dummy-6',
			'title'     => 'Stylish 2 Bed Apartment',
			'type'      => array( 'Residential', 'Apartment' ),
			'location'  => array( 'Karachi', 'DHA Karachi', 'Phase 6' ),
			'status'    => 'For Sale',
			'label'     => '',
			'amenities' => array( 'Gym', 'Security System', 'Elevator', 'Parking' ),
			'fields'    => array(
				'prop_price' => 32000000, 'prop_area' => 1600, 'prop_parking' => 1, 'prop_year_built' => 2023, 'prop_listed_by' => 'agent',
				'prop_beds' => 2, 'prop_baths' => 2, 'prop_living_rooms' => 1, 'prop_kitchens' => 1,
				'prop_address' => 'Khayaban-e-Shahbaz, DHA Phase 6, Karachi', 'prop_lat' => 24.8000, 'prop_lng' => 67.0600,
			),
		),
		array(
			'key'       => 'dummy-7',
			'title'     => 'Retail Shop on Main Boulevard',
			'type'      => array( 'Commercial', 'Shop' ),
			'location'  => array( 'Lahore', 'Gulberg', 'Gulberg III' ),
			'status'    => 'For Rent',
			'label'     => 'Featured',
			'amenities' => array( 'Security System', 'Parking', 'Central AC' ),
			'fields'    => array(
				'prop_price' => 250000, 'prop_area' => 1200, 'prop_parking' => 0, 'prop_year_built' => 2017, 'prop_listed_by' => 'owner',
				'prop_floor_level' => 'ground', 'prop_building_floors' => 4, 'prop_washrooms' => 1,
				'prop_address' => 'Main Boulevard, Gulberg III, Lahore', 'prop_lat' => 31.5100, 'prop_lng' => 74.3430,
			),
		),
		array(
			'key'       => 'dummy-8',
			'title'     => 'Corporate Office on 3rd Floor',
			'type'      => array( 'Commercial', 'Office' ),
			'location'  => array( 'Islamabad', 'F-8' ),
			'status'    => 'For Rent',
			'label'     => '',
			'amenities' => array( 'Central AC', 'Security System', 'Elevator', 'Backup Generator', 'WiFi', 'Parking' ),
			'fields'    => array(
				'prop_price' => 180000, 'prop_area' => 2400, 'prop_parking' => 2, 'prop_year_built' => 2019, 'prop_listed_by' => 'agent',
				'prop_floor_level' => '3', 'prop_building_floors' => 8, 'prop_washrooms' => 3,
				'prop_rooms' => 6, 'prop_pantry' => 1,
				'prop_address' => 'Jinnah Super Market, F-8 Markaz, Islamabad', 'prop_lat' => 33.7100, 'prop_lng' => 73.0370,
			),
		),
		array(
			'key'       => 'dummy-9',
			'title'     => 'Commercial Office Space for Sale',
			'type'      => array( 'Commercial', 'Office' ),
			'location'  => array( 'Lahore', 'Gulberg', 'Gulberg III' ),
			'status'    => 'For Sale',
			'label'     => '',
			'amenities' => array( 'Central AC', 'Security System', 'Elevator', 'Backup Generator', 'Parking' ),
			'fields'    => array(
				'prop_price' => 95000000, 'prop_area' => 3200, 'prop_parking' => 3, 'prop_year_built' => 2021, 'prop_listed_by' => 'agent',
				'prop_floor_level' => '5', 'prop_building_floors' => 10, 'prop_washrooms' => 4,
				'prop_rooms' => 8, 'prop_pantry' => 1,
				'prop_address' => 'Gulberg III, Lahore', 'prop_lat' => 31.5160, 'prop_lng' => 74.3500,
			),
		),
		array(
			'key'       => 'dummy-10',
			'title'     => 'Industrial Warehouse Space',
			'type'      => array( 'Commercial', 'Warehouse' ),
			'location'  => array( 'Karachi', 'Korangi' ),
			'status'    => 'For Rent',
			'label'     => '',
			'amenities' => array( 'Security System', 'Backup Generator', 'Parking' ),
			'fields'    => array(
				'prop_price' => 400000, 'prop_area' => 8000, 'prop_parking' => 2, 'prop_year_built' => 2016, 'prop_listed_by' => 'owner',
				'prop_floor_level' => 'ground', 'prop_building_floors' => 1, 'prop_washrooms' => 2,
				'prop_address' => 'Korangi Industrial Area, Karachi', 'prop_lat' => 24.8300, 'prop_lng' => 67.1300,
			),
		),
	);
}

/**
 * Download a pool of placeholder images (once) and return their attachment IDs.
 *
 * @param int $count Number of images.
 * @return int[]
 */

/**
 * Download a curated pool of real-estate photos for dummy listings.
 *
 * @param int $count Number of images to download.
 * @return int[] Attachment IDs.
 */
function estatly_seed_image_pool( $count = 8 ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Curated real-estate photography instead of random Picsum images.
	$image_urls = array(
		'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1600&q=85',
		'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1600&q=85',
	);

	$count = min( $count, count( $image_urls ) );

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'meta_key'       => '_estatly_dummy_image',
			'fields'         => 'ids',
			'posts_per_page' => $count,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		)
	);

	if ( count( $existing ) >= $count ) {
		return array_map( 'intval', $existing );
	}

	$ids = array_map( 'intval', $existing );

	foreach ( $image_urls as $index => $url ) {
		if ( count( $ids ) >= $count ) {
			break;
		}

		$tmp = download_url( $url, 30 );

		if ( is_wp_error( $tmp ) ) {
			WP_CLI::warning(
				'Image download failed: ' . $tmp->get_error_message()
			);
			continue;
		}

		$file = array(
			'name'     => 'estatly-property-' . ( $index + 1 ) . '.jpg',
			'tmp_name' => $tmp,
		);

		$id = media_handle_sideload(
			$file,
			0,
			'Estatly Property Photo ' . ( $index + 1 )
		);

		if ( is_wp_error( $id ) ) {
			@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			WP_CLI::warning(
				'Image import failed: ' . $id->get_error_message()
			);
			continue;
		}

		update_post_meta( $id, '_estatly_dummy_image', 1 );
		$ids[] = (int) $id;
	}

	return $ids;
}
/**
 * Delete every dummy listing and placeholder image.
 *
 * @return int Number of posts deleted.
 */
function estatly_clean_dummy_properties() {
	$deleted = 0;

	$posts = get_posts(
		array(
			'post_type'      => array( 'property', 'attachment' ),
			'post_status'    => 'any',
			'meta_query'     => array(
				'relation' => 'OR',
				array(
					'key'     => '_estatly_dummy_key',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => '_estatly_dummy_image',
					'compare' => 'EXISTS',
				),
			),
			'fields'         => 'ids',
			'posts_per_page' => -1,
		)
	);

	foreach ( $posts as $post_id ) {
		if ( wp_delete_post( $post_id, true ) ) {
			++$deleted;
		}
	}

	return $deleted;
}

/**
 * Create the dummy listings.
 *
 * @param bool $with_images Whether to attach placeholder images.
 * @return int Number of listings created.
 */
function estatly_seed_properties( $with_images = false ) {
	$created = 0;
	$pool    = $with_images ? estatly_seed_image_pool( 8 ) : array();
	$pool_n  = count( $pool );
	$index   = 0;

	foreach ( estatly_get_dummy_properties() as $data ) {
		++$index;

		$exists = get_posts(
			array(
				'post_type'      => 'property',
				'post_status'    => 'any',
				'meta_key'       => '_estatly_dummy_key',
				'meta_value'     => $data['key'],
				'fields'         => 'ids',
				'posts_per_page' => 1,
			)
		);

		if ( ! empty( $exists ) ) {
			WP_CLI::log( 'Skipping (already exists): ' . $data['title'] );
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'property',
				'post_status'  => 'publish',
				'post_title'   => $data['title'],
				'post_content' => 'This is placeholder content for development. A well-presented property in a sought-after location, ideal for families and investors alike.' . "\n\n" . 'Replace this description with real listing details before launch.',
				'post_excerpt' => 'Placeholder listing for development.',
				'post_date'    => gmdate( 'Y-m-d H:i:s', time() - ( $index * DAY_IN_SECONDS ) ),
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( 'Could not create: ' . $data['title'] );
			continue;
		}

		update_post_meta( $post_id, '_estatly_dummy_key', $data['key'] );

		// Terms first: ACF conditional groups depend on the assigned terms.
		$type_ids = estatly_find_term_path( 'property_type', $data['type'] );
		if ( $type_ids ) {
			wp_set_object_terms( $post_id, $type_ids, 'property_type' );
		} else {
			WP_CLI::warning( 'Missing property type: ' . implode( ' > ', $data['type'] ) );
		}

		$loc_ids = estatly_find_term_path( 'property_location', $data['location'] );
		if ( $loc_ids ) {
			wp_set_object_terms( $post_id, $loc_ids, 'property_location' );
		} else {
			WP_CLI::warning( 'Missing location: ' . implode( ' > ', $data['location'] ) );
		}

		$status_id = estatly_find_flat_term( 'listing_status', $data['status'] );
		if ( $status_id ) {
			wp_set_object_terms( $post_id, array( $status_id ), 'listing_status' );
		} else {
			WP_CLI::warning( 'Missing listing status: ' . $data['status'] );
		}

		$amenity_ids = array();
		foreach ( $data['amenities'] as $amenity ) {
			$amenity_id = estatly_find_flat_term( 'property_amenity', $amenity );
			if ( $amenity_id ) {
				$amenity_ids[] = $amenity_id;
			}
		}
		if ( $amenity_ids ) {
			wp_set_object_terms( $post_id, $amenity_ids, 'property_amenity' );
		}

		// Optional "Featured" label, only if that taxonomy has been registered.
		if ( ! empty( $data['label'] ) && taxonomy_exists( 'property_label' ) ) {
			wp_set_object_terms( $post_id, array( $data['label'] ), 'property_label' );
		}

		// ACF fields.
		if ( function_exists( 'update_field' ) ) {
			foreach ( $data['fields'] as $name => $value ) {
				update_field( $name, $value, $post_id );
			}
		} else {
			WP_CLI::warning( 'ACF is not active: fields were not saved.' );
		}

		// Images.
		if ( $pool_n > 0 ) {
			$featured = $pool[ ( $index - 1 ) % $pool_n ];
			set_post_thumbnail( $post_id, $featured );

			$gallery = array();
			for ( $g = 0; $g < min( 6, $pool_n ); $g++ ) {
				$gallery[] = $pool[ ( $index + $g ) % $pool_n ];
			}

			if ( function_exists( 'update_field' ) ) {
				update_field( 'prop_gallery', $gallery, $post_id );

				$is_residential = in_array( 'Residential', $data['type'], true );
				if ( $is_residential ) {
					update_field(
						'prop_floor_plans',
						array(
							array(
								'label' => 'Ground Floor',
								'image' => $pool[ ( $index + 1 ) % $pool_n ],
							),
							array(
								'label' => 'First Floor',
								'image' => $pool[ ( $index + 2 ) % $pool_n ],
							),
						),
						$post_id
					);
				}
			}
		}

		++$created;
		WP_CLI::log( 'Created: ' . $data['title'] );
	}

	return $created;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command(
		'estatly seed-properties',
		function ( $args, $assoc_args ) {
			if ( isset( $assoc_args['clean'] ) ) {
				$deleted = estatly_clean_dummy_properties();
				WP_CLI::success( sprintf( '%d dummy posts and images deleted.', $deleted ) );
				return;
			}

			$with_images = isset( $assoc_args['images'] );
			$created     = estatly_seed_properties( $with_images );
			WP_CLI::success( sprintf( '%d dummy listings created.', $created ) );
		}
	);
}