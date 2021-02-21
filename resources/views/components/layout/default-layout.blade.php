<!DOCTYPE html>
<html>

<head>
    <x-application.metadata />
    <title>ChatBot{{ isset($pageTitle) ? ' - ' . $pageTitle : '' }}</title>
    <link rel="icon" href="{{ asset('img/icons/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
    @stack('styles')
</head>

<body>
    <main id="appcontainer">
        <img id="bg" src="{{ asset('img/backgrounds/home.png') }}" alt="background" />
        <x-application.navigation />
        <div id="content">
            {{ $slot }}
        </div>
        <x-application.footer />
    </main>
    @stack('scripts')
</body>

</html>
