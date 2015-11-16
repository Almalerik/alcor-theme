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
	private $default_settings = array (
			"wrapper" => "container-fluid",
			"wrapper_max_width" => "1092px",
			"layout" => "full",
			"sidebar_width" => "3" 
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
		if (isset ( $this->wp_option [$key] )) {
			return $this->wp_option [$key];
		} else {
			if ($get_default) {
				return $this->default_settings [$key];
			}
		}
		return "";
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
	public function get_custom_style() {
		$result = "";
		if ($this->get_setting ( "wrapper_max_width", FALSE ) != "")
			$result .= ".alcor-wrapper {max-width: " . $this->get_setting ( "wrapper_max_width", FALSE ) . "};\n";
	}
}