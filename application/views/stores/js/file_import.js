/**
 * @package		Codifire
 * @version		1.0
 * @author 		Faith Hidalgo <faith.hidalgo@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

Dropzone.autoDiscover = false;

$(function() {

	var myDropzone = new Dropzone("#dropzone");

	myDropzone.on("success", function(file, response) {

		console.log(file);

		var response = jQuery.parseJSON(response);
		// console.log(response);

		if (response.status == 'failed') {
			alert(jQuery(response.error).text());
		} else {
			// refreshes the datatables
			$('#datatables').dataTable().fnDraw();

			// closes the modal
			$('#modal').modal('hide');

			// restores the modal content to loading state
			restore_modal();

			// shows the success message
			alertify.success(response.message);
		}

		$('.dz-image, .dz-preview').remove();
		$('.dz-message').show();
	});

	// disables the enter key
	$('form input').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});