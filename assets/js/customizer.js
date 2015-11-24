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
			if ("" === to) {
				$('#header .navbar-default').removeClass('navbar-fixed-top');
			} else {
				$('#header .navbar-default').addClass('navbar-fixed-top');
			}
		});
	});

	// Header background color.
	wp.customize('alcor[header_background_color]', function(value) {
		value.bind(function(to) {
			if (false === to) {
				$('#header .navbar-default').css('background-color',
						'transparent');
			} else {
				$('#header .navbar-default').css('background-color', to);
			}
		});
	});
	
	// Header margin bottom.
	wp.customize('alcor[header_margin_bottom]', function(value) {
		value.bind(function(to) {
			if ("" === to) {
				$('#header .navbar').css('margin-bottom','0');
			} else {
				$('#header .navbar').css('margin-bottom', to);
			}
		});
	});

	// Header image show.
	wp.customize('alcor[header_image_show]', function(value) {
		value.bind(function(to) {
			console.log(to);
			$('#site-header-image').removeClass('hidden all homepage-only').addClass(to);
		});
	});
	
	// Header image parallax
	wp.customize('alcor[header_image_parallax]', function(value) {
		value.bind(function(to) {
			if (false === to) {
				$('.alcor-site-branding').removeClass('background-attachment-fixed');
			} else {
				$('.alcor-site-branding').addClass('background-attachment-fixed');
			}
			
		});
	});
	
	// Header image text
	wp.customize('alcor[header_image_text]', function(value) {
		value.bind(function(to) {
			$('.alcor-site-branding h2').html(to);
		});
	});
	
	// Header image text color
	wp.customize('alcor[header_image_text_color]', function(value) {
		value.bind(function(to) {
			$('.alcor-site-branding h2').css("color", to);
		});
	});

	// Header image height
	wp.customize('alcor[header_image_height]', function(value) {
		value.bind(function(to) {
			$('.alcor-site-branding').css('height', to);
		});
	});

	// Container wrapper
	wp.customize('alcor[container_class]', function(value) {
		value.bind(function(to) {
			$('.alcor-container').removeClass('container-fluid container')
					.addClass(to).removeAttr('style');
			if ('container' === to) {
				var width = wp.customize.value(
						'alcor[container_class_fixed_max_width]')();
				$('.alcor-container').css('max-width', width);
			}
		});
	});

	// Container wrapper max width
	wp.customize('alcor[container_class_fixed_max_width]', function(value) {
		value.bind(function(to) {
			$('.alcor-container.container').css('max-width', to);
		});
	});
	
	// Container wrapper max width
	wp.customize('alcor[sidebar_width]', function(value) {
		value.bind(function(to) { 
			var sidebarClass = "col-sm-" + to;
			var contentClass = "col-sm-" + (12 - parseInt(to));
			$("#primary").removeClass().addClass(contentClass + " content-area");
			$("#secondary").removeClass().addClass(sidebarClass + " widget-area");
		});
	});

	// Body font
	wp.customize('alcor[body_font]', function(value) {
		value.bind(function(to) {
			console.log(to);
			var ff = [];
			ff.push(to);
			$("body").css('background-color', "black !important");
			WebFont.load({
			    google: {
			      families: ff
			    }
			  });
			$(".alcor-container").css('font-family', "'"+to+"' !important");
		});
	});

})(jQuery);
