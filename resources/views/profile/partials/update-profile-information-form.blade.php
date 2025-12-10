<section class="space-y-4">
    <header>
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-50">
            {{ __('Profile information') }}
        </h2>

        <p class="mt-1 text-xs md:text-sm text-slate-500 dark:text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Verification re-send form --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Main profile form --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-3 space-y-4">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                {{ __('Name') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            />
            @error('name')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                {{ __('Email') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            />
            @error('email')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-amber-700 dark:text-amber-300">
                        {{ __('Your email address is unverified.') }}

                        <button
                            form="send-verification"
                            class="underline text-xs font-medium text-indigo-600 hover:text-indigo-800
                                   dark:text-indigo-300 dark:hover:text-indigo-100 focus:outline-none"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-xs font-medium text-emerald-600 dark:text-emerald-300">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-1">
            <button
                type="submit"
                class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500
                       text-white text-xs md:text-sm font-medium shadow-[0_12px_30px_rgba(56,189,248,0.45)]
                       hover:shadow-[0_16px_40px_rgba(56,189,248,0.6)] focus:outline-none focus:ring-2
                       focus:ring-indigo-400/60 focus:ring-offset-1 focus:ring-offset-slate-50
                       dark:focus:ring-offset-slate-900"
            >
                {{ __('Save changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-slate-500 dark:text-slate-400"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
