<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ServiceBooking') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen bg-slate-50">
            <header class="border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="container-app flex h-20 items-center justify-between gap-6">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-lg font-bold text-slate-950">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-teal-700 text-white">SB</span>
                        ServiceBooking
                    </a>
                    <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                        <a href="{{ route('dashboard') }}" class="hover:text-teal-700">Dashboard</a>
                        <a href="{{ route('bookings.index') }}" class="hover:text-teal-700">My Bookings</a>
                        <a href="{{ route('services.index') }}" class="hover:text-teal-700">Services</a>
                    </nav>
                    <div class="flex items-center gap-3">
                        @if(auth()->user()?->hasAnyRole(['admin', 'provider']))
                            <a href="/admin" class="hidden rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 md:inline-flex">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full bg-teal-700 px-4 py-2 text-sm font-semibold text-white">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            <main class="container-app py-8">
                @if(session('status'))
                    <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                        <p class="font-semibold">Please review the highlighted fields.</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
