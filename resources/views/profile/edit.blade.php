@extends('layouts.user')

@section('content')
    <div class="space-y-6">
        @if (session('status') === 'profile-updated')
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                Profile updated successfully.
            </div>
        @endif

        <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-900 px-6 py-8 text-white shadow-xl sm:px-8">
            <div class="absolute -right-12 top-0 h-40 w-40 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-36 w-36 rounded-full bg-orange-400/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21a8 8 0 1 0-16 0"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>

                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-300">Account Center</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Edit Profile</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                        Update your personal information here. Leave the password fields empty if you do not want to change your password.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur sm:min-w-[260px]">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-300">Signed In As</p>
                    <p class="mt-3 text-2xl font-bold">{{ $user->username ?: $user->name }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $user->email }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
                <h2 class="text-2xl font-semibold text-slate-900">Profile Details</h2>
                <p class="mt-1 text-sm text-slate-500">Edit your account information and save everything in one form.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="px-6 py-6 sm:px-8 sm:py-8">
                @csrf
                @method('PATCH')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-700">Username</label>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username', $user->username) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            required
                        >
                        @error('username')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                        <input
                            id="full_name"
                            name="full_name"
                            type="text"
                            value="{{ old('full_name', $user->full_name) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            required
                        >
                        @error('full_name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_no" class="block text-sm font-semibold text-slate-700">Contact No</label>
                        <input
                            id="contact_no"
                            name="contact_no"
                            type="text"
                            value="{{ old('contact_no', $user->contact_no) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            required
                        >
                        @error('contact_no')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ic_passport" class="block text-sm font-semibold text-slate-700">IC / Passport</label>
                        <input
                            id="ic_passport"
                            name="ic_passport"
                            type="text"
                            value="{{ old('ic_passport', $user->ic_passport) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            required
                        >
                        @error('ic_passport')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500">
                        Password is optional here.
                        <p class="mt-1">Fill in both password fields only when you want to change your login password.</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            autocomplete="new-password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500">Make sure your email is active so system notifications still reach you.</p>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
