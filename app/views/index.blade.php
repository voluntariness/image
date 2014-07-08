@extends('template')
@include('sidebar')
@section('content')
    <form id="form-save" action="/manage/pages/save" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-xs-3 col-xs-offset-4">
                <input class="form-control" type="text" placeholder="Search images...">
            </div>
            <div class="col-xs-2">
                <button class="btn btn-default">Search</button>
            </div>
        </div>
    </form>
    <div id="holder">
        &nbsp;
    </div>
@stop
@section('script')
    <script type="text/javascript">
        var UploadQueue = {};

        $('#holder').on({
            dragover : function () {$(this).addClass('hover'); return false; }
            , dragend : function () {$(this).removeClass('hover'); return false; }
            ,  dragleave : function () {$(this).removeClass('hover'); return false; }
            , drop : function ( ) 
            {
                // $(this).removeClass('hover');
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
                    r.fileNmae = files[i].name;
                    r.readAsDataURL( files[i] );
                    reader.push( r );
                }
                return false;

            }
        });

        function UploadAjax ( data ) 
        {
            $.ajax( '/upload', { data: data, type: 'post', dataType: 'json' } )
                .done( function ( request ) {
                    console.log(request);
                })
                .fail( function( request ) {
                    console.log(request);
                });
        }
    </script>
@stop