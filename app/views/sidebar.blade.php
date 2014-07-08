@section('sidebar')

    <form id="form-save" action="/manage/pages/save" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-xs-8">
                <input class="form-control" type="text" placeholder="Search images...">
            </div>
            <div class="col-xs-3">
                <button class="btn btn-default">Search</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-1 col-xs-offset-1">
                <button type="submit" class="btn btn-primary save-btn" btn-action="save">
                    <span class="glyphicon glyphicon-floppy-disk" ></span>  Save
                </button>
            </div>
            <div class="col-xs-1">
                <button type="button" class="btn btn-default back-btn" >
                    <span class="glyphicon glyphicon-arrow-left" ></span>  Back
                </button>
            </div>
        </div>
    </form>
@stop