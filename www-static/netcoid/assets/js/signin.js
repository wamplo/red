$(document).ready(function(){$.validator.addMethod("regex",function(b,c,a){a=RegExp(a);return this.optional(c)||a.test(b)},"Please check your input.");$("#form-red-login").validate({onfocusout:!1,focusInvalid:!1,validClass:"ajax-valid",errorClass:"ajax-error"});$("#input-username").rules("add",{regex:/^[a-zA-Z0-9_]{6,20}$/,required:!0,messages:{regex:$("#input-username").data("error"),required:$("#input-username").data("error")}});$("#input-password").rules("add",{required:!0,messages:{required:$("#input-password").data("error")}})});
