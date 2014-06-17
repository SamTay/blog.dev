$(document).ready(function(){

    $("#search button").on('click',function(){
        $('#search').submit();
    });

    $("textarea.wysiwyg").wysihtml5();

    if ($('#postTitle').length>0) {
        $('#postTitle').focus();
    }
});