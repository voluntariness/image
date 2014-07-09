@extends('template')
@section('content')
    <div class="col-xs-3">
        <ul id="image-list">
        </ul>
    </div>
    <div class="col-xs-9">
        <!-- <form id="form-save" action="/manage/pages/save" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-xs-4 col-xs-offset-2">
                    <input class="form-control" type="text" placeholder="Search images...">
                </div>
                <div class="col-xs-2">
                    <button class="btn btn-default">Search</button>
                </div>
            </div>
        </form> -->
        <div class="row">
            <div class="col-xs-10">
                <div id="holder"> </div>
            </div>
        </div>
        <div id="upload-queue"> </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">

        function imageRecord() 
        {
            $.ajax( '/server.php/imgs', { type: 'post', dataType: 'json' } )
                .done( function ( request ) {
                    console.log( request.imgs);
                    if ( ! request.status ) {
                        return;
                    }
                    var imgs = request.imgs;
                    for ( var i in imgs ) {

                        var li = $('<li/>').appendTo( $('#image-list') );
                        var url = imgs[i].domain + imgs[i].key;
                        $('<a/>').attr({'href': url , 'target': '_blank'})
                            .html( imgs[i].key )
                            .appendTo(li);
                        $('<img/>').attr('src', url )
                            .appendTo(li);
                    }
                }) ;          
        }
        imageRecord();

        $('#holder').on({
            dragover : function () {$(this).addClass('hover'); return false; }
            , dragend : function () {$(this).removeClass('hover'); return false; }
            ,  dragleave : function () {$(this).removeClass('hover'); return false; }
            , drop : function ( ) 
            {
                $(this).removeClass('hover');
                var e = window.event;
                e.preventDefault();
                var files = e.dataTransfer.files
                    , reader = []
                    , imgResult = [];
                for ( var i=0; i<files.length; i++ ) {
                    var r = new FileReader();
                    r.onload = function (event) 
                    {
                        console.log( event.target );
                        var data = {data : event.target.result , name : this.fileName };
                        UploadAjax( data );
                    }
                    r.fileName = files[i].name;
                    r.readAsDataURL( files[i] );
                    reader.push( r );
                }
                return false;
            }
        });

        function UploadAjax ( data ) 
        {
            var dom = $('<div/>');
            dom.addClass('queue')
                .appendTo( $('#upload-queue') )
                .append([
                    $('<img/>').attr('src', data.data)
                    , $('<label/>').html('Upload...')
                ]);

            setTimeout(function() {dom.addClass('show'); }, 10);

            $.ajax( '/server.php/upload', { data: data, type: 'post', dataType: 'json' } )
                .done( function ( request ) {
                    dom.find('label').html('Success.');
                    setTimeout( function() { dom.removeClass('show'); } , 1000);
                    if ( $('#upload-queue > .queue.show').length == 0 ) {
                        $('#upload-queue > .queue').remove();
                    }
                })
                .fail( function( request ) {
                    dom.find('label').html('Fail.');
                });
        }
    </script>
@stop