<x-guest-layout>
    <div class="card-surface p-8">
        <h1 class="text-3xl font-bold text-slate-950">Forgot password</h1>
        <p class="mt-3 text-sm text-slate-500">Enter your email and we will send a password reset link.</p>
        <x-auth-session-status class="mt-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <button class="w-full rounded-full bg-teal-700 px-5 py-4 text-sm font-semibold text-white">Email Password Reset Link</button>
        </form>
    </div>
</x-guest-layout>
