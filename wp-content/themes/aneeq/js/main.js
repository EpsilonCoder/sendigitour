// Preloader
jQuery(document).ready(function() {
	// site preloader 
	jQuery(window).load(function(){
		jQuery('.loader-wrapper').fadeOut('slow',function(){jQuery(this).remove();});
	});
});


(function(jQuery){
    jQuery(document).ready(function(){

        /*----------------------------------------------------*/
        /*	Same Height Div's
        /*----------------------------------------------------*/
        if(jQuery.isFunction(jQuery.fn.matchHeight)){
            jQuery('.same-height').matchHeight();
        }

        /*===========================================================*/
        /*	Image Hover Effect - HoverDirection.js
        /*===========================================================*/
        if(jQuery.isFunction(jQuery.fn.hoverDirection)){
            jQuery('.box').hoverDirection();

            // Example of calling removeClass method after a CSS animation
            jQuery('.box .inner').on('animationend', function (event) {
                var $box = jQuery(this).parent();
                $box.filter('[class*="-leave-"]').hoverDirection('removeClass');
            });
        }
    });
})(this.jQuery);

jQuery(document).ready(function() {
    /*============
     BUTTON UP
     * ===========*/
    var btnUp = jQuery('<div/>', {'class':'btntoTop'});
    btnUp.appendTo('body');
    jQuery(document)
        .on('click', '.btntoTop', function() {
            jQuery('html, body').animate({
                scrollTop: 0
            }, 700);
        });

    jQuery(window)
        .on('scroll', function() {
            if (jQuery(this).scrollTop() > 200)
                jQuery('.btntoTop').addClass('active');
            else
                jQuery('.btntoTop').removeClass('active');
        });
});


// fraction slider settings
jQuery(window).load(function() {
	jQuery("#aneeq-slider").owlCarousel({	
		items: 1,
		singleItem: true,
		itemsScaleUp : true,
		autoplay: 2500,
		autoplayHoverPause:false,	
		autoplayTimeout:true,
		loop:true,	
		nav: true, // is true across all sizes
		navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		dots: false,
		autoHeight:true,
		onInitialized: setOwlStageHeight,
		onResized: setOwlStageHeight,
		onTranslated: setOwlStageHeight		
	});				 
});

function setOwlStageHeight(event) {
    var maxHeight = 0;
    jQuery('.owl-item.active').each(function () { // LOOP THROUGH ACTIVE ITEMS
        var thisHeight = parseInt( jQuery(this).height() );
        maxHeight=(maxHeight>=thisHeight?maxHeight:thisHeight);
    });
    jQuery('.owl-carousel').css('height', maxHeight );
    jQuery('.owl-stage-outer').css('height', maxHeight ); // CORRECT DRAG-AREA SO BUTTONS ARE CLICKABLE
}

//Pagination class add and active class add
jQuery(document).ready(function(){
	jQuery( "ul.page-numbers" ).addClass( "pagination mrgt-0" );
});