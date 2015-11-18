<?php
if (! class_exists ( 'WP_Customize_Control' ))
	return NULL;

/**
 * Class to create a custom layout control
 */
class Layout_Picker_Custom_Control extends WP_Customize_Control {
	/**
	 * Render the content on the theme customizer page
	 */
	public function render_content() {
		$imageDirectory = '/layout/img/';
		$imageDirectoryInc = '/inc/nav/layout/img/';
		
		$finalImageDirectory = '';
		
		if (is_dir ( get_stylesheet_directory () . $imageDirectory )) {
			$finalImageDirectory = get_stylesheet_directory_uri () . $imageDirectory;
		}
		
		if (is_dir ( get_stylesheet_directory () . $imageDirectoryInc )) {
			$finalImageDirectory = get_stylesheet_directory_uri () . $imageDirectoryInc;
		}
		$name = '_customize-radio-' . $this->id;
		?>
<label> <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
	<ul class="alcor-customize-sidebar">
		<li><img src="<?php echo $finalImageDirectory; ?>1col.png"
			alt="Full Width" /><input type="radio"
			value="full"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'full' ); ?> /></li>
		<li><img src="<?php echo $finalImageDirectory; ?>2cl.png"
			alt="Left Sidebar" /><input type="radio"
			value="left"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'left' ); ?> /></li>
		<li><img src="<?php echo $finalImageDirectory; ?>2cr.png"
			alt="Right Sidebar" /><input type="radio"
			value="right"
			name="<?php echo esc_attr( $name ); ?>"
			<?php $this->link(); checked( $this->value(), 'right' ); ?> /></li>
	</ul>

<?php
	}
}
?>