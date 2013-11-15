//Wayne Roddy - Inline Form Validation for Dropplets - Fall 2013
$("#form-success").hide();

//form variables
var specialChars = "<>!#$%^&*()_+[]{}?:;|\"\\/~`=";
var sc_check = function(string){for(i = 0; i < specialChars.length;i++){if(string.indexOf(specialChars[i]) > -1){return true;}}return false;}


	function validateForm(fields){
		var allValid = [];
		
		for(var i=0; i<fields.length; i++){  //for each input 
			var this_field = "#"+fields[i];
			
			//is it blank
			if($(this_field).val()<1){ invalidClass(this_field, "You have blank fields that are required.") 
				
			} else {
			
				if($(this_field).attr("type")=="text"){ if(sc_check($(this_field).val()) == false){validClass(this_field)} else {invalidClass(this_field, "Please check for Special Characters")}}
			
				if($(this_field).attr("type")=="email"){if($(this_field).val().indexOf("@") > -1){validClass(this_field)} else {invalidClass(this_field, "Where is the @ symbol?")}}
			
			}
		}
		
		function validClass(vfield){ $(vfield).removeClass("errorField"); $(vfield).addClass("validField"); $("#form_error").html(""); allValid.push("yes");}
		function invalidClass(invfield, msg){ $(invfield).addClass("errorField"); $("#form_error").html(msg); allValid.push("no");}	
		
		//if all valid process form	
		if($.inArray("no", allValid) > -1){
			// keep going its not valid
		} else {	
						
			//start process
			$.ajax({
			type: "POST",
				url: "/templates/r3_flat/php/process-form.php",
				data: {
					
					name: $("#fullname").val(),
					email: $("#email").val(),
					phone: $("#phone").val(),
					message: $("#message").val()
				}
			})
			.done(function( msg ) {
				//Universal Google Analytics Event Tracking
				//ga('send', 'event', 'unit-landing', $("#unit").val(), set_campaign);
				
				//Redirect
				//location.href = "success.html";
				
				$("#pad").hide();
				$("#form-success").show().fadeIn("fast");
			});
			
			
		}
	
	} // eof validateForm