
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
        // Reset items in view that are user-access specific
        reset: function(data){

            if (arguments.length==1 && data.hasOwnProperty('access'))  {
                debug ? console.log('Resetting Access Items:') : "";

                // Hide all options
                $(".options").hide();
                // Then show the appropriate ones
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