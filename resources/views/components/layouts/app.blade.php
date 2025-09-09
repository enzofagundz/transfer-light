<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="drawer lg:drawer-open h-screen">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <x-layouts.navbar />
            <livewire:shared.alert-manager />

            <main class="flex flex-col space-y-10 px-6 py-14 flex-1">
                {{ $slot }}
            </main>
        </div>

        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                <li>
                    <a href="/" wire:navigate>
                        <x-lucide-users class="w-6 h-6" />
                        Home
                    </a>
                </li>
                <li>
                    <a href="/transfers/create" wire:navigate>
                        <x-lucide-credit-card class="w-6 h-6" />
                        Transfers
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @livewireScripts
</body>

</html>
