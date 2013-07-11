jQuery.noConflict();

jQuery("document").ready(function($){
	$("#footer-menu ul li:last-child").css("border", "none");
	$("#main-footer .info-container address:last-child").css("margin-right", "-8px");
	$("#header-menu ul li").append("<img class='menu_slash' src='http://localhost/wp/wp-content/themes/evolutionpcc/images/menu_slash.png' />");
	$("#header-menu ul li:nth-child(4)").css("margin-left", "225px").prepend("<img class='menu_slash' src='http://localhost/wp/wp-content/themes/evolutionpcc/images/menu_slash.png' />");
	$("#header-menu ul li:nth-child(4) img:first-child").css("margin-left", "-12px");
	//$("#header-menu ul li:nth-child(3)").children("img").remove();
	$("#header-menu ul li:last-child").css("margin-right", "-10px").children("img").remove();
});