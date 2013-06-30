$(document).ready( function() {
	//One element to show
	$('.bigimage').hide();
	$('.bigimage:first').show();
	
	var options = {  
        zoomType: "standard",  
        lens:true,  
        preloadImages: false,  
        alwaysOn:false,  
        zoomWidth: 400,  
        zoomHeight: 350,  
        xOffset:10,  
        yOffset:0,  
        position:"left",
        title: false
     };
	
	$(".jqzoom").jqzoom(options);
	
	$(".pthumb").each(function() {
	    $(this).css('cursor', 'pointer');
	});
	
	$(".pthumb").click(function() {
		var imgref = $(this).attr('dir');
		//check whether same div is visible
		function check() {
			var obj = $('.bigimage:visible').attr('id');
			if (obj != imgref)
				return true;
			else
				return false;
		}
		function complete() {
			 $(".jqclass").removeClass("jqclass");
			 $("#"+imgref).fadeIn('fast');
	    	 $("#"+imgref+" a").addClass("jqclass").jqzoom(options);
		}
		if(check()==true) {
			$(".jqclass").unbind(".jqclass");
			$('.bigimage').fadeOut('fast', complete);
		}
	});
});