<?php
/**
 * Alcor class.
 *
 * @since 3.4.0
 */
class Alcor_Theme {
	const SLUG = 'alcor';
	
	/**
	 * All default settings.
	 *
	 * @access private
	 * @var array
	 */
	public $defaults = array (
			"wrapper" => "container-fluid",
			"wrapper_max_width" => "1092px",
			"layout" => "full",
			"sidebar_width" => "3", 
			"show_title" => true,
			"show_description" => true,
			"header_background_color" => "",
	);
	
	/**
	 *
	 * @var array
	 */
	private $wp_option;
	
	/**
	 */
	public function __construct() {
		$this->wp_option = get_option ( self::SLUG );
	}
	/**
	 *
	 * @param String $key        	
	 */
	function get_setting($key, $get_default = TRUE) {
		
		if ( $get_default ) {
			return get_theme_mod($key, $this->wp_option [$key]) ;
		} 
		return get_theme_mod($key);

	}
	
	/**
	 *
	 * @return boolean
	 */
	public function has_sidebar() {
		if ($this->get_setting ( "layout" ) != 'full') {
			return true;
		}
		return false;
	}
	
	/**
	 *
	 * @return array
	 */
	public function get_col_class() {
		$result = array (
				"content" => "col-md-12",
				"sidebar" => "" 
		);
		if ($this->get_setting ( "layout" ) != 'full') {
			if (is_numeric ( $this->get_setting ( "sidebar_width" ) )) {
				$sidebar_width = intval ( $this->get_setting ( "sidebar_width" ) );
				$result ["content"] = "col-sm-" . (12 - $sidebar_width);
				$result ["sidebar"] = "col-sm-" . $sidebar_width;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 */
	public function get_custom_style() {
		$result = "";
		if ($this->get_setting ( "wrapper_max_width", FALSE ) != "")
			$result .= ".alcor-wrapper {max-width: " . $this->get_setting ( "wrapper_max_width", FALSE ) . "};\n";
	}
	
	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses get_theme_mod()
	 * @param string $selector CSS selector
	 * @param string $style The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix Optional. Anything that needs to be output after the CSS property
	 * @param bool $echo Optional. Whether to print directly to the page (default: true).
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since MyTheme 1.0
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
		$return = '';
		$mod = get_theme_mod($mod_name);
		if ( ! empty( $mod ) ) {
			$return = sprintf('%s { %s:%s; }',
					$selector,
					$style,
					$prefix.$mod.$postfix
					);
			if ( $echo ) {
				echo $return;
			}
		}
		return $return;
	}
	
	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see add_action('wp_head',$func)
	 * @since MyTheme 1.0
	 */
	public static function header_output() {
		?>
	      <!--Customizer CSS--> 
	      <style type="text/css">
	      		
	           <?php self::generate_css('.navbar-default', 'background-color', 'header_background_color', '#'); ?> 
	          
	      </style> 
	      <!--/Customizer CSS-->
	      <?php
	}
	
	/**
	 * This will output the logo url.
	 */
	public function get_logo() {
		$alcor_logo = $this->get_setting ( 'alcor_logo' );
		
		if (isset ( $alcor_logo ) && $alcor_logo != "" ) {
			return $alcor_logo;
		} else {
			if (file_exists ( get_stylesheet_directory () . "/assets/images/logo.png" )) {
				return get_stylesheet_directory_uri () . "/assets/images/logo.png";
			} else {
				return get_template_directory_uri () . "/assets/images/logo.png";
			}
		}
	}
}

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Alcor_Theme' , 'header_output' ) );