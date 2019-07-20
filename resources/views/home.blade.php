<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <title>Laravel</title>

    <!-- Fonts -->
    
    {{-- <link rel="stylesheet" href="/css/sweetalert.css"> --}}
</head>
<body>
    @auth
    <h3>{{auth()->user()->name}}</h3>

    @endauth
{{-- <script src="js/sweetalert.min.js"></script> --}}

    @include('sweet::alert')
</body>
</html>

