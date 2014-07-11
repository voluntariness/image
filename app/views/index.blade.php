@extends('template')
@section('content')
    <div id="holder">
        <ul id="img-panel">
        </ul>
    </div>
@stop
@section('script')
    <script type="text/javascript">

        $('#holder').on({
            dragstart : function () {
                console.log( window.event );
                return false;
            }
            , dragover : function () {
                $(this).addClass('hover'); return false; 
            }
            , dragend : function () {$(this).removeClass('hover'); return false; }
            , dragleave : function () {$(this).removeClass('hover'); return false; }
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
                        // console.log( event.target );
                        var data = {data : event.target.result , name : this.fileName };
                        // console.log(data);
                        setTimeout( function() {
                            UploadAjax( data );
                        }, 1);
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
            var dom = $('<div/>').addClass('upload-queue')
                .append([
                    $('<img/>').attr('src', data.data)
                    , $('<label/>').html('Upload...')
                ]);

            var queueAlert = (new Alert).show(dom);

            // var key = imgView.getKey();
            // imgView.prepend( key ).setLoading( key );

            $.ajax( '/server.php/upload', { data: data, type: 'post', dataType: 'json' } )
                .done( function ( request ) {
                    if ( request.status ) {
                        dom.find('label').html('Success.');
                        queueAlert.remove(1000);
                        if ( imgView.has( request.key ) ) {
                            imgView.remove( request.key );
                        }
                        imgView.prepend( request.key, request.url )
                        // imgView.changeKey( key, request.key );
                        // imgView.update( request.key, request.url );
                    }
                })
                .fail( function( request ) {
                    queueAlert.content('Success.').remove(2000);
                });
        }
    </script>
@stop