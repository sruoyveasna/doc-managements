<x-app-layout>
    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-6 space-y-6">

            {{-- HEADER --}}
            <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        Catalog
                    </p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight">
                        Manage
                        <span class="bg-gradient-to-r from-indigo-500 via-emerald-500 to-sky-500 bg-clip-text text-transparent">
                            fields
                        </span>
                    </h1>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300 max-w-xl">
                        Add or update fields such as &quot;Computer Science&quot;, &quot;Mathematics&quot;, etc. These are used when tagging documents.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('fields.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs md:text-sm border border-transparent bg-gradient-to-r from-indigo-500 to-emerald-500 text-white shadow-[0_14px_40px_rgba(56,189,248,0.45)] hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)]">
                        <span>＋</span>
                        <span>New field</span>
                    </a>
                </div>
            </section>

            {{-- FLASH MESSAGES --}}
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-300 bg-emerald-50/90 px-3.5 py-3 text-sm text-emerald-800
                            dark:bg-emerald-950/40 dark:border-emerald-500/60 dark:text-emerald-100">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-2xl border border-rose-300 bg-rose-50/90 px-3.5 py-3 text-sm text-rose-800
                            dark:bg-rose-950/40 dark:border-rose-500/60 dark:text-rose-100">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FILTERS --}}
            <section class="mt-1 mb-2 flex flex-wrap gap-3 items-center text-xs md:text-sm">
                <form method="GET" action="{{ route('fields.index') }}" class="flex flex-1 flex-wrap gap-3 items-center">

                    <div class="flex-1 min-w-[220px] flex items-center gap-2 rounded-full border border-slate-300 bg-white text-slate-800 px-3 py-2
                                dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-100">
                        <span>🔍</span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search fields by name or description..."
                            class="bg-transparent border-0 outline-none text-xs md:text-sm text-slate-800 placeholder:text-slate-400 w-full dark:text-slate-100 dark:placeholder:text-slate-500"
                        >
                    </div>

                    <button
                        type="submit"
                        class="rounded-full border border-slate-300 bg-white/95 px-3 py-1.5 text-slate-800 text-[0.75rem] hover:bg-slate-100 hover:border-indigo-300
                               dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95 dark:hover:border-indigo-400"
                    >
                        Apply
                    </button>
                </form>
            </section>

            {{-- TABLE CARD --}}
            <section>
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)]
                            dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">

                    <div class="flex items-baseline justify-between gap-2 px-4 pt-4 pb-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                                All fields
                            </div>
                            <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                                These fields are available when creating or editing documents.
                            </div>
                        </div>
                        <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                            {{ $fields->total() }} total
                        </div>
                    </div>

                    <div class="border-t border-slate-200 dark:border-slate-700/70">
                        <div class="max-h-[460px] overflow-y-auto custom-scroll">
                            <table class="w-full text-xs md:text-sm">
                                <thead class="bg-slate-50/90 dark:bg-slate-950/80 sticky top-0 z-10 border-b border-slate-200 dark:border-slate-800">
                                <tr class="text-[0.7rem] uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    <th class="text-left px-4 py-2">Name</th>
                                    <th class="text-left px-4 py-2">Description</th>
                                    <th class="text-left px-4 py-2">Documents</th>
                                    <th class="text-right px-4 py-2">Actions</th>
                                </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                @forelse($fields as $field)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-950/70 transition">
                                        <td class="px-4 py-3 align-top">
                                            <div class="font-medium text-slate-900 dark:text-slate-50">
                                                {{ $field->name }}
                                            </div>
                                            <div class="text-[0.7rem] text-slate-500 dark:text-slate-400">
                                                ID #{{ $field->id }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 align-top text-[0.78rem] text-slate-700 dark:text-slate-200 max-w-sm">
                                            {{ $field->description ?: '—' }}
                                        </td>

                                        <td class="px-4 py-3 align-top text-[0.78rem] text-slate-700 dark:text-slate-200">
                                            {{ $field->documents_count ?? 0 }}
                                        </td>

                                        <td class="px-4 py-3 align-top text-[0.75rem] text-right">
                                            <div class="flex flex-wrap justify-end gap-1">
                                                <a href="{{ route('fields.edit', $field) }}"
                                                   class="inline-flex items-center px-2 py-1 rounded-full border border-slate-300 bg-slate-50 text-slate-700 hover:bg-slate-100
                                                          dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('fields.destroy', $field) }}"
                                                      onsubmit="return confirm('Delete this field?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 rounded-full bg-rose-500 text-white hover:bg-rose-600 text-[0.75rem]">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                            No fields yet.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700/70">
                        {{ $fields->withQueryString()->links() }}
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>

{{-- Optional: hide scrollbar but keep scrolling --}}
<style>
    .custom-scroll::-webkit-scrollbar {
        width: 0;
        height: 0;
    }
    .custom-scroll {
        -ms-overflow-style: none;  /* IE/Edge */
        scrollbar-width: none;     /* Firefox */
    }
</style>
