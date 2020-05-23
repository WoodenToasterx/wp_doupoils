<?php
$repeater_path = trailingslashit( get_template_directory() ) . '/functions/customizer-repeater/functions.php';
if ( file_exists( $repeater_path ) ) {
require_once( $repeater_path );
}

function quality_client_customizer( $wp_customize ) {
//Front Client section
	
	$wp_customize->add_section(
        'client_section_settings',
        array(
            'title' => __('Clients settings','quality'),
            'description' => '',
			'priority'       => 755)
    );
	
	// Enable client section
	$wp_customize->add_setting( 'client_section_enable' , array( 'default' => 'on','sanitize_callback' => 'sanitize_text_field',) );
	$wp_customize->add_control(	'client_section_enable' , array(
					'label'    => __( 'Enable Home Client section', 'quality' ),
					'section'  => 'client_section_settings',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'quality'),
						'off'=>__('OFF', 'quality')
					)
	));
	
	
	if ( class_exists( 'Quality_Repeater' ) ) {
			$wp_customize->add_setting(
				'quality_clients_content', array(
				'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				new Quality_Repeater(
					$wp_customize, 'quality_clients_content', array(
						'label'                            => esc_html__( 'Clients content', 'quality' ),
						'section'                          => 'client_section_settings',
						'add_field_label'                  => esc_html__( 'Add new client', 'quality' ),
						'item_name'                        => esc_html__( 'Clients', 'quality' ),
						'customizer_repeater_image_control' => true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_checkbox_control' => true,
					)
				)
			);
		}
		

		$wp_customize->add_setting(
		'quality_pro_options[client_animationSpeed]',
		array(
			'default' => '3000',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			
		)
		);

		$wp_customize->add_control(
		'quality_pro_options[client_animationSpeed]',
		array(
			'type' => 'select',
			'label' => __('Animation speed','quality'),
			'section' => 'client_section_settings',
			'priority'   => 300,
			 'choices' => array( '2000'=>'2.0',
						'3000'=>'3.0',
						'4000'=>'4.0',
						'5000'=>'5.0',
						'6000'=>'6.0' )));	
						
		$wp_customize->add_setting(
		'quality_pro_options[client_smoothSpeed]',
		array(
			'default' => '1000',
			'type' => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			
		)
		);

	$wp_customize->add_control(
    'quality_pro_options[client_smoothSpeed]',
    array(
        'type' => 'select',
        'label' => __('Smooth speed','quality'),
        'section' => 'client_section_settings',
		'priority'   => 300,
		'choices' => array( '500'=>'0.5',
					'1000'=>'1.0',
					'1500'=>'1.5',
					'2000'=>'2.0',
					'2500'=>'2.5',
					'3000'=>'3.0')));	
		
	
	}
	add_action( 'customize_register', 'quality_client_customizer' );
	
/**
 * Add selective refresh for Front page section section controls.
*/
function quality_register_client_section_partials( $wp_customize ){
	
	$wp_customize->selective_refresh->add_partial( 'quality_clients_content', array(
		'selector'            => '#clients-carousel',
		'settings'            => 'quality_clients_content',
	
	) );
}

add_action( 'customize_register', 'quality_register_client_section_partials' );
	?>