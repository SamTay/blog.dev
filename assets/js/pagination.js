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
            this.rows = this.$rowContainer.children().toArray();
            this.totalPages = this.$pg.length/2;
            this.totalRows = this.$rowContainer.children().length;
            this.rowsPerPage = Math.ceil(this.totalRows / this.totalPages);
            this.speed = 500;
            // Hide rows unobtrusively, easier to use this prototype without these css classes
            this.$rowContainer.children().each(function(i,element) {
                if ($(element).hasClass('hidden')) {
                    $(this).hide();
                    $(this).removeClass('hidden');
                }
            })

            // Set current page variable and remove href attributes
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
        // Set actions for each pagination button
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
        // Resets the pagination button styling/functionality
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

            // Set direction of slide
            var hideDirection = (Math.min.apply(null,hide) <= Math.min.apply(null,show)) ? 'left' : 'right';
            var showDirection = (hideDirection === 'left') ? 'right' : 'left';
            debug ? console.log('hide->: ' + hideDirection + '. show->: ' + showDirection) : "";

            // Execute animation
            this.hideRows(hide, hideDirection);
            setTimeout(function(){
                self.showRows(show, showDirection);
            }, self.speed *.5);
        },
        // Hides each row in 'hide' array using jquery ui animation
        hideRows: function(hide,direction) {
            var self = this;
            hide.forEach(function(index){
                debug ? console.log('hide: ' + index) : "";
                $(self.rows[index]).hide('slide', {
                    easing: 'easeOutQuad',
                    direction: direction
                }, self.speed);
            });
        },
        // Shows each row in 'show' array using jquery ui animation
        showRows: function(show,direction) {
            var self = this;
            show.forEach(function(index){
                debug ? console.log('show: ' + index) : "";
                $(self.rows[index]).show('slide', {
                    easing: 'easeInQuad',
                    direction: direction
                }, self.speed);
            });
        }
    };

    if ($('.pagination').length>0) {
        pagination = new Pagination();
    }
});