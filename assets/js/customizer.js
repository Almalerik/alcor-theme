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
		});
	});
	// Header text color.
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('.site-title a, .site-description').css({
					'clip' : 'rect(1px, 1px, 1px, 1px)',
					'position' : 'absolute'
				});
			} else {
				$('.site-title a, .site-description').css({
					'clip' : 'auto',
					'position' : 'relative'
				});
				$('.site-title a, .site-description').css({
					'color' : to
				});
			}
		});
	});
	wp.customize('alcor[show_title]', function(value) {
		console.log("asd");
		value.bind(function(to) {
			('hidden' === to) ? $('.site-title').addClass(to) : $('.site-title').removeClass('hidden');			
		});
	});

})(jQuery);
