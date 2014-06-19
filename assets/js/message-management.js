
var message;

function MessageManagement() {
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
            // If data given, insert session message into DOM
            if (arguments.length==1) {
                this.messageReset(data);
            }
            // If session message exists in DOM, display it
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
        // Validates data.properties and inserts into DOM
        messageReset: function(data){
            debug ? console.log('Resetting Session Message') : "";
            var self = this;

            self.messageUnset();

            if (data.hasOwnProperty('msg')) {
                $('<span id="msgSet"><strong>'+data.msg+'</strong></span>').appendTo(self.id);
            }
            if (data.hasOwnProperty('msgTone')) {
                $(self.id).addClass("alert-" + data.msgTone);
                if (data.msgTone == 'danger') {
                    $('<button type="button" class="close" area-hidden="true">&times;</button>')
                        .insertBefore('#msgSet');
                }
            }
        },
        // Display message is different for dangerous messages
        messageDisplay: function(){
            var self = this;

            if ($(self.id).hasClass(self.firmClass)) {
                self.messageFirm(self.id, 300);

            } else {
                self.messageToggle(self.id, 300, 1800);
            }
        },
        // Used for normal messages (appear then disappear)
        messageToggle: function(id, speed, delay){
            var self = this;

            $(id).slideToggle(speed).delay(delay).slideToggle(speed, function(){
                self.messageUnset();
            });

            return $(this);
        },
        // Used for dangerous messages (appear firmly)
        messageFirm: function(id, speed){
            $(id).slideDown(speed);
            return $(this);
        },
        // Unset message classes and remove from DOM
        messageUnset: function(){
            $(this.id).attr('class',
                function(i, c){
                    return c.replace(/\balert-\S+/g, '');
                });
            $(this.id + ' button').remove();
            $("#msgSet").remove();
        }
    };

    message = new MessageManagement();

});