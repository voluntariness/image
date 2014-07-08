var Message = function( )
{
    var that = this
        , type = 'default'
        , second = 0
        , content = ''
        , StyleCss = {
            background : {
                    background : '#fff'
                    , border: '1px solid #ddd'
                    , 'border-radius': '3px'
                    , opacity : 0
                    , color: '#333'
                }
            , content : {
                padding: '0 10px'
                , 'line-height' : '34px'
                , 'border-radius': '3px'
                , 'font-size' : '15px'
                , 'font-weight' : 'bold'
                , 'font-family': 'Microsoft JhengHei'
            }
            , close : {
                padding: '8px 15px'
                , float : 'right'
                , color : '#aaa'
                , cursor: 'pointer'
                , 'font-size' : '15px'
                , 'font-family': 'Arial Black'
                , 'font-weight' : 'bold'
            }
            , type : {
                    'default' : {
                        background : '#FEFEFE'
                        , border: '1px solid #DDD'
                        , color: '#555'
                    }
                    , danger : {
                        background : '#F2DEDE'
                        , border: '1px solid #EBCCD1'
                        , color: '#F50000'
                    }
                    , warning : {
                        background : '#F1E0C8'
                        , border: '1px solid #F7C989'
                        , color: '#EE8600'
                    }
                    , success : {
                        background : '#D9F3D9'
                        , border: '1px solid #B7E7B7'
                        , color: '#1B971B'
                    }
                    , info : {
                        background : '#D4EBF1'
                        , border: '1px solid #ACD7E4'
                        , color: '#33F'
                    }
                }
        };
    this.domBackGround = null;
    this.msg        = function( t, msg, sec ) { content = msg; second = Number(sec) || 0; type = t;     return this; }
    this.danger     = function( msg, sec ) { content = msg; second = Number(sec) || 0; type = 'danger';     return this; }
    this.warning    = function( msg, sec ) { content = msg; second = Number(sec) || 0; type = 'warning';    return this; }
    this.success    = function( msg, sec ) { content = msg; second = Number(sec) || 0; type = 'success';    return this; }
    this.info       = function( msg, sec ) { content = msg; second = Number(sec) || 0; type = 'info';       return this; }

    this.show = function(dom, position){
        this.domBackGround = jQuery('<div/>')
                                    .addClass('message-label')
                                    .css( StyleCss.background )
                                    .css( StyleCss.type[type] );
        jQuery('<span/>').css( StyleCss.close )
                        .addClass('message-close')
                        .html('X')
                        .click(function(){ 
                            that.domBackGround.animate({opacity:0},250,function(){jQuery(this).remove();});
                        })
                        .hover(function(){ jQuery(this).css({color:'#555'}); }
                                , function(){ jQuery(this).css({color:'#aaa'}); })
                        .appendTo( this.domBackGround );
                        
        jQuery('<div/>').css( StyleCss.content )
                        .html( content )
                        .appendTo( this.domBackGround );
        dom = dom || jQuery('body');
        position = position || 'prepend';
        eval( 'jQuery(dom).' + position + '(this.domBackGround);');
        this.domBackGround.animate({opacity:1},200);
        if( second > 0 )
            setTimeout(function(){ that.hide(); }, second + 200 );
        return this;
    }
    this.hide = function(){ this.domBackGround.find(' > .message-close').click(); }
    this.hideAll = function(){ jQuery('.message-label > .message-close').click(); }
    return this;
}
