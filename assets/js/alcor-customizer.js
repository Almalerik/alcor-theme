jQuery(document).ready(function() {
	
	//Header background image
	wp.customize.section('header_image').panel('alcor_header');
	wp.customize.section('header_image').priority('20');

	//Header widget
	wp.customize.section('sidebar-widgets-sidebar-header-widget').panel('alcor_header');
	wp.customize.section('sidebar-widgets-sidebar-header-widget').priority('300');
	
	/*
	if (wp.customize('alcor[container_class]').get() === 'container-fluid') {
		//wp.customize.control( 'alcor_container_class' ).deactivate();
		jQuery(wp.customize.control( 'alcor_container_class_fixed_max_width' ).container).css("display", "none");
	}
	*/
	
	
});
