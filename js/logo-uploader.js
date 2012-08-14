
jQuery(document).ready(function($) {

	/*$('#gs-logo-upload-button').click(function() {
		 formfield = $('#gs-logo-upload').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
	});

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#gs-logo-upload').val(imgurl);
		 tb_remove();
	}*/

	var current_upload_field;

		// Open a ThickBox when the "Add Media" button is clicked
		var ml_upload_click = false;

		$('#gs-logo-upload-button').live('click',function () {
			// Get the name of the text field to send file upload data to (stored in REL attribute)
			current_upload_field = $('input[name="' + $(this).attr('rel') + '"]');
			iframe_button_value = 'Set as Logo';

			// Open the media upload Thickbox
			tb_show('Upload or Select Logo', 'media-upload.php?post_id=0&type=image&TB_iframe=true');

			// Replace "Add to Post" button text after IFRAME loads
			function iframeSetup() {
				var add_button = $('#TB_iframeContent').contents().find('.media-item .savesend input[type=submit], #insertonlybutton');
				if ( add_button.length ) {
					add_button.val(iframe_button_value);
				}
				$('#TB_iframeContent').contents().find('#media-upload').addClass('logo-upload-window');
				$('#TB_iframeContent').contents().find('.savesend input[type="submit"]').addClass('button-primary');
			}
			interval = setInterval(iframeSetup,500);


			// Only trigger send_to_editor customizations for these fields
			ml_upload_click = true;

			return false;
		});

		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			$('#gs-logo-upload').val(imgurl); // Send logo URL to the form field
			$('.upload-image-preview').attr('src', imgurl);	// Update logo preview with new logo's src
			tb_remove();
		}
		// Remove image button
		$('input.media-library-remove').live('click',function () {
			// Get the name of the text field remove the value (stored in REL attribute)
			$('input[name="' + $(this).attr('rel') + '"]').val('');

			// Remove the visible image preview
			$(this).parents('td').find('.upload-image-preview').fadeOut(500);
			return false;
		});

});