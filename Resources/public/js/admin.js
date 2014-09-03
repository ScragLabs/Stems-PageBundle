/**
 * Callback to update a sections image upload
 */
function updateSectionImage(data, originator) {
	$('.image-preview').each(function(e) {
		if ($(this).data('type') == data.meta.imageType && $(this).data('section') == data.meta.section) {
			$('image-preview').html(data.html).removeClass('image-preview-empty');
		}
	});
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
		console.log('changed');
		if ($(this).val() == 'left') {
			$(this).parent().parent().insertBefore(text_editor);
		} else {
			$(this).parent().parent().insertAfter(text_editor);
		}
	});

	/** 
	 * Scrapbook initilise draggables
	 */
	$('.canvas-preview .caption').draggable();
	$('.canvas-preview .scrap').draggable();

	$('.admin-editor').on('dragstop', '.canvas-preview .caption', function(e) {
		$('#section_scrapbook_type_contentX').val($(this).position().left);
		$('#section_scrapbook_type_contentY').val($(this).position().top);
	});
});