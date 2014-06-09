

function AjaxLogin() {
    this.construct();
}

$(document).ready(function(){

    AjaxLogin.prototype = {
        construct: function(){},
        sendLogin: function(){
            $.post($('#login').attr("action"), $("#login").serialize(), function(data){
                $('#user-specific-header').load(document.URL + ' #user-specific-header');
                $('#user-specific-options').load(document.URL + ' #user-specific-options');
                $('#user-specific-comment').load(document.URL + ' #user-specific-comment');
                $('#session-msg').load(document.URL + ' #session-msg');
                $('#footer').load(document.URL + ' #footer');
            });
        }
    }

    $('#login').submit(function(e){
        e.preventDefault();
        var ajaxLogin = new AjaxLogin();
        ajaxLogin.sendLogin();
    });

});