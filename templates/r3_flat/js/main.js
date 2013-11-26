$(document).ready(function() {

	$("#intakeButton").click(function(){ var fields = new Array("fullname", "phone", "email"); validateForm(fields) });
	
	
    //ACTIVATE SMOOTHNESS
    $('menu a').smoothScroll();
    $('menu a').click( function(){ $('menu a').removeClass("active");  $(this).addClass("active"); });
			 
			 
	//SCROLLING FEATURES
	var lastScrollTop = 0;    

    $(window).scroll(function(event){
     	var st = $(this).scrollTop();
	 	console.log(st);
	 	
	 	//stick the footer		    
	 	if (st > 172){ $("menu").css("position", "fixed");}
	 	if (st < 172){ $("menu").css("position", "relative");}
		
		//avatar movement
		if (st > 130){ $("#avatar").css("margin-top", "140px");}
		if (st > 160){ $("#avatar").css("margin-top", "135px");}
		if (st > 190){ $("#avatar").css("margin-top", "130px");}
		if (st > 220){ $("#avatar").css("margin-top", "125px");}
		if (st > 240){ $("#avatar").css("margin-top", "120px");}
		if (st > 280){ $("#avatar").css("margin-top", "110px");}
		if (st > 290){ $("#avatar").css("margin-top", "90px");}
		if (st > 300){ $("#avatar").css("margin-top", "85px");}
		if (st > 310){ $("#avatar").css("margin-top", "80px");}
		if (st > 320){ $("#avatar").css("margin-top", "75px");}
		if (st > 330){ $("#avatar").css("margin-top", "70px");}
		if (st > 340){ $("#avatar").css("margin-top", "60px");}
		if (st > 350){ $("#avatar").css("margin-top", "50px");}
		if (st > 360){ $("#avatar").css("margin-top", "40px");}
		if (st > 370){ $("#avatar").css("margin-top", "30px");}
		if (st > 390){ $("#avatar").css("margin-top", "20px");}
		if (st > 410){ $("#avatar").css("margin-top", "10px");}
		if (st > 430){ $("#avatar").css("margin-top", "0");}
			
		lastScrollTop = st;
	
	});	
	//EOF SCROLLING FEATURES
	
	
});	