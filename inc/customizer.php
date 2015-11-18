<?php
require_once 'nav/layout/layout-picker-custom-control.php';

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
	
	$alcor = new Alcor_Theme();
	
	// ===== Alcor Options =====
	$wp_customize->add_panel ( 'alcor_options', array (
			'title' => esc_attr__ ( 'Alcor Options', 'alcor' ),
			'description' => esc_attr__ ( 'Alcor Theme Options', 'alcor' ),
			'priority' => 30 
	) );
	$wp_customize->add_section ( 'alcor_general', array (
			'title' => esc_attr__ ( 'Layout', 'alcor' ),
			'panel' => 'alcor_options',
			'capability' => 'edit_theme_options' 
	) );
	$wp_customize->add_setting ( 'alcor[wrapper]', array (
			'default' => $alcor -> get_setting ('wrapper'),
			'type' => 'option',
			'capability' => 'edit_theme_options' 
	) );
	
	// Add control and output for select field
	$wp_customize->add_control ( 'alcor_wrapper', array (
			'label' => esc_attr__ ( 'Layout Container', 'alcor' ),
			'section' => 'alcor_general',
			'settings' => 'alcor[wrapper]',
			'type' => 'radio',
			'choices' => array (
					'container-fluid' => esc_attr__ ( 'Responsive fluid', 'alcor' ),
					'container' => esc_attr__ ( 'Responsive fixed', 'alcor' ) 
			),
			'priority' => 100 
	) );
	$wp_customize->add_setting ( 'alcor[alcor_wrapper_max_width]', array (
			'default' => $alcor -> get_setting ('wrapper_max_width'),
			'type' => 'option',
			'capability' => 'edit_theme_options' 
	) );
	$wp_customize->add_control ( 'alcor_wrapper_max_width', array (
			'label' => esc_attr__ ( 'Fixed wrapper max width', 'alcor' ),
			'section' => 'alcor_general',
			'settings' => 'alcor[alcor_wrapper_max_width]',
			'type' => 'text',
			'priority' => 200 
	) );
	
	$wp_customize->add_setting ( 'alcor[layout]', array (
			'default' => $alcor -> get_setting ('layout'),
			'type' => 'option',
			'capability' => 'edit_theme_options' 
	) );

	// Add control and output for select field
	$wp_customize->add_control ( new Layout_Picker_Custom_Control ( $wp_customize, 'alcor_layout', array (
			'label' => __ ( 'Sidebar Position', 'alcor' ),
			'section' => 'alcor_general',
			'settings' => 'alcor[layout]',
			'priority' => 300
	) ) );
	
	$wp_customize->add_setting ( 'alcor[sidebar_width]', array (
			'default' => $alcor -> get_setting ('sidebar_width'),
			'type' => 'option',
			'capability' => 'edit_theme_options'
	) );
	
	// Add control and output for select field
	$wp_customize->add_control ( 'sidebar_width', array (
			'label' => esc_attr__ ( 'Sidebar With', 'alcor' ),
			'section' => 'alcor_general',
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
			'priority' => 400
	) );
	
	// ===== Alcor Header =====
	$wp_customize->add_panel ( 'alcor_header', array (
			'title' => esc_attr__ ( 'Header', 'alcor' ),
			'description' => esc_attr__ ( 'Header Options', 'alcor' ),
			'priority' => 40
	) );
	$wp_customize->add_section ( 'alcor_logo', array (
			'title' => esc_attr__ ( 'Logo', 'alcor' ),
			'panel' => 'alcor_header',
			'capability' => 'edit_theme_options'
	) );
	$wp_customize->add_setting ( 'alcor[alcor_logo]', array (
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'alcor_logo_image', array(
			'label'    => __('Logo image', 'themename'),
			'section'  => 'alcor_logo',
			'settings' => 'alcor[alcor_logo]',
	)));

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
	wp_enqueue_script( 'alcor_customizer_script', get_template_directory_uri() . '/assets/js/alcor-customizer.js', array("jquery"), '20130508', true  );
}
add_action( 'customize_controls_enqueue_scripts', 'alcor_customize_init_script' );

if (class_exists ( 'WP_Customize_Control' )) :
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
			?>
<label> <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<textarea rows="5" style="width: 100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
</label>
<?php
		}
	}



endif;

add_action ( 'admin_menu', 'themename_add_customize_to_admin_menu' );
function themename_add_customize_to_admin_menu() { // add the 'Customize' link to the admin menu
	add_theme_page ( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}

