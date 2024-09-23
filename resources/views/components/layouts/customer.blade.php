<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.layouts.favicon')

    <title>{{ $title ?? 'Page Title' }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <livewire:customer.navbar />

    <main>
        <div class="container mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <livewire:customer.footer />
    @livewireScriptConfig
    <x-toaster-hub />
</body>

</html>
