<!DOCTYPE html>
<html>

<head>
    <x-application.metadata />
    <title>ChatBot{{ isset($pageTitle) ? ' - ' . $pageTitle : '' }}</title>
    <link rel="icon" href="{{ asset('img/icons/favicon.png') }}" />
    @stack('styles')
</head>

<body>
    <img src="{{ asset('img/backgrounds/home.png') }}" alt="background" />
    <x-application.navigation />
    <h1>{{ $pageHeader ?? 'Hola' }}</h1>
    {{ $slot }}
    <x-application.footer />
    @stack('scripts')
</body>

</html>
