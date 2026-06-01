<x-guest-layout>
    <div class="card-surface p-8">
        <a href="{{ route('home') }}" class="text-sm font-semibold text-teal-700">← Back to home</a>
        <h1 class="mt-6 text-3xl font-bold text-slate-950">Login to ServiceBooking</h1>
        <p class="mt-3 text-sm text-slate-500">Choose your access mode and continue to your dashboard.</p>

        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-700">Access Mode</label>
                <div class="mt-2 grid grid-cols-2 gap-3">
                    <label class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">
                        <input type="radio" name="role" value="customer" class="mr-2" checked> Customer
                    </label>
                    <label class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">
                        <input type="radio" name="role" value="admin" class="mr-2"> Admin
                    </label>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Password</label>
                <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-slate-500">
                    <input type="checkbox" name="remember" class="rounded border-slate-300">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-teal-700">Forgot password?</a>
            </div>
            <button class="w-full rounded-full bg-teal-700 px-5 py-4 text-sm font-semibold text-white">Login</button>
        </form>

        <p class="mt-6 text-sm text-slate-500">Need an account? <a href="{{ route('register') }}" class="font-semibold text-teal-700">Register</a></p>
    </div>
</x-guest-layout>
