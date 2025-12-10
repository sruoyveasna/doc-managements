<section class="space-y-4">
    <header>
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-50">
            {{ __('Update password') }}
        </h2>

        <p class="mt-1 text-xs md:text-sm text-slate-500 dark:text-slate-400">
            {{ __('Use a long, unique password to keep your account secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-3 space-y-4">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <label for="update_password_current_password"
                   class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                {{ __('Current password') }}
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
            />
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-1 text-xs text-rose-500">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        {{-- New password --}}
        <div>
            <label for="update_password_password"
                   class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                {{ __('New password') }}
            </label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
            />
            @if($errors->updatePassword->has('password'))
                <p class="mt-1 text-xs text-rose-500">
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="update_password_password_confirmation"
                   class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                {{ __('Confirm password') }}
            </label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
            />
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="mt-1 text-xs text-rose-500">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
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
                {{ __('Save new password') }}
            </button>

            @if (session('status') === 'password-updated')
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
