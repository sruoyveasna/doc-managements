<x-app-layout>
    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative max-w-3xl mx-auto px-4 py-6 space-y-5">

            {{-- Header --}}
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        Genres
                    </p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight">
                        Edit genre
                        <span class="bg-gradient-to-r from-indigo-500 via-emerald-500 to-sky-500 bg-clip-text text-transparent">
                            "{{ $genre->name }}"
                        </span>
                    </h1>
                    <p class="mt-1 text-xs md:text-sm text-slate-600 dark:text-slate-300">
                        Updating this name will affect documents that use this genre.
                    </p>
                </div>

                <a href="{{ route('genres.index') }}"
                   class="text-xs md:text-sm inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-white/90 text-slate-600 hover:bg-slate-100
                          dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200 dark:hover:bg-slate-800/90">
                    ← Back to list
                </a>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="rounded-2xl border border-rose-300 bg-rose-50/90 px-3.5 py-3 text-sm text-rose-800 shadow-sm
                            dark:bg-rose-950/40 dark:border-rose-500/60 dark:text-rose-100">
                    <div class="font-semibold mb-1">Please fix the following:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form card --}}
            <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-5
                        dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">

                <form method="POST" action="{{ route('genres.update', $genre) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                            Genre name <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $genre->name) }}"
                            class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                   dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                   dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                        >
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 text-white text-sm shadow-[0_12px_30px_rgba(56,189,248,0.45)] hover:shadow-[0_16px_40px_rgba(56,189,248,0.6)]"
                        >
                            Update genre
                        </button>

                        <a href="{{ route('genres.index') }}"
                           class="text-xs md:text-sm inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-white/90 text-slate-600 hover:bg-slate-100
                                  dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200 dark:hover:bg-slate-800/90">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
