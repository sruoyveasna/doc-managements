<x-guest-layout>
    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 flex items-center justify-center">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative w-full max-w-5xl px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-[1.1fr_minmax(0,1fr)] gap-8 items-center">

                {{-- Left: intro / branding --}}
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white/80 px-3 py-1 text-[0.7rem] tracking-wide uppercase
                                shadow-sm backdrop-blur
                                dark:border-slate-700 dark:bg-slate-900/80">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 via-emerald-400 to-amber-400 text-[11px] font-bold text-white">
                            DL
                        </span>
                        <span class="text-slate-500 dark:text-slate-300">
                            DocLibrary · Secure access
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                        Welcome back to
                        <span class="bg-gradient-to-r from-purple-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            your campus library
                        </span>
                    </h1>

                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 max-w-md">
                        Log in to manage documents, browse the catalog, and collaborate with comments.
                        Guests can still explore published documents on the public page.
                    </p>

                    <div class="flex flex-wrap gap-2 text-[0.75rem] mt-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-200 bg-white/80 text-slate-700
                                     dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            🔐 Role-based access
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-200 bg-white/80 text-slate-700
                                     dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            📁 Manage documents
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-200 bg-white/80 text-slate-700
                                     dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            💬 Comment & review
                        </span>
                    </div>

                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-1 text-xs md:text-sm text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-300">
                        ← Back to public library
                    </a>
                </div>

                {{-- Right: login card --}}
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-6
                            backdrop-blur
                            dark:border-slate-700 dark:bg-slate-900/90 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-50">
                            Sign in to your account
                        </h2>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Use your campus credentials to continue.
                        </p>
                    </div>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                                {{ __('Email') }}
                            </label>
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-500" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-xs font-medium text-slate-700 dark:text-slate-200">
                                    {{ __('Password') }}
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-[11px] text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-300">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>

                            <x-text-input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-500" />
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center justify-between text-xs">
                            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500
                                           dark:border-slate-600 dark:bg-slate-900"
                                    name="remember"
                                >
                                <span class="text-slate-600 dark:text-slate-300">
                                    {{ __('Remember me') }}
                                </span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-full text-sm font-medium
                                       bg-gradient-to-r from-indigo-500 to-emerald-500 text-white
                                       shadow-[0_14px_40px_rgba(56,189,248,0.45)]
                                       hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)]
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/70 focus:ring-offset-1
                                       focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900"
                            >
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>

                    {{-- Optional: small note --}}
                    <p class="mt-4 text-[0.7rem] text-slate-400 dark:text-slate-500">
                        Having trouble logging in? Contact your administrator.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
