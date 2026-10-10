<?php
/**
 * Registers the "property" custom post type.
 *
 * @package Estatly_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatly_register_property_cpt() {

	$labels = array(
		'name'                  => _x( 'Properties', 'Post type general name', 'estatly-core' ),
		'singular_name'         => _x( 'Property', 'Post type singular name', 'estatly-core' ),
		'menu_name'             => _x( 'Properties', 'Admin Menu text', 'estatly-core' ),
		'add_new_item'          => __( 'Add New Property', 'estatly-core' ),
		'edit_item'             => __( 'Edit Property', 'estatly-core' ),
		'new_item'              => __( 'New Property', 'estatly-core' ),
		'view_item'             => __( 'View Property', 'estatly-core' ),
		'view_items'            => __( 'View Properties', 'estatly-core' ),
		'search_items'          => __( 'Search Properties', 'estatly-core' ),
		'not_found'             => __( 'No properties found.', 'estatly-core' ),
		'not_found_in_trash'    => __( 'No properties found in Trash.', 'estatly-core' ),
		'all_items'             => __( 'All Properties', 'estatly-core' ),
		'archives'              => __( 'Property Archives', 'estatly-core' ),
		'featured_image'        => __( 'Property Cover Image', 'estatly-core' ),
		'set_featured_image'    => __( 'Set cover image', 'estatly-core' ),
		'remove_featured_image' => __( 'Remove cover image', 'estatly-core' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'has_archive'         => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-admin-home',
		'menu_position'       => 5,
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'             => array(
			'slug'       => 'properties',
			'with_front' => false,
		),
		'capability_type'     => 'post',
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
	);

	register_post_type( 'property', $args );
}
add_action( 'init', 'estatly_register_property_cpt' );

function estatly_property_admin_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $label ) {
		$new_columns[ $key ] = $label;

		if ( 'title' === $key ) {
			$new_columns['prop_price']     = __( 'Price', 'estatly-core' );
			$new_columns['listing_status'] = __( 'Status', 'estatly-core' );
		}
	}

	return $new_columns;
}
add_filter( 'manage_property_posts_columns', 'estatly_property_admin_columns' );

function estatly_property_admin_column_content( $column, $post_id ) {
	if ( 'prop_price' === $column ) {
		$price = function_exists( 'get_field' ) ? get_field( 'prop_price', $post_id ) : '';
		echo $price ? esc_html( number_format_i18n( (float) $price ) ) : '—';
	}

	if ( 'listing_status' === $column ) {
		$terms = get_the_terms( $post_id, 'listing_status' );
		echo ( $terms && ! is_wp_error( $terms ) ) ? esc_html( $terms[0]->name ) : '—';
	}
}
add_action( 'manage_property_posts_custom_column', 'estatly_property_admin_column_content', 10, 2 );