/*!
 * NETCOID JAVASCRIPT
 * team
 * Date: Thu Nov 11 19:04:53 2010 -0500
 */
 
$(document).ready(function() {

	/* validator plugin start */
	$.validator.addMethod(
	        "regex",
	        function(value, element, regexp) {
	            var check = false;
	            var re = new RegExp(regexp);
	            return this.optional(element) || re.test(value);
	        },
	        "Please check your input."
	);

	// START FORM
	$("#form-red-login").validate({
		onfocusout: false,
		focusInvalid: false,
		validClass: "ajax-valid",
		errorClass: "ajax-error"
	});

	// USERNAME ERROR
	$("#input-username").rules("add", {
		regex: /^[a-zA-Z0-9_]{6,20}$/,
		required : true,
		messages: {
		 	regex: $("#input-username").data("error"),
		 	required: $("#input-username").data("error")
		}
	});

	// PASSWORD ERROR
	$("#input-password").rules("add", {
		required : true,
		messages: {
		 	required: $("#input-password").data("error")
		}		
	});
});