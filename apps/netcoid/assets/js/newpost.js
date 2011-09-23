/*!
 * NETCOID JAVASCRIPT
 * team
 * Date: Thu Nov 11 19:04:53 2010 -0500
 */
 
$(document).ready(function() {
    
    $(".red-ajax-select").chosen();

    var converter = Markdown.getSanitizingConverter();
    var help = function () { alert("Do you need help?"); }
    var wmdeditor = new Markdown.Editor(converter, "", { handler: help });

    /* wmdeditor.hooks.set("insertImageDialog", function (callback) {
        alert("Please click okay to start scanning your brain...");
        setTimeout(function () {
            var prompt = "We have detected that you like cats. Do you want to insert an image of a cat?";
            if (confirm(prompt))
                callback("http://icanhascheezburger.files.wordpress.com/2007/06/schrodingers-lolcat1.jpg")
            else
                callback(null);
        }, 2000);
        return true; // tell the editor that we'll take care of getting the image url
    }); */

    wmdeditor.run();
 
	var $titleSuffix = $("#wmd-title-preview");
	$("#wmd-title").keyup(function() {
	    var value = $(this).val();
	    $titleSuffix.text(value);
	});

    // IMPORTANT! POST
    $("#form-red-news-new").submit(function() {
        var content_html = converter.makeHtml($("#wmd-input").val());
        $("#wmd-content-html").val(content_html);
    });

});