
$(function(){

    $('#login-button').on('click', login );
    $('#login-iframe').on('load', loginError );

    /* 設定 Ajax 動作 */
    ajax_init();

    $('button.back-btn').on('click', function () {
        window.history.back();
    });


});

/* ajax 設定 */
function ajax_init()
{
    $( document ).ajaxSend( function( event, jqXHR, options ) 
        {
            if( ! options.ajaxLock ) return;
            var form = $(event.currentTarget.activeElement.form);
            if (form.hasClass('run-ajax')) {
                options.isCancel = true;
                jqXHR.abort();
            }
            options.activeForm = form;
            form.addClass('run-ajax');
            form.find('[type=submit]').addClass('disabled');
        }
    );
    $( document ).ajaxComplete( function( event, jqXHR, options )
        {
            if( options.isCancel || ! options.ajaxLock ) return ;
            var form = options.activeForm;
            form.removeClass('run-ajax');
            form.find('[type=submit]').removeClass('disabled');

        }
    ); 
}

/* 登入動作 */
function login( ) 
{
    // var postData = $(this).serialize();
    $('#login-message').html([
        $('<img/>').attr('src', '/images/login_loading.gif')
        , '登入中 ... '
    ]);
    $('#login-iframe').attr({
        src: $(this).attr('href')
        , 'status': 'loading'
    });
    $('#login-modal').modal('show')
    return false;;
}

/* 登入失敗 */
function loginError() 
{
    if ( $(this).attr('status') == 'loading' ) {
        $('#login-message').html('登入失敗... 可能是您未登入 Google 帳號 , 或是本系統無您的資料！');
    }
}

/* 登入成功 */
function loginSuccess() 
{
    $('#login-message').html('登入成功');
    $('#login-iframe').attr('status','success');
    setTimeout( "$('#login-modal').modal('hide')" , 1000);
    setTimeout( "location.href = '/'" , 1500);
}

function showMsg( msg, sec ) 
{
    // msg.show( $('#alert-message') );
    $('#alert-modal').modal('hide');
    $('#message-content').html( msg );
    $('#alert-modal').modal('show');

    setTimeout( function() {
        $('#alert-modal').modal('hide');
    }, sec || 1500 );


}

function removeDom( dom , sec )
{
    sec = sec || 500;
    dom = $(dom);
    dom.animate({ opacity: 0}, sec);
    var rmTime = sec + Number(new Date());
    dom.addClass('rm-time-' + rmTime );
    setTimeout( function () { 
        $('.rm-time-' + rmTime ).remove(); 
    }, sec );

}

// var tmp = {};
// tmp.a = 5;
// tmp.b = 10;
// tmp.c = 15;
// // delete tmp.c;
// console.log( Object.keys(tmp).length );