var ajaxComment;

function AjaxComment() {
    this.construct();
}

$(document).ready(function(){
    var debug = true;

    AjaxComment.prototype = {
        construct: function(){
            $("textarea.halfthebuttons").wysihtml5({
                "font-styles": false,
                "lists": false,
                "size": 'xs'
            });
            this.comment = $('#comment');
            this.editor = this.comment.data("wysihtml5").editor;
            this.form = $("#comment-form");
            this.commentSelect = $("#comment-selector");
            this.counter = $('#commentCount');
            this.observers = [];
            this.setObservers();
        },
        setObservers: function(){
            var self = this;

            self.commentSelect.on('click',function(){
                console.log('clicked');
                $("html,body").animate({scrollTop: $(document).height()}, "slow", function(){
                    self.editor.focus();
                });
            });
            this.form.on('submit', function(e){
                e.preventDefault();
                $(".dropdown").removeClass("open");
                self.sendComment();
            });
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
        addToView: function(data) {
            var self = this;

            if (data.hasOwnProperty('user') && data.hasOwnProperty('commentText')
                && data.hasOwnProperty('commentCreated')) {
                debug ? console.log('adding to view: ') : "";
                $('<li class="list-group-item">'
                    +'<p><strong>'+data.user+':</strong></p>'
                    +'<p>'+data.commentText+'</p>'
                    +'<p class = "date">'+data.commentCreated+'</p>'
                +'</li>').insertBefore(self.form.parent());

                debug ? console.log('incrementing counter'): "";
                self.counter.text(parseInt(self.counter.text()) + 1);
            }
        },
        reset: function() {
            // Set textarea = ""
            this.editor.setValue("").focus();
        },
        sendComment: function(){
            debug ? console.log('Commenting: ') : "";
            var self = this;

            $.ajax({
                type: 'POST',
                url: self.form.attr('action'),
//                TODO data: 'comment='+$('textarea').text(), // unfortunately .text doesn't work on textarea
                data: self.form.serialize(),
                success: function(data, textStatus, XMLHttpRequest) {
                    if (data.success) {
                        console.log('data.success: ' + data.success);
                        self.addToView(data);
                    }
                    self.notifyObservers(data);
                    self.reset();
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    debug ? console.log('sendComment: error called: ' + errorThrown) : "";
//                    $(location).attr('href','http://blog.dev/error');
                }
            });
        }
    };

    if ($('#comment-form').length>0) {
        ajaxComment = new AjaxComment();
        ajaxComment.addObserver(message);
    }
});