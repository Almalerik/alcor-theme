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
	 * @access public
	 * @var array
	 */
	public $defaults = array (
			"container_class" => "container-fluid",
			"container_class_fixed_max_width" => "1170px",
			"header_fixed_top" => "",
			"header_background_color" => "",
			"header_margin_bottom" => "0px",
			"header_image_show" => "homepage-only",
			"header_image_parallax" => TRUE,
			"header_image_height" => "250px",
			"header_image_text" => "Alcor",
			"header_image_text_color" => "#ffffff",
			"header_slider_show" => TRUE,
			"page_layout" => "full",
			"hide_homepage_sidebar" => TRUE,
			"sidebar_width" => "3",
			"body_font" => "Lato",
			// TODO: DA VERIFICARE
			
			"logo" => "" 
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
		if ($this->get_setting ( "page_layout" ) != 'full') {
			return TRUE;
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
		if ($this->get_setting ( "page_layout" ) != 'full') {
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
	 *        	Optional. Whether to print directly to the page (default: TRUE).
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since Alcor 1.0
	 */
	public static function generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = TRUE) {
		$return = '';
		$mods = get_option ( 'alcor' );
		$mod = isset ( $mods [$mod_name] ) ? $mods [$mod_name] : null;
		if (! empty ( $mod )) {
			$return = sprintf ( '%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix );
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
	 * @since Alcor 1.0
	 */
	public static function header_output() {
		$mods = get_option ( 'alcor' );
		$mod = isset ( $mods ["body_font"] ) ? str_replace ( " ", "+", $mods ["body_font"] ) : 'Lato';
		$result = '<link href="https://fonts.googleapis.com/css?family=' . $mod . '" rel="stylesheet" type="text/css">';
		$result .= "<!--Customizer CSS-->\n";
		$result .= '<style type="text/css" id="alcor-style-inline">' . "\n";
		
		// Body font family
		$result .= "\t" . self::generate_css ( 'body', 'font-family', 'body_font', '\'', '\'', false ) . "\n";
		
		// Navbar background color
		$result .= "\t" . self::generate_css ( '.navbar-default', 'background-color', 'header_background_color', '', '', false ) . "\n";
		
		// Fixed Container
		$result .= "\t" . self::generate_css ( '.alcor-container.container', 'max-width', 'container_class_fixed_max_width', '', '', false ) . "\n";
		
		// Header margin bottom
		$result .= "\t" . self::generate_css ( '#header', 'margin-bottom', 'header_margin_bottom', '', '', false ) . "\n";
		
		// Header image
		$result .= "\t" . self::generate_css ( '.alcor-site-branding', 'height', 'header_image_height', '', '', false ) . "\n";

		// Background image text color
		$result .= "\t" . self::generate_css ( '.alcor-site-branding h2', 'color', 'header_image_text_color', '', '', false ) . "\n";
		
		// Add this style if not in homepage
		if (!is_home()) {
			$result .= "\t.homepage-only{display: none;}\n";
		}
		
		$result .= "</style>\n";
		$result .= "<!--/Customizer CSS-->\n";
		echo $result;
	}
	
	/**
	 * This will output the logo url.
	 */
	public function get_logo() {
		$alcor_logo = $this->get_setting ( 'logo' );
		
		if (isset ( $alcor_logo ) && $alcor_logo != "") {
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
	 * This will return hidden header background image must be hidden checking if in homepage and if in customize
	 *
	 * @return string Returns hidden if header background image must be hidden.
	 * @since Alcor 1.0
	 */
	public function show_header_background_image() {
		if (! is_customize_preview ()) {
			$h = $this->get_setting ( 'header_image_show' );
			if ($h == 'hidden' || (! is_home () && $h == 'homepage')) {
				return false;
			}
		}
		return TRUE;
	}
}

// Output custom CSS to live site
add_action ( 'wp_head', array (
		'Alcor_Theme',
		'header_output' 
) );
function sanitize_css_number($value) {
	str_replace ( ",", ".", $value );
	if (is_numeric ( $value )) {
		return $value . "px";
	}
	return $value;
}