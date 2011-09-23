$(document).ready(function() {
    var $tagSuffix = $("#wmd-title-preview");
    $("#wmd-title").keyup(function() {
        var value = $(this).val();
        $tagSuffix.text(value);
    });
});