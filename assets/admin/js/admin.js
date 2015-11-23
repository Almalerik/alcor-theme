jQuery.fn.whao_select2 = function() {
	jQuery(this).select2({
		'templateResult' : formatMenuIcon,
		'templateSelection' : formatMenuIcon,
		'width' : 'resolve'
	});
};


jQuery(document).ready(function($) {
	
	
	
	/* MENU */
	
	//Init select2 select already defined
	$("#menu-to-edit .alcor-icon-select2").whao_select2();
	
	$("#menu-to-edit").on('click', '.alcor-icon-button', function(){
		$(this).closest(".alcor-menu-options").toggle();
		$ms = $(this).closest(".menu-item-settings");
		$('.alcor-options-val', $ms).val('');
		$('.alcor-menu-icon', $ms).toggle();
		$(".alcor-icon-select2", $ms).whao_select2();
	});
	
	$("#menu-to-edit").on('click', ".alcor-image-button", function(){
		$(this).closest(".alcor-menu-options").toggle();
		$ms = $(this).closest(".menu-item-settings");
		$('.alcor-options-val', $ms).val('');
		$('.alcor-menu-image', $ms).toggle();
	});
	
	$("#menu-to-edit").on('click', ".alcor-custom-html-button", function(){
		$(this).closest(".alcor-menu-options").toggle();
		$ms = $(this).closest(".menu-item-settings");
		$('.alcor-options-val', $ms).val('');
		$('.alcor-menu-custom-html', $ms).toggle();
	});
	
	$("#menu-to-edit").on('click', '.alcor-menu-options-reset', function(e){
		e.preventDefault();
		$ms = $(this).closest(".menu-item-settings");
		$('.alcor-options-val', $ms).val('');
		$(this).closest('.field-custom').toggle();
		$(".alcor-menu-options", $ms).toggle();
	});
	
	var custom_uploader;
	 
	 
	$("#menu-to-edit").on('click', '#alcor-image-upload-button', function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Insert Media',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
            //$('#upload_image').val(attachment.id);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
	
	$(".alcor-slide-edit-container").on('click', '.alcor-set-slide-thumbnail', function(e) {
		 
        e.preventDefault();
        var $this = $(this);
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Insert Media',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            console.log(attachment.url);
            console.log(attachment.id);
            console.log(attachment.sizes.thumbnail);
            //$('#upload_image').val(attachment.url);
            //$('#upload_image').val(attachment.id);
            var $wrapper = $this.closest("td");
            $('alcor-set-slide-thumbnail', $wrapper).css("display", "none");
            $wrapper.append('<img id="theImg" src="'+attachment.sizes.thumbnail.url+'" />')
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });

});

function formatMenuIcon(icon) {
	if (!icon.id) {
		return icon.text;
	}
	var $icon = jQuery('<span><i class="' + icon.element.value.toLowerCase()
			+ '"></i> ' + icon.text + '</span>');
	return $icon;
};
