

function AjaxLogin() {
    this.construct();
}

$(document).ready(function(){

    AjaxLogin.prototype = {
        construct: function(){},
        sendLogin: function(){
            $.post($('#login').attr("action"), $("#login").serialize(), function(data){
                $('#user-specific-header').load(document.URL + ' #user-specific-header-content');
                $('#user-specific-options').load(document.URL + ' #user-specific-options-content');
                $('#user-specific-comment').load(document.URL + ' #user-specific-comment-content');
                $('#session-msg').load(document.URL + ' #session-msg-content').delay(1000);
            });
        }
    }

    $('#login').submit(function(e){
        e.preventDefault();
        var ajaxLogin = new AjaxLogin();
        ajaxLogin.sendLogin();
    });

});