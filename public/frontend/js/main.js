// JavaScript Document

//for input group focus
jQuery(document).ready(function() {
	new WOW().init();
    jQuery(".input-group > input").focus(function(e){
        $(this).parent().addClass("input-group-focus");
    }).blur(function(e){
        jQuery(this).parent().removeClass("input-group-focus");
    });
    
    
     setInterval(function(){ 
		 
		 if (jQuery("#member_form, #member_login").length>0) {
			window.location.reload();
		 }
		 
		 }, 224000);
});