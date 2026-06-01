<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ServiceBooking') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50">
        <div class="grid min-h-screen lg:grid-cols-[1.1fr_0.9fr]">
            <div class="hidden bg-gradient-to-br from-teal-900 via-teal-700 to-blue-700 px-10 py-12 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-xl font-bold">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15">SB</span>
                        ServiceBooking
                    </a>
                    <div class="mt-16 max-w-xl">
                        <p class="rounded-full border border-white/20 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-teal-100">
                            Online Service Booking Platform
                        </p>
                        <h1 class="mt-6 text-5xl font-extrabold leading-tight">
                            Book Trusted Services Anytime, Anywhere
                        </h1>
                        <p class="mt-6 text-lg text-teal-50/85">
                            A modern SaaS-style portfolio app for service discovery, appointment booking, and business operations.
                        </p>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                        <p class="text-sm text-teal-100">Today</p>
                        <p class="mt-3 text-2xl font-bold">09:00</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                        <p class="text-sm text-teal-100">Tomorrow</p>
                        <p class="mt-3 text-2xl font-bold">13:30</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                        <p class="text-sm text-teal-100">This Week</p>
                        <p class="mt-3 text-2xl font-bold">16:00</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center px-4 py-10 sm:px-6 lg:px-10">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
