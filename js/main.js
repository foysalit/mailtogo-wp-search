jQuery.noConflict();

jQuery("document").ready(function($){
	var post_uri = tmp_uri + "/inc/handle_ajax.php";
	
	//contact form functionality
	/*var contact_form = $("#contact-form");
	
	contact_form.validate({
		rules: {
			user_name: {
				required: true,
				minlength: 3
			},
			user_email: {
				required: true,
				email: true
			},
			user_message: {
				required: true,
				minlength: 3
			}
		},
		messages: {
			user_name: "write your name",
			user_email: "invalid email address",
			user_message: "write a message"
		}
	});
	$("#submit-form").click(function(){
		if(contact_form.valid()){
			var contact_form_data = contact_form.serialize();
			$.post(contact_form.attr("action"), contact_form_data, function(msg){
				console.log(msg.status);
				contact_form.slideUp().next().delay(800).fadeIn("slow");
			}, "json");
			//console.log(contact_form_data);
		}
	});*/
});