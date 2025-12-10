<x-guest-layout>
    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 flex items-center justify-center">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative w-full max-w-4xl px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-[1.05fr_minmax(0,1fr)] gap-8 items-center">

                {{-- Left: copy / intro --}}
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white/80 px-3 py-1 text-[0.7rem] tracking-wide uppercase
                                shadow-sm backdrop-blur
                                dark:border-slate-700 dark:bg-slate-900/80">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 via-emerald-400 to-amber-400 text-[11px] font-bold text-white">
                            DL
                        </span>
                        <span class="text-slate-500 dark:text-slate-300">
                            DocLibrary · Reset password
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                        Set a
                        <span class="bg-gradient-to-r from-purple-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            new password
                        </span>
                    </h1>

                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 max-w-md">
                        You requested a password reset. Choose a strong new password, confirm it, and you’ll be able to log in again.
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        If you didn’t request this reset, you can ignore this page.
                    </p>
                </div>

                {{-- Right: reset form --}}
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-6
                            backdrop-blur
                            dark:border-slate-700 dark:bg-slate-900/90 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                        @csrf

                        {{-- Password Reset Token --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                                {{ __('Email') }}
                            </label>
                            <x-text-input
                                id="email"
                                class="block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                type="email"
                                name="email"
                                :value="old('email', $request->email)"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-500" />
                        </div>

                        {{-- New password --}}
                        <div>
                            <label for="password" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                                {{ __('New Password') }}
                            </label>
                            <x-text-input
                                id="password"
                                class="block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-500" />
                        </div>

                        {{-- Confirm password --}}
                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                                {{ __('Confirm Password') }}
                            </label>
                            <x-text-input
                                id="password_confirmation"
                                class="block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-rose-500" />
                        </div>

                        <div class="flex items-center justify-between pt-2 text-xs">
                            <a href="{{ route('login') }}"
                               class="text-slate-500 hover:text-slate-700 underline underline-offset-2 dark:text-slate-400 dark:hover:text-slate-200">
                                Back to login
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-full text-sm font-medium
                                       bg-gradient-to-r from-indigo-500 to-emerald-500 text-white
                                       shadow-[0_14px_40px_rgba(56,189,248,0.45)]
                                       hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)]
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/70 focus:ring-offset-1
                                       focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900"
                            >
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>

                    <p class="mt-4 text-[0.7rem] text-slate-400 dark:text-slate-500">
                        Tip: Use at least 8 characters with a mix of letters, numbers, and symbols for better security.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
