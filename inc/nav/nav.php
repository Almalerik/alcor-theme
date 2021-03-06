<?php
class Alcor_Custom_Menu {
	
	/*
	 * --------------------------------------------*
	 * Constructor
	 * --------------------------------------------
	 */
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		// add custom menu fields to menu
		add_filter ( 'wp_setup_nav_menu_item', array (
				$this,
				'alcor_add_custom_nav_fields' 
		) );
		// save menu custom fields
		add_action ( 'wp_update_nav_menu_item', array (
				$this,
				'alcor_update_custom_nav_fields' 
		), 10, 3 );
		// edit menu walker
		add_filter ( 'wp_edit_nav_menu_walker', array (
				$this,
				'alcor_edit_walker' 
		), 10, 2 );
	} // end constructor
	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 *
	 */
	function alcor_add_custom_nav_fields($menu_item) {
		$menu_item->alcor_custom_html = get_post_meta ( $menu_item->ID, '_menu_item_alcor_custom_html', true );
		$menu_item->alcor_icon = get_post_meta ( $menu_item->ID, '_menu_item_alcor_icon', true );
		$menu_item->alcor_image = get_post_meta ( $menu_item->ID, '_menu_item_alcor_image', true );
		return $menu_item;
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	function alcor_update_custom_nav_fields($menu_id, $menu_item_db_id, $args) {
		
		// Check if element is properly sent
		if (is_array ( $_REQUEST ['menu-item-alcor-custom-html'] )) {
			$custom_html_value = $_REQUEST ['menu-item-alcor-custom-html'] [$menu_item_db_id];
			update_post_meta ( $menu_item_db_id, '_menu_item_alcor_custom_html', $custom_html_value );
		}
		
		if (is_array ( $_REQUEST ['menu-item-alcor-icon'] )) {
			$icon_value = $_REQUEST ['menu-item-alcor-icon'] [$menu_item_db_id];
			update_post_meta ( $menu_item_db_id, '_menu_item_alcor_icon', $icon_value );
		}
		
		if (is_array ( $_REQUEST ['menu-item-alcor-image'] )) {
			$image_value = $_REQUEST ['menu-item-alcor-image'] [$menu_item_db_id];
			update_post_meta ( $menu_item_db_id, '_menu_item_alcor_image', $image_value );
		}
	}
	/**
	 * Define new Walker edit
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 *
	 */
	function alcor_edit_walker($walker, $menu_id) {
		return 'Walker_Nav_Menu_Edit_Alcor';
	}
}

// instantiate plugin's class
$GLOBALS ['Alcor_Custom_Menu'] = new Alcor_Custom_Menu ();

include_once ('custom-nav-menu.php');
include_once ('custom-nav-walker.php');

