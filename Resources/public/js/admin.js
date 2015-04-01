/**
 * Callback to update a sections image upload
 */
function updateSectionImage(data, originator) {
	$('.preview-image').each(function(e) {
		if ($(this).data('type-id') == data.meta.section && $(this).data('type') == data.meta.type) {
			$('.preview-image').html(data.html).removeClass('image-preview-empty');
		}
	});
}

function updateLayoutEditorHeight() {

    var height = 0;

    $('.layout-editor section').each(function(){
        if (($(this).position().top + $(this).height() + 30) > height) {
            height = $(this).position().top + $(this).height() + 30;
        }
    });

    $('.layout-editor').css('height', height+'px');
    $('input.layout-height').val(height);
}

$(document).ready(function() {

	/**
	 * Expand section options
	 */
	$('#add-section > a').on('click', function(e){
		e.preventDefault();

		$('.available-sections').slideToggle();
	});

	/** 
	 * Flip the positioning of the columns for the text and image section
	 */
	$('.admin-editor').on('change', '.section_textandimage_type_position', function() {
		var text_editor = $(this).parent().parent().parent().children('.column-text');
		if ($(this).val() == 'left') {
			$(this).parent().parent().insertBefore(text_editor);
		} else {
			$(this).parent().parent().insertAfter(text_editor);
		}
	});
	

    if ($('.layout-editor').length) {

        $('.layout-editor section').draggable({
            grid: [ 480, 5 ]
        });

        // $('#packery-editor').packery('bindUIDraggableEvents', $('#packery-editor section'));

        $('.layout-editor').on('dragstop', 'section', function(e) {
            $(this).find('.section-x').val($(this).position().left);
            $(this).find('.section-y').val($(this).position().top);
            updateLayoutEditorHeight();
        });
    }
});