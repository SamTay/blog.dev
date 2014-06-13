
var access;

function AccessManagement() {
    this.construct();
}

$(document).ready(function(){
    var debug = true;

    AccessManagement.prototype = {

        construct: function(){
            this.reset();
        },
        reset: function(data){

            debug ? console.log('Resetting Access Items:') : "";

            if (arguments.length==1 && data.hasOwnProperty('access'))  {

                $(".options").hide();

                switch (data.access) {
                    case ('anonymous') :
                        $("." + data.access + "Options").removeClass('hidden').show();
                        break;
                    case ('admin') :
                        $("." + data.access + "Options").removeClass('hidden').show();
                    case ('user' || 'admin') :
                        $(".username-text").text(' ' + data.user);
                        $(".userOptions").removeClass('hidden').show();
                        break;
                }
            }
        }
    };

    access = new AccessManagement();

});