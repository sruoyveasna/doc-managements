<x-guest-layout>
    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 flex items-center justify-center">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative w-full max-w-4xl px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-[1.05fr_minmax(0,1fr)] gap-8 items-center">

                {{-- Left: intro --}}
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white/80 px-3 py-1 text-[0.7rem] tracking-wide uppercase
                                shadow-sm backdrop-blur
                                dark:border-slate-700 dark:bg-slate-900/80">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 via-emerald-400 to-amber-400 text-[11px] font-bold text-white">
                            DL
                        </span>
                        <span class="text-slate-500 dark:text-slate-300">
                            DocLibrary · Email verification
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                        Verify your
                        <span class="bg-gradient-to-r from-purple-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            email address
                        </span>
                    </h1>

                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 max-w-md">
                        Thanks for signing up! Please confirm your email by clicking the verification link we just sent you.
                        Once verified, you’ll have full access to your account.
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Didn’t receive anything yet? You can request another verification email on the right.
                    </p>
                </div>

                {{-- Right: card with actions --}}
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-6
                            backdrop-blur
                            dark:border-slate-700 dark:bg-slate-900/90 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)] space-y-4">

                    {{-- Status text --}}
                    <div class="text-sm text-slate-600 dark:text-slate-300">
                        {{ __("Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
                    </div>

                    {{-- Success message --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="rounded-xl border border-emerald-300 bg-emerald-50/90 px-3 py-2 text-xs text-emerald-800
                                    dark:border-emerald-500/70 dark:bg-emerald-500/10 dark:text-emerald-200">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 pt-2 text-sm">
                        {{-- Resend verification form --}}
                        <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                            @csrf

                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-full text-sm font-medium
                                       bg-gradient-to-r from-indigo-500 to-emerald-500 text-white
                                       shadow-[0_14px_40px_rgba(56,189,248,0.45)]
                                       hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)]
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/70 focus:ring-offset-1
                                       focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900"
                            >
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        {{-- Logout form --}}
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf

                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-1 px-4 py-2.5 rounded-full border border-slate-300 bg-white/90 text-slate-700 text-sm
                                       hover:bg-slate-100
                                       focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-1 focus:ring-offset-slate-50
                                       dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95 dark:focus:ring-slate-600 dark:focus:ring-offset-slate-900"
                            >
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>

                    <p class="mt-2 text-[0.7rem] text-slate-400 dark:text-slate-500">
                        Make sure to check your spam or promotions folder if you don’t see the email in your inbox.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
