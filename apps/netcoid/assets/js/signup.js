/*!
 * NETCOID JAVASCRIPT
 * team
 * Date: Thu Nov 11 19:04:53 2010 -0500
 */
 
$(document).ready(function() {

	/* time ago plugin start */
	$('input#input-name').example('PT, CV atau Pribadi');
	$('input#input-phone').example('021-1234567 / HP');
	$('input#input-email').example('Alamat@domain.com');

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
	$("#form-red-register").validate({
		onfocusout: false,
		focusInvalid: false,
		validClass: "ajax-valid",
		errorClass: "ajax-error"
	});

	// USERNAME ERROR
	$("#input-username").rules("add", {
		regex: /^[a-zA-Z0-9_]{6,20}$/,
		required : true,
		remote: {
			url: "api/c/username",
			type: "post",
			data: {
			username: function() {
			    	return $("#input-username").val();
				}
			}
	    },
		messages: {
		 	regex: $("#input-username").data("error"),
		 	required: $("#input-username").data("error"),
		 	remote: 'Username telah digunakan, hubungi hello@networks.co.id untuk support'
		}
	});

	// PASSWORD ERROR
	$("#input-password").rules("add", {
		required : true,
		messages: {
		 	required: $("#input-password").data("error")
		}		
	});

	// COMPANY ERROR
	$("#input-name").rules("add", {
		regex: /^[a-zA-Z0-9_\s]{6,30}$/,
		required : true,
		remote: {
			url: "api/c/name",
			type: "post",
			data: {
			name: function() {
			    	return $("#input-name").val();
				}
			}
	    },
		messages: {
		 	regex: $("#input-name").data("error"),
		 	required: $("#input-name").data("error"),
		 	remote: 'Nama telah digunakan, hubungi hello@networks.co.id untuk support'
		}
	});

	// EMAIL ERROR
	$("#input-email").rules("add", { 
		regex: /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/,
		required : true,
		messages: {
		 	regex: $("#input-email").data("error"),
		 	required: $("#input-email").data("error")
		}
	});

	// PHONE ERROR
	$("#input-phone").rules("add", { 
		regex: /^([0]([0-9]{2}|[0-9]{3})[-][0-9]{6,8}|[0][8]([0-9]{8,12}))$/,
		required : true,
		messages: {
		 	regex: $("#input-phone").data("error"),
		 	required: $("#input-phone").data("error")
		}
	});
	/* validator ends */

	var $urlSuffix = $("#url-suffix");
	$("#input-username").keyup(function() {
	    var value = $(this).val();
	    $urlSuffix.text(value);
	});
});