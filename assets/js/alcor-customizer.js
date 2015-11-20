jQuery(document).ready(function() {
	
	//Header background image
	wp.customize.section('header_image').panel('alcor_header');
	wp.customize.section('header_image').priority('200');

	//Header widget
	wp.customize.section('sidebar-widgets-sidebar-header-widget').panel('alcor_header');
	wp.customize.section('sidebar-widgets-sidebar-header-widget').priority('300');
});
