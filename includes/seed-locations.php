<?php
/**
 * WP-CLI seeder for the property_location taxonomy.
 *
 * Usage: wp estatly seed-locations
 *
 * Safe to run more than once: existing terms are skipped, not duplicated.
 *
 * @package Estatly_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * City => Area => Sub-areas. Areas with no sub-areas use an empty array.
 * Edit this list to match the client's markets.
 *
 * @return array
 */
function estatly_get_location_data() {
	return array(
		'Lahore'     => array(
			'DHA Lahore'      => array( 'Phase 1', 'Phase 2', 'Phase 3', 'Phase 4', 'Phase 5', 'Phase 6', 'Phase 7', 'Phase 8', 'Phase 9 Prism' ),
			'Bahria Town'     => array( 'Sector A', 'Sector B', 'Sector C', 'Sector D', 'Sector E', 'Sector F' ),
			'Gulberg'         => array( 'Gulberg I', 'Gulberg II', 'Gulberg III', 'Gulberg IV', 'Gulberg V' ),
			'Johar Town'      => array( 'Phase 1', 'Phase 2' ),
			'Model Town'      => array(),
			'Wapda Town'      => array(),
			'Valencia Town'   => array(),
			'Faisal Town'     => array(),
			'Iqbal Town'      => array(),
			'Lahore Cantt'    => array(),
			'Askari'          => array(),
			'Garden Town'     => array(),
			'Allama Iqbal Town' => array(),
		),
		'Karachi'    => array(
			'DHA Karachi'     => array( 'Phase 1', 'Phase 2', 'Phase 4', 'Phase 5', 'Phase 6', 'Phase 7', 'Phase 8' ),
			'Clifton'         => array( 'Block 2', 'Block 4', 'Block 5', 'Block 7', 'Block 8', 'Block 9' ),
			'Bahria Town Karachi' => array(),
			'Gulshan-e-Iqbal' => array(),
			'Gulistan-e-Johar' => array(),
			'North Nazimabad' => array(),
			'PECHS'           => array(),
			'Scheme 33'       => array(),
			'Malir'           => array(),
			'Korangi'         => array(),
		),
		'Islamabad'  => array(
			'F-6'             => array(),
			'F-7'             => array(),
			'F-8'             => array(),
			'F-10'            => array(),
			'F-11'            => array(),
			'G-6'             => array(),
			'G-9'             => array(),
			'G-10'            => array(),
			'G-11'            => array(),
			'E-11'            => array(),
			'DHA Islamabad'   => array(),
			'Bahria Enclave'  => array(),
			'Gulberg Greens'  => array(),
			'B-17'            => array(),
		),
		'Rawalpindi' => array(
			'Bahria Town Rawalpindi' => array(),
			'DHA Rawalpindi'  => array(),
			'Satellite Town'  => array(),
			'Chaklala Scheme III' => array(),
			'Saddar'          => array(),
		),
		'Faisalabad' => array(),
		'Multan'     => array(),
		'Peshawar'   => array(),
		'Quetta'     => array(),
	);
}

/**
 * Create a term under a parent if it doesn't already exist.
 *
 * @param string $name      Term name.
 * @param int    $parent_id Parent term ID (0 for top level).
 * @return int Term ID, or 0 on failure.
 */
function estatly_seed_term( $name, $parent_id = 0 ) {
	$existing = term_exists( $name, 'property_location', $parent_id );

	if ( $existing ) {
		return (int) ( is_array( $existing ) ? $existing['term_id'] : $existing );
	}

	$result = wp_insert_term(
		$name,
		'property_location',
		array( 'parent' => $parent_id )
	);

	return is_wp_error( $result ) ? 0 : (int) $result['term_id'];
}

/**
 * Seed all locations.
 *
 * @return int Number of terms processed.
 */
function estatly_seed_locations() {
	$count = 0;

	foreach ( estatly_get_location_data() as $city => $areas ) {
		$city_id = estatly_seed_term( $city );
		++$count;

		if ( ! $city_id ) {
			continue;
		}

		foreach ( $areas as $area => $subareas ) {
			$area_id = estatly_seed_term( $area, $city_id );
			++$count;

			if ( ! $area_id ) {
				continue;
			}

			foreach ( $subareas as $subarea ) {
				estatly_seed_term( $subarea, $area_id );
				++$count;
			}
		}
	}

	return $count;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command(
		'estatly seed-locations',
		function () {
			$count = estatly_seed_locations();
			WP_CLI::success( sprintf( '%d location terms processed.', $count ) );
		}
	);
}