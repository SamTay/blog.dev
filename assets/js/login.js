

function AjaxUserManagement() {
    this.construct();
}

function MessageManagement() {
    this.construct();
}

function HeaderManagement() {
    this.construct();
}

function ButtonManagement() {
    this.construct();
}

$(document).ready(function(){
    var debug = true;

    MessageManagement.prototype = {
        construct: function(){
            this.id = "#session-msg";
            this.firmClass = "alert-danger";

            this.reset();
        },
        reset: function(data){
            if (arguments.length==1) {
                this.messageReset(data);
            }
            if ($("#msgSet").length!=0) {
                this.messageDisplay();
            }
            $("button.close").on('click',function(e){
                e.preventDefault;
                $(this).parent().slideUp(300, function(){
                    message.messageUnset();
                });
            });
        },
        messageReset: function(data){
            debug ? console.log('Resetting Session Message') : "";
            var self = this;

            self.messageUnset();

            if (data.hasOwnProperty('msg')) {
                $(data.msg).appendTo(self.id);
            }
            if (data.hasOwnProperty('msgTone')) {
                $(self.id).addClass("alert-" + data.msgTone);
                if (data.msgTone == 'danger') {
                    $('<button type="button" class="close" area-hidden="true">&times;</button>')
                        .appendTo(self.id);
                }
            }
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
                self.messageUnset();
            });

            return $(this);
        },
        messageFirm: function(id, speed){
            $(id).slideDown(speed);
            return $(this);
        },
        messageUnset: function(){
            $(this.id).attr('class',
                function(i, c){
                    return c.replace(/\balert-\S+/g, '');
                });
            $(this.id + ' button').remove();
            $("#msgSet").remove();
        }
    };

    HeaderManagement.prototype = {


        construct: function(){
            this.reset();
        },
        reset: function(data){
            debug ? console.log('Resetting Header Items:') : "";

            if (arguments.length==1 && data.hasOwnProperty('headerOptions'))  {
                $(".options").hide();

                switch (data.headerOptions) {
                    case ('anonymous') :
                        $("." + data.headerOptions + "Options").removeClass('hidden').show();
                        break;
                    case ('admin') :
                        $("." + data.headerOptions + "Options").removeClass('hidden').show();
                    case ('user' || 'admin') :
                        $("#username-text").text(' ' + data.user);
                        $(".userOptions").removeClass('hidden').show();
                        break;
                }
            }
        }
    };
    
    ButtonManagement.prototype = {
        construct: function(){
            this.reset();
        },
        reset: function(){
        	
        }
    };

    AjaxUserManagement.prototype = {
        construct: function(){
            this.form = $("#login");
            this.observers = [];

            this.setObservers();
        },
        setObservers: function(){
            var self = this;

            $("*").unbind('click');
            $("*").unbind('submit');

            $("#login-dropdown").on('click', function(){
                debug ? console.log("dropdown clicked") : "";
                $("button.close").click();
            });

            $("#logout").on('click', function(e){
            	e.preventDefault;
            	self.sendLogout();
            })

            $("#login").on('submit', function(e){
                e.preventDefault();
                $(".dropdown").removeClass("open");
                self.sendLogin();
            });
        },
        addObserver: function(observer) {
            this.observers.push(observer);
            return this;
        },
        notify: function(data) {
            for (var i=0; i<this.observers.length; i++) {
                this.observers[i].reset(data);
            }
        },
        sendLogin: function(){
            debug ? console.log('Sending Login') : "";
            var self = this;

            $.ajax({
                type: 'POST',
                url: $('#login').attr('action'),
                data: $('#login').serialize(),
                success: function(data, textStatus, XMLHttpRequest) {
                    self.notify(data);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    debug ? console.log('sendLogin: error called') : "";
                    $(location).attr('href','http://blog.dev/user/login');
                }
            });
        },
        sendLogout: function(){
            debug ? console.log('Sending logout') : "";
            var self = this;

            $.get($('#logout').attr('href'), function(data){
                debug ? console.log('logout: data = ' + data) : "";
                self.notify(data);
            });
        }
    };

    var ajaxLogin = new AjaxUserManagement();
    var message = new MessageManagement();
    var header = new HeaderManagement();

    ajaxLogin.addObserver(message).addObserver(header);




// Custom Settings

    $("#search button").on('click',function(){
        $('#search').submit();
    });

    $("#comment-selector").on('click',function(){
        $("html,body").animate({scrollTop: $(document).height()}, "slow");
    });

    $("textarea.wysiwyg").wysihtml5();

    $("textarea.halfthebuttons").wysihtml5({
        "font-styles": false,
        "lists": false,
        "size": 'xs'
    });
});