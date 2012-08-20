jQuery(document).ready(function($) {

	var current_upload_field;

		// Open a ThickBox when the "Add Media" button is clicked
		var ml_upload_click = false;

		$('#feature-box-upload-button').live('click',function () {
			// Get the name of the text field to send file upload data to (stored in REL attribute)
			current_upload_field = $('input[name="' + $(this).attr('rel') + '"]');
			current_image_preview = $('img[name="' + $(this).attr('rel') + '"]');


			iframe_button_value = 'Set as Widget Image';

			// Open the media upload Thickbox
			tb_show('Upload or Select Widget Image', 'media-upload.php?post_id=0&type=image&TB_iframe=true');

			// Replace "Add to Post" button text after IFRAME loads
			function iframeSetup() {
				var add_button = $('#TB_iframeContent').contents().find('.media-item .savesend input[type=submit], #insertonlybutton');
				if ( add_button.length ) {
					add_button.val(iframe_button_value);
				}
				$('#TB_iframeContent').contents().find('#media-upload').addClass('feature-box-upload-window');
				$('#TB_iframeContent').contents().find('.savesend input[type="submit"]').addClass('button-primary');
			}
			interval = setInterval(iframeSetup,500);


			// Only trigger send_to_editor customizations for these fields
			ml_upload_click = true;

			return false;
		});

		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			current_upload_field.val(imgurl); // Send logo URL to the form field

			// Show remove button
			current_upload_field.siblings('.media-library-remove').css('display', 'inline');
			current_upload_field.siblings('.media-library-remove').attr('style','');

			// Hide set image button
			current_upload_field.siblings('.media-library-upload').css('display', 'none');

			// Update logo preview with new logo's src
			current_image_preview.attr('src', imgurl);	

			// Make image preview visible
			current_image_preview.css('display', 'block');

			tb_remove();
		}
		// Remove image button
		$('input.media-library-remove').live('click',function () {
			// Get the name of the text field to remove the value (stored in REL attribute)
			$(this).siblings('.feature-box-img-url-field').val('');

			// Remove the visible image preview
			$(this).next().fadeOut(500);

			// Hide the "Remove" button after removal
			$(this).css('display', 'none');

			// Show the "Set Image" button after removal
			$(this).siblings('.media-library-upload').css('display', 'inline');

			return false;
		});

});