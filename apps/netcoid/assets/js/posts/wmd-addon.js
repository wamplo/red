$(document).ready(function() {
    var $tagSuffix = $("#wmd-title-preview");
    $("#wmd-title").keyup(function() {

    	// VALUE WMD TITLE
		var title = $("#wmd-title").val();
        
        // NO TRIM JIKA DIBAWA X
        if (title.length < 60) {
	        var value = $(this).val();
	        $tagSuffix.text(value);
	        $("#wmd-title-readmore-preview").text('');
		};

		// TRIM JIKA DIATAS X
	    if (title.length > 60) {
	    	title60 = title.substring(0,60)
 			$tagSuffix.text(title60 + '(...)');

 			$("#wmd-title-readmore-preview").text(title);

 			if (title.length >= 140) { 
 				$tagSuffix.html('<span class="error">Error! judul tidak boleh diatas 140 kata</span>');
 				$("#wmd-title-readmore-preview").text("informasi judul terlalu banyak");
 				$('#form-red-wmd').submit(function(){
 					return false;
 				});
 			}
	    };
    });
});