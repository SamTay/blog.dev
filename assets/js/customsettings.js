//$("#session-msg").delay(1600).slideUp(300);

messageSet = function(){
    if ($("#session-msg").hasClass("alert-danger")) {
        messageFirm("#session-msg", 300);
    } else {
        messageToggle("#session-msg", 300, 1800);
    }
}

messageToggle = function(id, speed, delay){
    $(id).slideToggle(speed).delay(delay).slideToggle(speed);
}

messageFirm = function(id, speed){
    $(id).slideDown(speed);
}

$("button.close").on('click',function(e){
    $(this).parent().slideUp(300);
});

$("#search button").on('click',function(){
   $('#search').submit();
});

$("#comment-selector").on('click',function(){
    $("textarea").live('focus', function(){
        alert('focus called');
        this.select();
    });
});

$("textarea.wysiwyg").wysihtml5();

$("textarea.halfthebuttons").wysihtml5({
    "font-styles": false,
    "lists": false,
    "size": 'xs'
});