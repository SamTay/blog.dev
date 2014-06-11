

function AjaxLogin() {
    this.construct();
}

function Message() {
    this.construct();
}

$(document).ready(function(){

    Message.prototype = {
        construct: function(){
            this.id = "#session-msg";
            this.firmClass = "alert-danger";

            this.setObserving();
        },
        setObserving: function(){
            if ($("#msgSet").length!=0) {
                this.messageDisplay();
            }
        },
        reset: function(){
            this.setObserving();
        },
        messageDisplay: function(){
            var self = this;

            if ($(self.id).hasClass(self.firmClass)) {
                self.messageFirm(self.id, 300);
            } else {
                self.messageToggle(self.id, 300, 1800);
            }
        },
        messageToggle: function(id, speed, delay){
            var self = this;

            $(id).slideToggle(speed).delay(delay).slideToggle(speed, function(){
                self.messageUnset()
            });

            return $(this);
        },
        // Need to account for danger message removal
        messageFirm: function(id, speed){
            var self = this;

            $(id).slideDown(speed);
            return $(this);
        },
        messageUnset: function(){
            $("#msgSet").remove();
        }
    };

    AjaxLogin.prototype = {
        construct: function(){
            this.form = $("#login");
            this.sessionMsg = $("#session-msg");
            this.observers = [];

            this.setObservers();
        },
        setObservers: function(){
            var self = this;

            $("#login-dropdown").on('click', function(){
                console.log("dropdown clicked");
                $("#username").focus(function(){
                    console.log("username focused");
                });
            });

            $("#login").on('submit', function(e){
                e.preventDefault();
                self.sendLogin();
            });
        },
        addObserver: function(observer) {
            this.observers.push(observer);
        },
        notify: function() {
            for (var i=0; i<this.observers.length; i++) {
                this.observers[i].reset();
            }
        },
        resetUserSpecificItems: function(data){
            console.log('Resetting User Specific Items:');
        },
        resetSessionMsg: function(data){
            console.log('Resetting Session Message');
            $(data.msg).appendTo("#session-msg");
            this.notify();
        },
        sendLogin: function(){
            console.log('Sending Login');

            var self = this;
            $.ajax({
                type: 'POST',
                url: $('#login').attr('action'),
                data: $('#login').serialize(),
                success: function(data, textStatus, XMLHttpRequest) {
                    self.resetUserSpecificItems(data);
                    self.resetSessionMsg(data);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    self.resetSessionMsg();
                }
            });
        }

    };

    var ajaxLogin = new AjaxLogin();
    var message = new Message();

    ajaxLogin.addObserver(message);

    $("button.close").on('click',function(e){
        $(this).parent().slideUp(300, function(){
            message.messageUnset();
        });
    });

});