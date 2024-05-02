<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Questionnire Page</title>

        <!-- Fonts -->
        <script type="text/javascript" src={{asset("js/ajax-handler.js")}}></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src={{asset("js/jquery-3.7.1.min.js")}}></script>
        <script type="text/javascript" src={{asset("js/scripts.js")}}></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    </head>
    <body class="antialiased">
        @yield('content')
    </body>
</html>
<script type="text/javascript">
    const APP_URL = "{{env("APP_URL")}}";
</script>
