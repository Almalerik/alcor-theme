<?php
require_once 'wordpress-theme-customizer-custom-controls/layout/layout-picker-custom-control.php';
require_once 'wordpress-theme-customizer-custom-controls/select/google-font-dropdown-custom-control.php';
/**
 * alcor Theme Customizer.
 *
 * @package alcor
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize
 *        	Theme Customizer object.
 */
function alcor_customize_register($wp_customize) {
	$wp_customize->get_setting ( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting ( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting ( 'header_textcolor' )->transport = 'postMessage';
	
	$alcor = new Alcor_Theme ();
	
	// ===== Site Identity =====
	$wp_customize->add_setting ( 'alcor[logo]', array (
			'default' => $alcor->get_setting ( "logo" ),
			'type' => 'option',
			'capability' => 'edit_theme_options' 
	) );
	$wp_customize->add_control ( new WP_Customize_Image_Control ( $wp_customize, 'alcor_logo', array (
			'label' => __ ( 'Site logo', 'themename' ),
			'section' => 'title_tagline',
			'settings' => 'alcor[logo]',
			'priority' => 100 
	) ) );
	
	// ===== Alcor Layout =====
	$wp_customize->add_section ( 'alcor_layout', array (
			'title' => esc_attr__ ( 'Layout', 'alcor' ),
			'capability' => 'edit_theme_options',
			'priority' => 30
	) );
	// container_class
	$wp_customize->add_setting ( 'alcor[container_class]', array (
			'default' => $alcor->get_setting ( 'container_class' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
	) );
	$wp_customize->add_control ( 'alcor_container_class', array (
			'label' => esc_attr__ ( 'Container', 'alcor' ),
			'section' => 'alcor_layout',
			'settings' => 'alcor[container_class]',
			'type' => 'radio',
			'choices' => array (
					'container-fluid' => esc_attr__ ( 'Responsive fluid', 'alcor' ),
					'container' => esc_attr__ ( 'Responsive fixed', 'alcor' )
			),
			'priority' => 100
	) );
	// fixed container max width
	$wp_customize->add_setting ( 'alcor[container_class_fixed_max_width]', array (
			'default' => $alcor->get_setting ( 'container_class_fixed_max_width' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_css_number',
	) );
	$wp_customize->add_control ( 'alcor_container_class_fixed_max_width', array (
			'label' => esc_attr__ ( 'Fixed container max width', 'alcor' ),
			'description' => __( 'Define also the unit system like px,% ...', 'alcor' ),
			'section' => 'alcor_layout',
			'settings' => 'alcor[container_class_fixed_max_width]',
			'type' => 'text',
			'priority' => 200
	) );
	// Sidebar layout
	$wp_customize->add_setting ( 'alcor[page_layout]', array (
			'default' => $alcor->get_setting ( 'page_layout' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
	) );
	$wp_customize->add_control ( new Layout_Picker_Custom_Control ( $wp_customize, 'alcor_page_layout', array (
			'label' => __ ( 'Page layout', 'alcor' ),
			'section' => 'alcor_layout',
			'settings' => 'alcor[page_layout]',
			'priority' => 300
	) ) );
	$wp_customize->add_setting ( 'alcor[hide_homepage_sidebar]', array (
			'default' => $alcor->get_setting ( 'hide_homepage_sidebar' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
	) );
	$wp_customize->add_control ( 'alcor_hide_homepage_sidebar', array (
			'label' => __ ( 'Hide sidebar in homepage', 'alcor' ),
			'section' => 'alcor_layout',
			'settings' => 'alcor[hide_homepage_sidebar]',
			'type' => 'checkbox',
			'priority' => 400
	) );
	$wp_customize->add_setting ( 'alcor[sidebar_width]', array (
			'default' => $alcor->get_setting ( 'sidebar_width' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
	) );
	
	// Add control and output for select field
	$wp_customize->add_control ( 'alcor_sidebar_width', array (
			'label' => esc_attr__ ( 'Sidebar With', 'alcor' ),
			'section' => 'alcor_layout',
			'settings' => 'alcor[sidebar_width]',
			'type' => 'select',
			'choices' => array (
					'1' => esc_attr__ ( '1/12', 'alcor' ),
					'2' => esc_attr__ ( '2/12', 'alcor' ),
					'3' => esc_attr__ ( '3/12', 'alcor' ),
					'4' => esc_attr__ ( '4/12', 'alcor' ),
					'5' => esc_attr__ ( '5/12', 'alcor' ),
					'6' => esc_attr__ ( '6/12', 'alcor' )
			),
			'priority' => 500
	) );
	
	// ===== Alcor Header =====
	$wp_customize->add_panel ( 'alcor_header', array (
			'title' => esc_attr__ ( 'Header', 'alcor' ),
			'description' => esc_attr__ ( 'Alcor Header', 'alcor' ),
			'priority' => 40 
	) );
	$wp_customize->add_section ( 'alcor_header_options', array (
			'title' => esc_attr__ ( 'Options', 'alcor' ),
			'capability' => 'edit_theme_options',
			'panel' => 'alcor_header',
			'priority' => 10 
	) );
	// Header fixed top
	$wp_customize->add_setting ( 'alcor[header_fixed_top]', array (
			'default' => $alcor->get_setting ( 'header_fixed_top' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage' 
	) );
	$wp_customize->add_control ( 'alcor_header_fixed_top', array (
			'label' => esc_attr__ ( 'Position', 'alcor' ),
			'section' => 'alcor_header_options',
			'settings' => 'alcor[header_fixed_top]',
			'type' => 'select',
			'choices' => array (
					'' => __ ( 'Top', 'alcor' ),
					'navbar-fixed-top' => __ ( 'Fixed top', 'alcor' )
			),
			'priority' => 100 
	) );
	// Header background color
	$wp_customize->add_setting ( 'alcor[header_background_color]', array (
			'default' => $alcor->get_setting ( 'header_background_color' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage' 
	) );
	$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'alcor_header_background_color', array (
			'label' => __ ( 'Background color', 'alcor' ),
			'section' => 'alcor_header_options',
			'settings' => 'alcor[header_background_color]',
			'priority' => 200 
	) ) );
	// Header margin bottom
	$wp_customize->add_setting ( 'alcor[header_margin_bottom]', array (
			'default' => $alcor->get_setting ( 'header_margin_bottom' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
	) );
	$wp_customize->add_control ( 'alcor_header_margin_bottom', array (
			'label' => __ ( 'Margin bottom', 'alcor' ),
			'description' => __( 'Define also the unit system like px,% ...', 'alcor' ),
			'section' => 'alcor_header_options',
			'settings' => 'alcor[header_margin_bottom]',
			'sanitize_callback' => 'sanitize_css_number',
			'priority' => 300
	) );
	// ===== Alcor background image =====
	$wp_customize->add_setting ( 'alcor[header_image_show]', array (
			'default' => $alcor->get_setting ( 'header_image_show' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage' 
	) );
	$wp_customize->add_control ( 'alcor_header_image_show', array (
			'label' => __ ( 'Show header image', 'alcor' ),
			'section' => 'header_image',
			'settings' => 'alcor[header_image_show]',
			'type' => 'select',
			'choices' => array (
					'hidden' => __ ( 'Never', 'alcor' ),
					'homepage-only' => __ ( 'Only in hompage', 'alcor' ),
					'all' => __ ( 'Everywhere', 'alcor' )
			),
			'priority' => 1
	) );
	// ===== Alcor background image parallax =====
	$wp_customize->add_setting ( 'alcor[header_image_parallax]', array (
			'default' => $alcor->get_setting ( 'header_image_parallax' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
	) );
	$wp_customize->add_control ( 'alcor_header_image_parallax', array (
			'label' => __ ( 'Use scroll parallax effect', 'alcor' ),
			'section' => 'header_image',
			'settings' => 'alcor[header_image_parallax]',
			'type' => 'checkbox',
			'priority' => 2
	) );
	// ===== Alcor background image text =====
	$wp_customize->add_setting ( 'alcor[header_image_text]', array (
			'default' => $alcor->get_setting ( 'header_image_text' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
	) );
	$wp_customize->add_control ( 'alcor_header_image_text', array (
			'label' => __ ( 'Text', 'alcor' ),
			'section' => 'header_image',
			'settings' => 'alcor[header_image_text]',
			'priority' => 10
	) );
	// ===== Alcor background image text color =====
	$wp_customize->add_setting ( 'alcor[header_image_text_color]', array (
			'default' => $alcor->get_setting ( 'header_image_text_color' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
	) );
	$wp_customize->add_control ( new WP_Customize_Color_Control ( $wp_customize, 'alcor_header_image_text_color', array (
			'label' => __ ( 'Text color', 'alcor' ),
			'section' => 'header_image',
			'settings' => 'alcor[header_image_text_color]',
			'priority' => 20
	) ) );
	// ===== Alcor background image height =====
	$wp_customize->add_setting ( 'alcor[header_image_height]', array (
			'default' => $alcor->get_setting ( 'header_image_height' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_css_number',
	) );
	$wp_customize->add_control ( 'alcor_header_image_height', array (
			'label' => esc_attr__ ( 'Header image height', 'alcor' ),
			'description' => __( 'Define also the unit system like px,% ...', 'alcor' ),
			'section' => 'header_image',
			'settings' => 'alcor[header_image_height]',
			'type' => 'text',
			'priority' => 2
	) );
	//Header slider
	$wp_customize->add_section ( 'alcor_header_slider', array (
			'title' => esc_attr__ ( 'Slider', 'alcor' ),
			'capability' => 'edit_theme_options',
			'panel' => 'alcor_header',
			'priority' => 30
	) );
	$wp_customize->add_setting ( 'alcor[header_slider_show]', array (
			'default' => $alcor->get_setting ( 'header_slider_show' ),
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
	) );
	$wp_customize->add_control ( 'alcor_header_slider_show', array (
			'label' => __ ( 'Show slider', 'alcor' ),
			'section' => 'alcor_header_slider',
			'settings' => 'alcor[header_slider_show]',
			'type' => 'checkbox',
			'priority' => 1
	) );
	// ===== Alcor Style =====
	$wp_customize->add_panel ( 'alcor_style', array (
			'title' => esc_attr__ ( 'Styles', 'alcor' ),
			'description' => esc_attr__ ( 'Alcor Styles', 'alcor' ),
			'priority' => 50
	) );
	$wp_customize->add_section ( 'alcor_fonts', array (
			'title' => esc_attr__ ( 'Fonts', 'alcor' ),
			'capability' => 'edit_theme_options',
			'panel' => 'alcor_style',
			'priority' => 100
	) );
	
	// Font
	$wp_customize->add_setting ( 'alcor[body_font]', array (
			'default' => $alcor->get_setting ( 'body_font' ),
			'type' => 'option',
			'capability' => 'edit_theme_options'
	) );
	$wp_customize->add_control ( 'alcor_body_font', array (
			'label' => esc_attr__ ( 'General font family', 'alcor' ),
			'section' => 'alcor_fonts',
			'settings' => 'alcor[body_font]',
			'type' => 'select',
			'choices' => array (
					'Open Sans' => esc_attr__ ( 'Open Sans', 'alcor' ),
					'Roboto' => esc_attr__ ( 'Roboto', 'alcor' ),
					'Lato' => esc_attr__ ( 'Lato', 'alcor' ),
			),
			'priority' => 500
	) );


	

	

}
add_action ( 'customize_register', 'alcor_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alcor_customize_preview_js() {
	wp_enqueue_script ( 'alcor_customizer', get_template_directory_uri () . '/assets/js/customizer.js', array (
			'customize-preview' 
	), '20130508', true );
}
add_action ( 'customize_preview_init', 'alcor_customize_preview_js' );

/**
 * Binds JS handlers to init Theme Customizer object.
 */
function alcor_customize_init_script() {
	wp_enqueue_script ( 'alcor_customizer_script', get_template_directory_uri () . '/assets/js/alcor-customizer.js', array (
			"jquery" 
	), '20130508', true );
}
add_action ( 'customize_controls_enqueue_scripts', 'alcor_customize_init_script' );

if (class_exists ( 'WP_Customize_Control' )) :
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
			?>
<label>
	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<textarea rows="5" style="width: 100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
</label>
<?php
		}
	}
endif;

