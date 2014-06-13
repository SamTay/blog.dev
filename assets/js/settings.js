$(document).ready(function(){

    $("#search button").on('click',function(){
        $('#search').submit();
    });

    $("textarea.wysiwyg").wysihtml5();

    $("textarea.halfthebuttons").wysihtml5({
        "font-styles": false,
        "lists": false,
        "size": 'xs'
    });


    $("#comment-selector").on('click',function(){
        $("html,body").animate({scrollTop: $(document).height()}, "slow");
    });

});