var imgView = null;

$(function() {

    $(window).resize( function () { 
        $('#holder').css('height', window.innerHeight - $('header').outerHeight() - $('footer').outerHeight());
    }).resize();

    imgView = new ImageView( $('#img-panel') );
    loadImage();

});

/* load Images */
    function loadImage () 
    {
        $.ajax( '/server.php/ajaxImages', { type: 'post', dataType: 'json' } )
            .done ( function ( imgs ) {
                for ( var i in imgs ) {
                    imgView.append( i, imgs[i] );
                }
            });
    }



var ImageView = function ( dom ) 
{
    var KEY_CODE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var imgs = {};
    var imgPanel = $(dom);
    var LoadingAnimate = '<div class="loading-animate fade"> <div class="spinner"></div> </div>';
    var _this = this;
    this.random = function (min, max) 
    {
        return Math.floor( Math.random() * (max-min+1) + min );
    }

    this.getKey = function ( len ) {
        var key = '';
        len = len || 7;
        do {
            key = '';
            while ( key.length < len ) {
                key += KEY_CODE.charAt( this.random(0, KEY_CODE.length - 1) );
            }
        } while ( imgs[ key ] );
        return key;
    }
    this.has = function ( key ) 
    {
        return imgs[ key ] ? true : false;
    }
    this.changeKey = function ( old_key, new_key ) 
    {
        // imsg[ new_key ] = [ imgs[old_key] ].slice()[0];
        if ( ! this.has( old_key ) ) {
            return false;
        }
        imgs[ new_key ] = imgs[ old_key ];
        delete imgs[ old_key ];
        $('li#' + old_key).attr('id', new_key);
        return true;
    }
    this.setLoading = function ( key ) 
    {
        var liDom = $('li#' + key);
        if ( liDom.length < 1 ) {
            return false;
        }
        liDom.html( LoadingAnimate );
        setTimeout( function () {
            liDom.find('.loading-animate').addClass('in');
        }, 1);

    }
    this.remove = function ( key ) {
        if ( ! this.has(key) ) {
            return false;
        }
        delete imgs[ key ];
        var liDom = $('li#' + key);
        liDom.removeAttr('id');
        liDom.removeClass('in');
        setTimeout( function () {
            liDom.remove();
        }, 200);
    }
    this.update = function ( key, data ) 
    {
        if ( ! this.has(key) ) {
            return false;
        }
        var liDom = $('li#' + key);
        
        this.setLoading( key );

        imgs[ key ] = new Image();
        imgs[ key ].onload = function ()
        {
            liDom.find(' > .loading-animate').removeClass('in');
            // liDom.append( $('<a/>').attr('href'_this.imgClone( key ) );
            $('<a/>').attr({href: '/?' + key, 'target': '_blank'})
                .append( _this.imgClone( key ) )
                .appendTo( liDom );
            if ( (this.width / this.height) > (liDom.outerWidth() / liDom.outerHeight()) ) {  // 寬圖
                liDom.find('> a > img').css({width: '100%', height: 'auto'}).addClass('hide fade');
            } else {
                liDom.find('> a > img').css({widtu: 'auto', height: '100%'}).addClass('hide fade');
            }
            setTimeout( function () {
                liDom.find(' > .loading-animate').remove();
                liDom.find('> a > img').removeClass('hide');
            }, 300);
            setTimeout( function () {
                liDom.find('> a > img').addClass('in');
            }, 310);
        }
        imgs[ key ].src = data;
    }

    this.imgClone = function ( key ) 
    {
        return [ imgs[ key ] ].slice()[0];
    }

    this.prepend = function ( key, data )
    {
        if ( this.has(key) ) {
            return false;
        }
        $('<li/>').attr('id', key).addClass('fade in').prependTo( imgPanel );
        imgs[ key ] = new Image();
        if ( data ) {
            this.update( key, data );
        }
        return this;
    }
    this.append = function ( key, data ) 
    {
        if ( this.has(key) ) {
            return false;
        }
        $('<li/>').attr('id', key).addClass('fade in').appendTo( imgPanel );
        imgs[ key ] = new Image();
        if ( data ) {
            this.update( key, data );
        }
        return this;
    }


    this.refresh = function ( key )
    {

        if ( typeof key === 'string' ) {
            // imgPanel.find('li#' + key + ' > img').src = imgs[ key ] + 
        } else if ( typeof key === 'object' ) {

        } else {

        }

    }

}

// var imageView = {
//     _KEYS : 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
//     , imgs : {}
//     , randKey : function () {
//         var str = '';

//     }
//     , put : function ( ) 
//     {
//         var key = null, data = null;
//         if ( arguments.length == 1 ) {
//             key = this.getKey();
//             data = arguments[0];
//         } else if ( arguments.length == 2 && this.imgs[ arguments[1] ] ) {
//             key = arguments[0];
//             data = arguments[1];
//         } else {
//             return false;
//         }
//         this.


//     }
//     , load : function ( arr ) 
//     {

//     }
// }