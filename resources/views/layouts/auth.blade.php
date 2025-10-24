<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>@yield('titulo')</title>
</head>
<body>
    @include('alertas.alerts')
    @yield('contenido')
    @include('alertas.alerts')
</body>
</html>
