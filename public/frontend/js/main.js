// JavaScript Document

//for input group focus
jQuery(document).ready(function() {
	new WOW().init();
    jQuery(".input-group > input").focus(function(e){
        $(this).parent().addClass("input-group-focus");
    }).blur(function(e){
        jQuery(this).parent().removeClass("input-group-focus");
    });
});