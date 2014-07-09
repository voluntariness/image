<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hello</title>
    <link href="/jscss/webside/css/layout.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/jscss/jquery/jquery-1.11.0.min.js"></script>
    <link href="/jscss/bootstrap-3.2.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/jscss/bootstrap-3.2.0-dist/css/docs.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/jscss/bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/jscss/EpicEditor/js/epiceditor.min.js"></script>
    <script type="text/javascript" src="/jscss/webside/js/layouot.js"></script>
    <script type="text/javascript" src="/jscss/webside/js/message.js"></script>

</head>
<body>
    @section('header')
        <header>
        </header>
    @show
    <div id="main" class="well row">
        @yield('content')
    </div>
    @section('footer')
        <footer >
            Copyright &copy; : jcluo All rights reserved.
        </footer>
    @show


    @yield('script')
</body>
</html>