<section class="space-y-6">
    <header>
        <h2 class="text-sm md:text-base font-semibold text-slate-900 dark:text-slate-50">
            {{ __('Delete account') }}
        </h2>

        <p class="mt-1 text-xs md:text-sm text-slate-500 dark:text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently removed. Download anything you want to keep before proceeding.') }}
        </p>
    </header>

    {{-- Trigger button --}}
    <x-danger-button
        x-data="{}"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-xs md:text-sm font-medium
               bg-gradient-to-r from-rose-500 to-red-600 border-0
               hover:from-rose-600 hover:to-red-700
               focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:ring-offset-1
               focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900"
    >
        ⚠️ {{ __('Delete account') }}
    </x-danger-button>

    {{-- Confirmation modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-50">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-2 text-xs md:text-sm text-slate-500 dark:text-slate-400">
                    {{ __('This action cannot be undone. All of your data and resources will be permanently deleted. Please enter your password to confirm.') }}
                </p>
            </div>

            <div class="pt-2">
                <label
                    for="password"
                    class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1"
                >
                    {{ __('Password') }}
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-rose-400/40 focus:border-rose-400
                           dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                           dark:focus:ring-rose-500/40 dark:focus:border-rose-400"
                    placeholder="{{ __('Enter your password to confirm') }}"
                />

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="mt-2 text-xs text-rose-500"
                />
            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-3 py-1.5 rounded-full border border-slate-300 bg-white/90 text-xs md:text-sm text-slate-700
                           hover:bg-slate-100
                           dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200 dark:hover:bg-slate-800/90"
                >
                    {{ __('Cancel') }}
                </button>

                <x-danger-button
                    class="inline-flex items-center px-4 py-1.5 rounded-full text-xs md:text-sm font-medium
                           bg-gradient-to-r from-rose-500 to-red-600 border-0
                           hover:from-rose-600 hover:to-red-700
                           focus:outline-none focus:ring-2 focus:ring-rose-400/70 focus:ring-offset-1
                           focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900"
                >
                    {{ __('Delete account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
