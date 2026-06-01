<x-guest-layout>
    <div class="card-surface p-8">
        <a href="{{ route('home') }}" class="text-sm font-semibold text-teal-700">← Back to home</a>
        <h1 class="mt-6 text-3xl font-bold text-slate-950">Create your account</h1>
        <p class="mt-3 text-sm text-slate-500">Register as a customer to start managing your bookings.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-700">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required autofocus>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Phone number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Password</label>
                <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Confirm password</label>
                <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
            </div>
            <button class="w-full rounded-full bg-teal-700 px-5 py-4 text-sm font-semibold text-white">Register</button>
        </form>

        <p class="mt-6 text-sm text-slate-500">Already registered? <a href="{{ route('login') }}" class="font-semibold text-teal-700">Login</a></p>
    </div>
</x-guest-layout>
