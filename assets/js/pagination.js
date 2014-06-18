var pagination;

function Pagination() {
    this.construct();
}

$(document).ready(function(){
    var debug = true;

    Pagination.prototype = {
        construct: function(){
            var self = this;
            this.$prev = $('.prev-button');
            this.$pg = $('.pg-button');
            this.$next = $('.next-button');
            this.$list = $('#pagination');
            this.$rowContainer = $('.post-rows');
            this.totalPages = this.$pg.length/2;
            this.totalRows = this.$rowContainer.children().length;
            this.rowsPerPage = Math.ceil(this.totalRows / this.totalPages);
            this.$rowContainer.children().each(function(i,element) {
                if ($(element).hasClass('hidden')) {
                    $(this).hide();
                    $(this).removeClass('hidden');
                }
            })

            this.$pg.each(function(i,element){
                if ($(element).hasClass('active')) {
                    self.current = parseInt($(element).text());
                }
                $(element).find('a').attr('href','javascript:void(0);');
            });
            this.$next.find('a').attr('href', 'javascript:void(0);');
            this.$prev.find('a').attr('href', 'javascript:void(0);');

            this.setObservers();
            debug ? console.log('Current pg selected: ' + self.current) : "";
        },
        setObservers: function(){
            var self = this;

            this.$prev.on('click', function(ev){
                ev.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    self.current = self.current - 1;
                    self.reset();
                    debug ? console.log('Current pg selected: ' + self.current) : "";
                }
            });
            this.$next.on('click', function(ev){
                ev.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    self.current = self.current + 1;
                    self.reset();
                    debug ? console.log('Current pg selected: ' + self.current) : "";
                }
            });
            this.$pg.on('click', function(ev){
                ev.preventDefault();
                if (!$(this).hasClass('active')) {
                    self.current = parseInt($(this).text());
                    self.reset();
                    debug ? console.log('Current pg selected: ' + self.current) : "";
                }
            });
        },
        reset: function() {
            var self = this;

            self.$pg.each(function(i,element){
                if (self.current == parseInt($(element).text())) {
                    $(element).addClass('active').siblings().removeClass('active');
                }
            });

            self.$prev.removeClass('disabled');
            self.$next.removeClass('disabled');
            if (self.current == 1) {
                self.$prev.addClass('disabled');
            }
            if (self.current == self.totalPages) {
                self.$next.addClass('disabled');
            }
            
            self.updateView();
        },
        updateView: function() {
            var self = this;

            // Get indeces of rows to hide
            var hide = [];
            self.$rowContainer.children().each(function(index,element){
                if (!$(this).is(':hidden')) {
                    hide.push(index);
                }
            });

            // Set indeces of rows to show
            var show = [];
            var start = (this.current-1)*this.rowsPerPage;
            var end = Math.min(start+this.rowsPerPage, this.totalRows);
            for (var i=start; i<end; i++) {
                show.push(i);
            }

            var rows = self.$rowContainer.children().toArray();

            hide.forEach(function(index){
                console.log('hide: ' + index);
                $(rows[index]).fadeToggle(400);
            });
            show.forEach(function(index){
                console.log('show: ' + index);
                $(rows[index]).delay(400).fadeToggle();
            });

        }
    };

    if ($('.pagination').length>0) {
        pagination = new Pagination();
    }
});