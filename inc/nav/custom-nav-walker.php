<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
class Alcor_Walker extends Walker_Nav_Menu {
	function start_el(&$output, $object, $depth = 0, $args = Array (), $current_object_id = 0) {
		global $wp_query;
		$indent = ($depth) ? str_repeat ( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty ( $object->classes ) ? array () : ( array ) $object->classes;
		
		$class_names = join ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $object ) );
		$class_names = ' class="' . esc_attr ( $class_names ) . '"';
		
		$output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
		
		$attributes = ! empty ( $object->attr_title ) ? ' title="' . esc_attr ( $object->attr_title ) . '"' : '';
		$attributes .= ! empty ( $object->target ) ? ' target="' . esc_attr ( $object->target ) . '"' : '';
		$attributes .= ! empty ( $object->xfn ) ? ' rel="' . esc_attr ( $object->xfn ) . '"' : '';
		$attributes .= ! empty ( $object->url ) ? ' href="' . esc_attr ( $object->url ) . '"' : '';
		
		$prepend = '<strong>';
		$append = '</strong>';
		$description = ! empty ( $object->description ) ? '<span>' . esc_attr ( $object->description ) . '</span>' : '';
		
		if ($depth != 0) {
			$description = $append = $prepend = "";
		}
		
		$object_output = $args->before;
		$object_output .= '<a' . $attributes . '>';
		
		if (! empty ( $object->alcor_custom_html )) {
			$object_output .= ' ' . $object->alcor_custom_html;
		} elseif (! empty ( $object->alcor_icon )) {
			$object_output .= '<i class="' . $object->alcor_icon . '"></i>';
		} elseif (! empty ( $object->alcor_image )) {
			$object_output .= ' ' . $object->alcor_image;
		}
		
		$object_output .= $args->link_before . $prepend . apply_filters ( 'the_title', $object->title, $object->ID ) . $append;
		$object_output .= $description . $args->link_after . '</a>';
		$object_output .= $args->after;
		
		$output .= apply_filters ( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args, $object->ID );
	}
}