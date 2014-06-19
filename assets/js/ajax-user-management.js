var ajaxUserManagement;

function AjaxUserManagement() {
    this.construct();
}

$(document).ready(function(){
    var debug = true;

    AjaxUserManagement.prototype = {
        construct: function(){
            this.form = $("#login");
            this.observers = [];

            this.setObservers();
        },
        // Set actions for each login/logout option
        setObservers: function(){
            var self = this;

            $("#login-dropdown").on('click', function(){
                debug ? console.log("dropdown clicked") : "";
                $("button.close").click();
                setTimeout('$("#username").focus()', 100);
            });

            $("#logout").on('click', function(e){
            	e.preventDefault();
            	self.sendLogout();
            });

            $("#login").on('submit', function(e){
                e.preventDefault();
                $(".dropdown").removeClass("open");
                self.sendLogin();
            });
        },
        // Clear password
        reset: function() {
            $("#login #password").val("");
        },
        addObserver: function(observer) {
            this.observers.push(observer);
            return this;
        },
        notifyObservers: function(data) {
            for (var i=0; i<this.observers.length; i++) {
                this.observers[i].reset(data);
            }
        },
        // Use ajax to validate login info and store in session
        sendLogin: function(){
            debug ? console.log('Sending Login') : "";
            var self = this;

            $.ajax({
                type: 'POST',
                url: $('#login').attr('action'),
                data: $('#login').serialize(),
                dataType: "json",
                success: function(data, textStatus, XMLHttpRequest) {
                    self.notifyObservers(data);
                    self.reset();
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    debug ? console.log('sendLogin error called: '+textStatus+' '+errorThrown) : "";
                    // Redirect to actual login page if ajax call is unsuccessful
                    $(location).attr('href','http://blog.dev/user/login');
                }
            });
        },
        // Use ajax to reset session variable and logout
        sendLogout: function(){
            debug ? console.log('Sending logout') : "";
            var self = this;

            $.get($('#logout').attr('href'), function(data){
                debug ? console.log('logout: data = ' + data) : "";
                self.notifyObservers(data);
            });
        }
    };

    ajaxUserManagement = new AjaxUserManagement();

    ajaxUserManagement.addObserver(message).addObserver(access);

});