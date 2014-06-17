$(document).ready(function(){

    $("#search button").on('click',function(){
        $('#search').submit();
    });

    $("textarea.wysiwyg").wysihtml5();
});