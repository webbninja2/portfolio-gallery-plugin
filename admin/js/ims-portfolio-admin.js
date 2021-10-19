(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {
	 	
      //code to upload thumbnail in backend
      var meta_image_thumb;
      	
      	$('.image-upload-thumb').on('click',function (e) 
      	{ 
        	var meta_image_preview_thumb = $(this).parent("div").find(".ims-image-preview");
        	e.preventDefault();
        	var meta_image = $(this).parent().children('.meta-image');
        	if (meta_image_thumb) {
          		meta_image_thumb.open();
          		return;
        	}
        	meta_image_thumb = wp.media.frames.meta_image_thumb = wp.media({
	          	title: meta_image.title,
	          	button: {
	            text: meta_image.button
          		}
        	});
        	meta_image_thumb.on('select', function () {
	          var media_attachment = meta_image_thumb.state().get('selection').first().toJSON();
	          meta_image.val(media_attachment.url);
	          meta_image_preview_thumb.find('img').attr('src', media_attachment.url);
	        });
        	meta_image_thumb.open();
      	});


      	//code to upload full image in backend
      	var meta_image_full;
      	$('.image-upload-full').on('click',function (e) {
	        var meta_image_preview_full = $(this).parent("div").find(".ims-image-preview");
	        e.preventDefault();
	        var meta_image = $(this).parent().children('.meta-image');
	        if (meta_image_full) {
	          	meta_image_full.open();
	          	return;
	        }
	        meta_image_full = wp.media.frames.meta_image_full = wp.media({
	          	title: meta_image.title,
	          	button: {
	            	text: meta_image.button
	          	}
        	});
        	meta_image_full.on('select', function () {
          		var media_attachment = meta_image_full.state().get('selection').first().toJSON();
          		meta_image.val(media_attachment.url);
          		meta_image_preview_full.find('img').attr('src', media_attachment.url);
        		//debugger;
        	});
        	meta_image_full.open();
      	});


	}); // End jQuery

})( jQuery );
