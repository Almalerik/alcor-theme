/**
 * customizer.js
 * 
 * Theme Customizer enhancements for a better user experience.
 * 
 * Contains handlers to make Theme Customizer preview reload changes
 * asynchronously.
 */

(function($) {
	// Site title and description.
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
			if ('' === to) {
			    $('.site-description').css({
				'clip' : 'rect(1px, 1px, 1px, 1px)',
				'position' : 'absolute'
				});
			} else {
			    $('.site-description').css({
				'clip' : 'auto',
				'position' : 'relative'
			    });
			}
		});
	});
	
	// Header show.
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip' : 'rect(1px, 1px, 1px, 1px)',
					'position' : 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip' : 'auto',
					'position' : 'relative'
				});
			}
		});
	});
	
	// Header fixed top.
	wp.customize('alcor[header_fixed_top]', function(value) {
		value.bind(function(to) {
			if (false === to ) {
				$('#header .navbar-default').removeClass('navbar-fixed-top');
			} else {
				$('#header .navbar-default').addClass('navbar-fixed-top');
			}
		});
	});
	
	// Header background color.
	wp.customize('alcor[header_background_color]', function(value) {
		value.bind(function(to) {
			if (false === to ) {
				$('#header .navbar-default').css('background-color', 'transparent');
			} else {
				$('#header .navbar-default').css('background-color', to);
			}
		});
	});
	
	// Header image show.
	wp.customize('alcor[header_image_show]', function(value) {
		value.bind(function(to) {
		    $('#site-header-background').toggleClass('hidden');
		});
	});
	
	// Container wrapper
	wp.customize('alcor[container_class]', function(value) {
		value.bind(function(to) {
		    $('.alcor-container').removeClass('container-fluid container').addClass(to).removeAttr('style');
		    if ( 'container' === to ) {
			var width = wp.customize.value('alcor[container_class_fixed_max_width]')();
			$('.alcor-container').css('max-width', width);
		    }
		});
	});
	
	//  Container wrapper max width
	wp.customize('alcor[container_class_fixed_max_width]', function(value) {
		value.bind(function(to) {
		    $('.alcor-container.container').css('max-width', to);
		});
	});	


})(jQuery);
