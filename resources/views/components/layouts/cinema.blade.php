<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <livewire:cinema.navbar />

    <main>
        <div class="container mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <livewire:cinema.footer />
    @livewireScriptConfig
    <x-toaster-hub />
</body>

</html>
