// JavaScript Document
jQuery(document).ready(function($){
	
	
	$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight()/2;

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};
	
	

	  var posLink = $('.yoga-wrapp ul');
	  
    $(window).on('scroll', function () {
        $('.background').each(function () { 

				if ($(this).isInViewport()) { 
					
					
				var posID = $(this).attr('id'),
				    posi = $(posLink).find('li a#n-'+posID);
					
					$(posi).addClass('active');
					 
			   
				}else{
					
				var posID = $(this).attr('id'),
				    posi = $(posLink).find('li a#n-'+posID);
					$(posi).removeClass('active');
				  }
				
               
             
        });
    });
})

