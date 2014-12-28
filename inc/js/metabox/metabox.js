jQuery(document).ready(function($){
	
	var images_frame;
	var $images_ids = $('#image_list_id');
	var $all_images = $('#ewic_images_container ul.images_list');
	var $images_no = $('.noimgs');
	
	jQuery('.ewic_add_images').on( 'click', function( event ) {
		
		var $el = $(this);
		var attachment_ids = $images_ids.val();
		event.preventDefault();
		
		// If the media frame already exists, reopen it.
		if ( images_frame ) {
			images_frame.open();
			return;
			}

       // Create the media frame.
        images_frame = wp.media.frames.downloadable_file = wp.media({
        // Set the title of the modal.
		title: 'Select Images',
        button: {
		text: 'Insert Images',
		},
		multiple: true
         });
		 
		 
		// When an image is selected, run a callback.
         images_frame.on( 'select', function() {
			 
			 var selection = images_frame.state().get('selection');
			 
			 selection.map( function( attachment ) {
				 
				 attachment = attachment.toJSON();
				 
				 if ( attachment.id ) {
					 		$images_no.hide();
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                             $all_images.append('\
                                <li class="ewicthumbhandler" data-attachment_id="' + attachment.id + '">\
								<input type="hidden" name="ewic_meta[ewic_meta_select_images][' + attachment.id + '][images]" value="' + attachment.id + '" />\
								<span class="ewic-shorter"></span>\
                                <img src="' + attachment.sizes.thumbnail.url + '" />\
								<span class="ewic-del-images"></span>\
								<label for="title-for-'+ attachment.id +'">Title </label>\
								<input class="images-title" type="text" name="ewic_meta[ewic_meta_select_images][' + attachment.id + '][ttl]" value="' + attachment.title + '"/>\
                                </li>').hide().fadeIn(300);

                        }

                    } );

                    //$images_ids.val( attachment_ids );
                });

                // Finally, open the modal.
                images_frame.open();
            });
			
			
            // Remove images
            $('#ewic_images_container').on( 'click', '.ewic-del-images', function() {
				jQuery(this).parent().fadeOut(500, function() { 
					$(this).closest('li.ewicthumbhandler').remove();
					if ( $('.ewic-del-images').length == '0' ) {
						$images_no.show();
						}
					});
                return false;
            } );
			
});	


/* IntroJS */
      function startIntro(){
		 
        var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: '#title',
                intro: "First, enter your Slider title here."
              },				  
			  {  
                element: '#intro1',
                intro: "Click this button, after that select an images that you choose. You can use <b>Ctrl + Click</b> on images to select multiple images at once."
              },
              {
                element: '#ewic_images_container',
                intro: "All selected images will listed here.",
                position: 'right'
              },
              {
                element: '#ewic_meta_settings',
                intro: 'Finally, you can adjust the options below to fit your needs.',
                position: 'left'
              },
              {
                element: '#publish',
                intro: "When you are done, you can save the slider and put the slider into your post/page using Shortcode Manager or in widget area by dragging the widget named <b>Easy Slider Widget</b> from Appearance > Widget.",
                position: 'bottom'
              }
            ]
          });
		  
			intro.setOption('tooltipPosition', 'auto');
			intro.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top'])
            intro.start();
			
			intro.oncomplete(function() {
				jQuery('#side-sortables').css({position: 'fixed'});
			});
			
			intro.onchange(function() {
				jQuery('#side-sortables').css({position: 'relative'});
			});
			
      }