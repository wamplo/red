/*!
 * NETCOID JAVASCRIPT
 * team
 * Date: Thu Nov 11 19:04:53 2010 -0500
 */
$(document).ready(function() {

    var converter = Markdown.getSanitizingConverter();
    var help = function () { alert("Do you need help? support@networks.co.id"); }
    var wmdeditor = new Markdown.Editor(converter, "", { handler: help });
    wmdeditor.run();

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
    }); 


 
	var $nameSuffix = $("#wmd-name-preview");
	$("#wmd-name").keyup(function() {
	    var value = $(this).val();
	    $nameSuffix.text(value);
	});

    var $tagSuffix = $("#wmd-tag-preview");
    $("#wmd-tag").keyup(function() {
        var value = $(this).val();
        $tagSuffix.text(value);
    });
    */
    // IMPORTANT! POST
    $("#form-red-wmd").submit(function() {
        var content_html = converter.makeHtml($("#wmd-input").val());
        $("#wmd-content-html").val(content_html);
    });
});