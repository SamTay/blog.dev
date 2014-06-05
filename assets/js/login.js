

function AjaxUserManagement() {
    this.construct();
}

$(document).ready(function(){

    AjaxUserManagement.prototype = {
        construct: function(){
            this.setObservers();
        },
        setObservers: function(){
            // Form Post Action Ajax
            //this.sendLogin();
            this.observers = [];
        },
        setFailed: function(){
            // Send Failed Message using this.setNotification();
        },
        setSuccess: function(){
            // Send Success Message using this.setNotification();
            // this.updateHeader();
        },
        setNotification: function(){
            // Display Message
        },
        sendLogin: function(){
            // Ajax Post Method
            // IF SUCCESS Fire this.setSuccess();
            // ELSE Fire this.setFailed();
        },
        getStatus: function(){
            // Leave Blank
        },
        updateHeader: function(){
        }
    };

    var ajaxUserManagement = new AjaxUserManagement();

});