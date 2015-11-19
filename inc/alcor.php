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
			"logo" => "",
			"show_title" => true,
			"show_description" => true,
			"header_fixed_top" => "",
			"header_background_color" => "" 
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
	 * If exist wp_option[key] return this otherwise return the default value
	 *
	 * @param String $key        	
	 */
	function get_setting($key) {
		return isset ( $this->wp_option [$key] ) ? $this->wp_option [$key] : $this->defaults [$key];
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
	 */
	public function get_custom_style() {
		$result = "";
		if ($this->get_setting ( "wrapper_max_width" ) != "")
			$result .= ".alcor-wrapper {max-width: " . $this->get_setting ( "wrapper_max_width", FALSE ) . "};\n";
	}
	
	/**
	 * This will generate a line of CSS for use in header output.
	 * If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses get_theme_mod()
	 * @param string $selector
	 *        	CSS selector
	 * @param string $style
	 *        	The name of the CSS *property* to modify
	 * @param string $mod_name
	 *        	The name of the 'theme_mod' option to fetch
	 * @param string $prefix
	 *        	Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix
	 *        	Optional. Anything that needs to be output after the CSS property
	 * @param bool $echo
	 *        	Optional. Whether to print directly to the page (default: true).
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since MyTheme 1.0
	 */
	public static function generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true) {
		$return = '';
		$mods = get_option ( 'alcor' );
		$mod = $mods [$mod_name];
		if (! empty ( $mod )) {
			$return = sprintf ( '%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix );
			if ($echo) {
				echo $return;
			}
		} else {
			$return = sprintf ( '%s { %s:%s; }', $selector, $style, 'transparent' );
			if ($echo) {
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
		$mods = get_option ( 'alcor' );
		$mod = $mods [$mod_name];
		$background_color =$mods ['header_background_color'];
		$header_fix = $mods ['header_fixed_top'];
		if ($header_fix && isset($background_color)) {
			$background_color = $this -> hex2rgb($background_color);
			array_push($background_color, "0.4");
		}
		?>
	      <!--Customizer CSS--> 
	      <style type="text/css" id="alcor-style">
	      		
	           <?php self::generate_css('.navbar-defaultz', implode(",", $background_color), 'header_background_color'); ?> 
	          
	      </style> 
	      <!--/Customizer CSS-->
	      <?php
	}
	
	/**
	 * This will output the logo url.
	 */
	public function get_logo() {
		$alcor_logo = $this->get_setting ( 'logo' );
		
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
	
	/**
	 * Returns the rgb values separated by commas
	 * 
	 * @param String $hex        	
	 */
	function hex2rgb($hex) {
		$hex = str_replace ( "#", "", $hex );
		
		if (strlen ( $hex ) == 3) {
			$r = hexdec ( substr ( $hex, 0, 1 ) . substr ( $hex, 0, 1 ) );
			$g = hexdec ( substr ( $hex, 1, 1 ) . substr ( $hex, 1, 1 ) );
			$b = hexdec ( substr ( $hex, 2, 1 ) . substr ( $hex, 2, 1 ) );
		} else {
			$r = hexdec ( substr ( $hex, 0, 2 ) );
			$g = hexdec ( substr ( $hex, 2, 2 ) );
			$b = hexdec ( substr ( $hex, 4, 2 ) );
		}
		$rgb = array (
				$r,
				$g,
				$b 
		);
		// return implode(",", $rgb);
		return $rgb; // returns an array with the rgb values
	}
}

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Alcor_Theme' , 'header_output' ) );