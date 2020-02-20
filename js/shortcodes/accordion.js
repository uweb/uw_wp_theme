'use strict';

// ### UW Accordion

// This creates a UW Accordion
// For usage, refer to the [UW Web Components webpage](http://uw.edu/brand/web#accordion)

UW.Accordion = Backbone.View.extend({

    //what element becomes an accordion
    el: '.uw-accordion',

    events: {
        'click h3': 'animate'
    },

    initialize: function initialize() {
        _.bindAll(this, 'animate');
        this.$el.find('h3').addClass('inactive');
        this.$el.find('div').addClass('inactive');
        console.log('accordion');
    },

    animate: function animate(e) {
        var $target = $(e.target);
        if ($target.hasClass('inactive')) {
            this.$el.find('h3.active').removeClass('active').addClass('inactive');
            this.$el.find('div.active').animate({ height: '0px' }, 500, function () {
                var $this = $(this);
                $this.removeClass('active').addClass('inactive');
                $this.removeAttr('style');
            });
            $target.removeClass('inactive').addClass('active');
            var $next = $target.next('div.inactive');
            $next.removeClass('inactive').addClass('active');
            var $next_height = $next.outerHeight(true);
            $next.removeClass('active');
            $next.animate({ height: $next_height }, 500, function () {
                $next.addClass('active');
                $next.removeAttr('style');
            });
        } else {
            $target.removeClass('active').addClass('inactive');
            $target.next('div.active').animate({ height: '0px' }, 500, function () {
                var $this = $(this);
                $this.removeClass('active').addClass('inactive');
                $this.removeAttr('style');
            });
        }
    }
});