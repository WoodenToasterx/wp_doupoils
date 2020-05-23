<?php //Pro Details
function quality_pro_feature_customizer( $wp_customize ) {
class WP_Pro__Feature_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    public function render_content() {
    ?>
    <div class="quality-pro-features-customizer">
    <ul class="quality-pro-features">
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Advance Theme Style Settings','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Slider Settings','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Portfolio Management','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Testimonial Section','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Team Section','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Client Section','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Shop Section','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Footer Callout Section','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Section Reordering','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Multiple Page Templates','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Typography Settings','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Support for WPML / Polylang','quality' ); ?>
        </li>
        <li>
            <span class="quality-pro-label"><?php _e( 'PRO','quality' ); ?></span>
            <?php _e( 'Quality Support','quality' ); ?>
        </li>
    </ul>
    <a target="_blank" href="<?php echo 'https://webriti.com/quality/';?>" class="quality-pro-button button-primary"><?php _e( 'UPGRADE TO PRO','quality' ); ?></a>
    <hr>
</div>
    <?php
    }
}
$wp_customize->add_section( 'quality_pro_feature_section' , array(
		'title'      => __('View PRO Details', 'quality'),
		'priority'   => 1,
   	) );

$wp_customize->add_setting(
    'upgrade_pro_feature',
    array(
        'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
    )	
);
$wp_customize->add_control( new WP_Pro__Feature_Customize_Control( $wp_customize, 'upgrade_pro_feature', array(
		'section' => 'quality_pro_feature_section',
		'setting' => 'upgrade_pro_feature',
    ))
);
class WP_Feature_document_Customize_Control extends WP_Customize_Control {
    public $type = 'new_menu';
    /**
    * Render the control's content.
    */
    public function render_content() {
    ?>
   
     <div class="quality-pro-content">
        <ul class="quality-pro-des">
            <li> 
                <?php _e('Select among predefined color skins, you can even create yours without writing any CSS code.','quality');?>
            </li>
            <li> 
                <?php _e('Pro version theme comes with add multiple slides in slider and you can select the slider enable / disable option, slider animation etc.','quality');?>
            </li>
            <li> 
                <?php _e('Portfolio section, templates , archives with 3 possible layouts.','quality');?>
            </li>
            <li> 
                <?php _e('Show all your testimonials, team members, clients and Shop products on the frontpage.','quality');?>
            </li>
            <li> 
                <?php _e('Pro version theme comes with footer callout section, In this section you can manage the section and button setting.','quality');?>
            </li>
            <li> 
                <?php _e('Theme Layout manager will helps you to rearrange the sections.','quality');?>
            </li>
            <li> 
                <?php _e('Theme comes with multiple page settings like about us, service, contact etc.','quality');?>
            </li>
            <li> 
                <?php _e('Typography will helps you to manage custom fonts like paragraph font, menu font etc.','quality');?>
            </li>
            <li> 
                <?php _e('Translation ready supporting popular plugins WPML / Polylang.','quality');?>
            </li>
            <li> 
                <?php _e('Dedicated support, various widget and sidebar management.','quality');?>
            </li>
        </ul>
     </div>
    <?php
    }
}

$wp_customize->add_setting(
    'doc_Review_feature',
    array(
        'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
    )	
);
$wp_customize->add_control( new WP_Feature_document_Customize_Control( $wp_customize, 'doc_Review_feature', array(	
		'section' => 'quality_pro_feature_section',
		'setting' => 'doc_Review_feature',
    ))
);

}
add_action( 'customize_register', 'quality_pro_feature_customizer' );
?>