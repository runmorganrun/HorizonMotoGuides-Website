<?php
/**
 * Site-wide settings: Appearance → Customize → Horizon Moto Settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hm_customizer_settings() {
	return array(
		'contact' => array(
			'title'    => 'Contact details',
			'settings' => array(
				'address'      => array( 'Address', "HORIZON MOTO GUIDES HQ,\nColorado, USA", 'textarea' ),
				'phone'        => array( 'Phone', '+1 (719) 459-5456', 'text' ),
				'email'        => array( 'Public email', 'rides@horizonmotoguides.com', 'email' ),
				'hours'        => array( 'Hours', 'Daily: 8:00 AM – 6:00 PM MST', 'text' ),
				'support_line' => array( 'Booking page support line', '555-HORIZON', 'text' ),
			),
		),
		'footer'  => array(
			'title'    => 'Footer and social',
			'settings' => array(
				'footer_text' => array( 'Footer description', 'Professional motorcycle guide services for the Colorado Rockies. Expertly led tours, custom route planning, and unforgettable alpine adventures for every rider.', 'textarea' ),
				'instagram'   => array( 'Instagram URL', '', 'url' ),
				'facebook'    => array( 'Facebook URL', '', 'url' ),
			),
		),
		'forms'   => array(
			'title'    => 'Form emails',
			'settings' => array(
				'form_email' => array( 'Send booking requests and ride suggestions to', '', 'email', 'Leave blank to use the WordPress admin email.' ),
			),
		),
	);
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel( 'hm_panel', array(
		'title'    => 'Horizon Moto Settings',
		'priority' => 30,
	) );
	foreach ( hm_customizer_settings() as $section_id => $section ) {
		$wp_customize->add_section( 'hm_' . $section_id, array(
			'title' => $section['title'],
			'panel' => 'hm_panel',
		) );
		foreach ( $section['settings'] as $key => $s ) {
			$sanitize = 'sanitize_text_field';
			if ( 'textarea' === $s[2] ) {
				$sanitize = 'sanitize_textarea_field';
			} elseif ( 'email' === $s[2] ) {
				$sanitize = 'sanitize_email';
			} elseif ( 'url' === $s[2] ) {
				$sanitize = 'esc_url_raw';
			}
			$wp_customize->add_setting( 'hm_' . $key, array(
				'default'           => $s[1],
				'sanitize_callback' => $sanitize,
			) );
			$wp_customize->add_control( 'hm_' . $key, array(
				'label'       => $s[0],
				'section'     => 'hm_' . $section_id,
				'type'        => $s[2],
				'description' => isset( $s[3] ) ? $s[3] : '',
			) );
		}
	}
} );

/** Customizer value with the default from the settings list. */
function hm_setting( $key ) {
	foreach ( hm_customizer_settings() as $section ) {
		if ( isset( $section['settings'][ $key ] ) ) {
			return hm_opt( $key, $section['settings'][ $key ][1] );
		}
	}
	return hm_opt( $key );
}
