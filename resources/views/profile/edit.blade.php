<x-app-layout>
    @php
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
    @endphp

    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-72 h-72 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative max-w-5xl mx-auto px-4 py-6 space-y-6">

            {{-- HEADER --}}
            <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        Account
                    </p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight">
                        Your
                        <span class="bg-gradient-to-r from-indigo-500 via-emerald-500 to-sky-500 bg-clip-text text-transparent">
                            profile
                        </span>
                    </h1>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300 max-w-xl">
                        Manage your personal information, update your password, and control your account settings.
                    </p>
                </div>

                <div class="text-right text-xs md:text-sm">
                    @if($user)
                        <div class="inline-flex flex-col items-end px-3 py-2 rounded-2xl border border-slate-200 bg-white/90 shadow-sm
                                    dark:border-slate-700 dark:bg-slate-900/80">
                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                {{ $user->name }}
                            </span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400">
                                Role:
                                <span class="capitalize">{{ $user->role }}</span>
                            </span>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500">
                                {{ $user->email }}
                            </span>
                        </div>
                    @endif
                </div>
            </section>

            {{-- CONTENT GRID --}}
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">

                {{-- LEFT COLUMN: profile info + password --}}
                <div class="space-y-4">

                    {{-- Update profile information --}}
                    <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.25)] p-5
                                dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                        <div class="mb-3">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                                Profile information
                            </h2>
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                Update your name and email address.
                            </p>
                        </div>

                        <div class="border-t border-slate-200/80 dark:border-slate-700/80 pt-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Update password --}}
                    <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.25)] p-5
                                dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                        <div class="mb-3">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                                Update password
                            </h2>
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                Choose a strong password to keep your account secure.
                            </p>
                        </div>

                        <div class="border-t border-slate-200/80 dark:border-slate-700/80 pt-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: delete account --}}
                <div class="space-y-4">

                    <div class="rounded-[18px] border border-rose-200 bg-rose-50/95 shadow-[0_18px_40px_rgba(248,113,113,0.25)] p-5
                                dark:border-rose-500/70 dark:bg-rose-950/60 dark:shadow-[0_22px_50px_rgba(127,29,29,0.85)]">
                        <div class="mb-3">
                            <h2 class="text-sm font-semibold text-rose-800 dark:text-rose-100">
                                Delete account
                            </h2>
                            <p class="mt-0.5 text-xs text-rose-700/90 dark:text-rose-200/80">
                                Once your account is deleted, all of its data will be permanently removed. Please proceed with caution.
                            </p>
                        </div>

                        <div class="border-t border-rose-200/80 dark:border-rose-500/60 pt-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>

            </section>

            <footer class="pb-4 pt-2 text-center text-[0.75rem] text-slate-400 dark:text-slate-500">
                Profile settings · {{ now()->year }}
            </footer>
        </div>
    </div>
</x-app-layout>
