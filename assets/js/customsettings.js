$("#session-msg").delay(1600).slideUp(300);

$("#session-msg-danger button").click(function(e){
    $(this).parent().slideUp(300);
});

$("textarea.wysiwyg").wysihtml5();

$("textarea.halfthebuttons").wysihtml5({
    "font-styles": false,
    "lists": false,
    "size": 'xs'
});