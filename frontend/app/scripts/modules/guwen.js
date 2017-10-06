;(function(app, gee, $){
    'use strict';

    // register a module name
    app.guwen = {
    };

    gee.hook('initGuwen', function (me) {
        var type = me.data('type');

        $('[data-toggle="tooltip"]').tooltip({placement: 'left'});
        $('#myTab a:eq(3)').tab('show');
    });

    /**
     * reaction of Calculator
     */
    gee.hook('reactGuwen', function(me) {
        var ta = $(me.event.target);
        var func = ta.attr('func');

        if (gee.check(func)) {
            ta.event = me.event;
            gee.exe(func, ta);
        }
    });

}(app, gee, jQuery));