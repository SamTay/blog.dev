

function AjaxLogin() {
    this.construct();
}

$(document).ready(function(){

    messageSet();

    AjaxLogin.prototype = {
        construct: function(){
            this.form = $("#login");
            this.sessionMsg = $("#session-msg");

            this.setObservers();
        },
        setObservers: function(){
            this.form.on('submit', this.sendLogin());
        },
        resetUserSpecificItems: function(){
            $('#user-specific-header').load(document.URL + ' #user-specific-header', function(){
                $(this).children().unwrap();
            });
            $('#user-specific-options').load(document.URL + ' #user-specific-options', function(){
                $(this).children().unwrap();
            });
//            $('#user-specific-comment').load(document.URL + ' #user-specific-comment', function(){
//                $(this).children().unwrap();
//            });
        },
        resetSessionMsg: function(){
            //this.sessionMsg.load() was not working!
            $("#session-msg").load(document.URL + ' #session-msg', function(){
                $(this).children().unwrap();
                messageSet();
            });
        },
        sendLogin: function(){
            $.post($('#login').attr("action"), $("#login").serialize(), function(data){
                if (data) {
                    console.log(data);
                    AjaxLogin.prototype.resetUserSpecificItems.call(this);
                }
                AjaxLogin.prototype.resetSessionMsg.call(this);
            });
        }

    };

    var ajaxLogin = new AjaxLogin();

});