<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="/fonts/FontAwesome/css/fontawesome-all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link href="https://cdn.remixicon.com/releases/v2.1.0/remixicon.css" rel="stylesheet">
</head>
<body>
    <div id="app" data-app="true">
        <index></index>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://cdn.plrjs.com/player/dz34kdb2325ak/305sz0pg3df8.js"></script>
</body>
</html>
