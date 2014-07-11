var Alert = function(){
    var MARGIN_TOP = 10;
    var _this = this
        , dom = $('<div/>').addClass('alert-plane')

    this.content = function ( txt ) {
        dom.html('').append( txt );
        return this;
    }

    this.show = function (txt, sec) 
    {
        var lastDom = $('.alert-plane:last');
        var top = lastDom.length == 0 
            ? 0
            : Number(lastDom.css('margin-top').replace('px','')) + lastDom.outerHeight() + MARGIN_TOP;
        if ( txt !== undefined ) {
            this.content( txt );
        }
        dom.css('margin-top', top )
            .append( txt )
            .appendTo( $('body') );

        setTimeout( function () {
            dom.addClass('alert-fade-in');
        }, 1 );

        if ( sec ) {
            this.remove( sec );
        }
        return this;
    }

    this.remove = function ( sec ) {
        sec = sec || 1;
        setTimeout( function () {
            dom.addClass('alert-fade-out').removeClass('alert-fade-in');
        }, sec );
        setTimeout( function () {
            var height = dom.outerHeight() + MARGIN_TOP;
            dom.find('~').each( function() {
                $(this).css( 'margin-top', Number($(this).css('margin-top').replace('px','')) - height );
            });
            dom.remove();
        }, sec + 200 );
    }
    return this;
};
