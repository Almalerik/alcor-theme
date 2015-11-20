jQuery(document).ready(function($) {
	
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();

	    if (scroll >= 20) {
	    	console.log("maggiore");
	        $('#header .navbar-default').removeClass( "navbar-fade" );
	    } else {
	    	console.log("minore");
	        $('#header .navbar-default').addClass( "navbar-fade" );
	    }
	});

});
