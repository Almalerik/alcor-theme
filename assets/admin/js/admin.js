jQuery.fn.whao_select2 = function() {
    jQuery(this).select2({
	'templateResult' : formatMenuIcon,
	'templateSelection' : formatMenuIcon,
	'width' : 'resolve'
    });
};

jQuery(document).ready(function($) {

    /* MENU */

    // Init select2 select already defined
    $("#menu-to-edit .alcor-icon-select2").whao_select2();

    $("#menu-to-edit").on('click', '.alcor-icon-button', function() {
	$(this).closest(".alcor-menu-options").toggle();
	$ms = $(this).closest(".menu-item-settings");
	$('.alcor-options-val', $ms).val('');
	$('.alcor-menu-icon', $ms).toggle();
	$(".alcor-icon-select2", $ms).whao_select2();
    });

    $("#menu-to-edit").on('click', ".alcor-image-button", function() {
	$(this).closest(".alcor-menu-options").toggle();
	$ms = $(this).closest(".menu-item-settings");
	$('.alcor-options-val', $ms).val('');
	$('.alcor-menu-image', $ms).toggle();
    });

    $("#menu-to-edit").on('click', ".alcor-custom-html-button", function() {
	$(this).closest(".alcor-menu-options").toggle();
	$ms = $(this).closest(".menu-item-settings");
	$('.alcor-options-val', $ms).val('');
	$('.alcor-menu-custom-html', $ms).toggle();
    });

    $("#menu-to-edit").on('click', '.alcor-menu-options-reset', function(e) {
	e.preventDefault();
	$ms = $(this).closest(".menu-item-settings");
	$('.alcor-options-val', $ms).val('');
	$(this).closest('.field-custom').toggle();
	$(".alcor-menu-options", $ms).toggle();
    });

    var custom_uploader;

    $("#menu-to-edit").on('click', '#alcor-image-upload-button', function(e) {

	e.preventDefault();

	// If the uploader object has already been created, reopen the dialog
	if (custom_uploader) {
	    custom_uploader.open();
	    return;
	}

	// Extend the wp.media object
	custom_uploader = wp.media.frames.file_frame = wp.media({
	    title : 'Insert Media',
	    button : {
		text : 'Choose Image'
	    },
	    multiple : false
	});

	// When a file is selected, grab the URL and set it as the text field's
	// value
	custom_uploader.on('select', function() {
	    attachment = custom_uploader.state().get('selection').first().toJSON();
	    $('#upload_image').val(attachment.url);
	    // $('#upload_image').val(attachment.id);
	});

	// Open the uploader dialog
	custom_uploader.open();

    });

    /**
     * ALCOR SLIDER
     */
    var alcorEditSlideCounter = $("#alcor-edit-slide-wrapper tr").length;
    var $button;
    $("#alcor-edit-slide-wrapper").on('click', '.alcor-set-slide-thumbnail', function(e) {

	e.preventDefault();
	$button = $(this);

	// If the uploader object has already been created, reopen the dialog
	if (custom_uploader) {
	    custom_uploader.open();
	    return;
	}

	// Extend the wp.media object
	custom_uploader = wp.media.frames.file_frame = wp.media({
	    title : 'Insert Media',
	    button : {
		text : 'Choose Image'
	    },
	    multiple : false
	});

	// When a file is selected, grab the URL and set it as the text field's
	// value
	custom_uploader.on('select', function() {
	    attachment = custom_uploader.state().get('selection').first().toJSON();

	    if (attachment != undefined) {
		var thumb_url = (attachment.sizes != undefined && attachment.sizes.thumbnail != undefined) ? attachment.sizes.thumbnail.url : attachment.url
		var $wrapper = $button.closest("td");
		$('.alcor-set-slide-thumbnail', $wrapper).toggle();
		$('.alcor-remove-slide-thumbnail', $wrapper).toggle();
		$(".alcor_slides_image_id", $wrapper).val(attachment.id);
		$wrapper.remove("img");
		$wrapper.append('<img src="' + thumb_url + '" />')
	    }
	});

	// Open the uploader dialog
	custom_uploader.open();

    });

    // Event on delete slide
    $("#alcor-edit-slide-wrapper").on('click', '.alcor-remove-slide-thumbnail', function(e) {
	e.preventDefault();
	var r = confirm($("#alcor-remove-slide-thumbnail-msg").val());
	if (r == true) {
	    var $wrapper = $(this).closest("td");
	    $('img', $wrapper).remove();
	    $('.alcor-set-slide-thumbnail', $wrapper).toggle();
	    $('.alcor-remove-slide-thumbnail', $wrapper).toggle();
	    $(".alcor_slides_image_id", $wrapper).val("");
	}
    });

    // Enable sortable on slide table
    $('#alcor-edit-slide-wrapper table tbody.sortable').sortable({
	placeholder : "alcor-slide-edit-sortable-placeholder",
	cursor : "move",
	handle : ".alcor-slide-command-move",
	opacity : 0.8,
	activate: function( event, ui ) {$("#alcor-edit-slide-wrapper .accordion" ).accordion('option', {active: false});}
    });
    $("#alcor-edit-slide-wrapper table").disableSelection()

    // Add row slide
    $("#alcor-edit-slide-wrapper").on('click', '#alcor-edit-slide-add-row', function(e) {
	e.preventDefault();
	var $row = $("#alcor-edit-slide-template").clone(true, true);
	$row.removeAttr("id");
	// Loop through all inputs
	$row.find('input, textarea, label').each(function(){ 

	    if ( !! $(this).attr('id') )
	        $(this).attr('id',  $(this).attr('id').replace('[0]', '[' + alcorEditSlideCounter + ']') );  // Replace for

	    if ( !! $(this).attr('name') )
	        $(this).attr('name',  $(this).attr('name').replace('[0]', '[' + alcorEditSlideCounter + ']') );  // Replace for

	    if ( !! $(this).attr('for') )
	        $(this).attr('for',  $(this).attr('for').replace('[0]', '[' + alcorEditSlideCounter + ']') );  // Replace for

	});

	$("#alcor-edit-slide-wrapper tbody").append($row);
	alcorEditSlideCounter++;
    });
    // Delete row slide
    $("#alcor-edit-slide-wrapper").on('click', '.fa-trash', function(e) {
	e.preventDefault();
	var r = confirm($("#alcor-remove-slide-thumbnail-msg").val());
	if (r == true) {
	    var $wrapper = $(this).closest("tr").remove();
	}
    });
    
    $( "#alcor-edit-slide-wrapper .accordion" ).accordion({active:false, collapsible: true,heightStyle: "content",icons: { "header": "dashicons-before dashicons-arrow-down-alt2", "activeHeader": "dashicons-before dashicons-arrow-up-alt2" }});

});

function formatMenuIcon(icon) {
    if (!icon.id) {
	return icon.text;
    }
    var $icon = jQuery('<span><i class="' + icon.element.value.toLowerCase() + '"></i> ' + icon.text + '</span>');
    return $icon;
};
