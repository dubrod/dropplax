function autoDLC(galleryname){
	
		//CUSTOMIZED VARIABLES
		gallery			= galleryname+"/";
		thumbFolder  	= "tns/";
		photosFolder  	= "photos/";
		magnifierImg	= "plugins/autoDLC/images/zoom-in.png";
		prevArrow		= "&lt;";
		nextArrow		= "&gt;";
		preloadBigs		= true;
		
		//SETUP
		posId 			= 0;
		fileextension	= ".jpg";
		photosObject	= new Object();
		photosObject	= [];
		
		//GET PHOTOS FOLDER / MAKE OBJECT
		ajaxFolder = "galleries/"+gallery+photosFolder;
		$.ajax({
            url: ajaxFolder,
            success: function (files) {
                $(files).find("a:contains(" + fileextension + ")").each(function () {
                	var filename = this.href.split('/').pop();
                    obj = {"name": filename};
                    photosObject.push(obj);
                });
            }
        });
           
        $(document).ajaxSuccess(function() {
        	for ( var i=0; i<photosObject.length; i++ ) {
        		if(!photosObject[i]){break;} //error failsafe
				$("#autoDLC").append('<div class="tn"><div class="img"><img src="galleries/'+ gallery + thumbFolder + photosObject[i].name + '"></div><button class="adlc-thumbnail" data-info=\'{"photo":"' + photosObject[i].name + '","id":"' + i + '"}\'><img src="'+ magnifierImg + '" alt="ENLARGE" /></button></div>');
			}
			
			//CLICK EVENT MUST INITIALIZED IN HERE 
			$('.adlc-thumbnail').click(function() {
				photoname = $(this).data('info').photo;
				photoid = $(this).data('info').id;
				
				showGallery(photoname, photoid);
			});
			
			//NEXT SLIDE
			$('.next').click( function(){
				posId++;
		
				if(!photosObject[posId]){posId = 0;}
				$('#imageWindow').html('<img src="galleries/'+gallery+photosFolder+photosObject[posId].name+'">');
				
			});
			
			//PREV SLIDE
			$('.prev').click( function(){
				posId--;
				
				if(!photosObject[posId]){posId = photosObject.length;}
				$('#imageWindow').html('<img src="galleries/'+gallery+photosFolder+photosObject[posId].name+'">');
				
			});
			
			//PRELOAD SET TRUE OR FALSE
			if(preloadBigs==true){
				for ( var i = 0; i < photosObject.length; i++ ) {
	        		if(!photosObject[i]){break;} //error failsafe
					$("#preloadBigs").append('<img src="galleries/'+gallery+photosFolder+photosObject[i].name+'">');
				}
			}
			
			//CLOSE EVENT
			$('#closeGallery').click(function() {$('#galleryWindow').fadeOut("slow");});
			
			//ESC CLOSE
			$(document).bind('keydown', function(e){if(e.which == 27){$('#galleryWindow').fadeOut("slow");}}); 	

        }); // EOF AFTER SUCCESS       

		//RUN THE GALLERY
		function showGallery(photoname, photoid){
			posId = photoid;
			$('#galleryWindow').fadeIn("slow");
			$('#imageWindow').html('<img src="galleries/'+gallery+photosFolder+photoname+'">');
			$('#imageWindow').fadeIn("slow");
		};
		
		//APPEND THE POPUP
		$('body').append('<div id="galleryWindow"><div id="imageContainer"><div id="closeGallery">Click Here or Hit ESC Key to Close</div><div class="slimControls prev"><button>'+prevArrow+'</button></div><div class="slimControls next"><button>'+nextArrow+'</button></div><div id="imageWindow"></div></div></div><div id="preloadBigs" style="display:none;"></div>');

}; // eof autoDLC function