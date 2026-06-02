<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ServiceBooking') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50">
        <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="container-app flex h-20 items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-lg font-bold text-slate-950">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-700 text-white">SB</span>
                    ServiceBooking
                </a>
                <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-600 lg:flex">
                    <a href="{{ route('home') }}#home" class="hover:text-teal-700">Home</a>
                    <a href="{{ route('services.index') }}" class="hover:text-teal-700">Services</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-teal-700">How It Works</a>
                    <a href="{{ route('home') }}#pricing" class="hover:text-teal-700">Pricing</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-teal-700">Contact</a>
                </nav>
                <div class="hidden items-center gap-3 lg:flex">
                    <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-semibold text-slate-700">Login</a>
                    <a href="{{ route('services.index') }}" class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-teal-700/20">Book a Service</a>
                </div>
                <button @click="open = ! open" class="rounded-2xl border border-slate-200 p-3 lg:hidden">
                    <span class="sr-only">Toggle menu</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 5h14M3 10h14M3 15h14"/></svg>
                </button>
            </div>
            <div x-show="open" x-transition class="border-t border-slate-200 bg-white lg:hidden">
                <div class="container-app flex flex-col gap-3 py-4 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('services.index') }}">Services</a>
                    <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </header>
        <main>{{ $slot }}</main>
        <footer class="border-t border-slate-200 bg-white py-10">
            <div class="container-app flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-lg font-bold text-slate-950">ServiceBooking</p>
                </div>
                <div class="flex flex-wrap gap-4 text-sm text-slate-500">
                    <span>Jakarta, Indonesia</span>
                    <span>hello@servicebooking.test</span>
                    <span>021-555-2026</span>
                </div>
            </div>
        </footer>
    </body>
</html>
