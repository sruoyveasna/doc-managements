<x-app-layout>
    @php
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // For this dashboard: everyone sees only published docs
        $baseQuery = \App\Models\Document::query()
            ->where('status', 'published');

        $totalDocuments = (clone $baseQuery)->count();
        $publishedCount = $totalDocuments; // same, since we only count published

        // Listing query (search + filters) – published only
        $docsQuery = \App\Models\Document::with(['field', 'genre', 'uploader']) // <- added uploader
            ->where('status', 'published');

        if ($search = request('q')) {
            $docsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhereHas('field', fn ($f) => $f->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('genre', fn ($g) => $g->where('name', 'like', "%{$search}%"));
            });
        }

        if ($fieldId = request('field_id')) {
            $docsQuery->where('field_id', $fieldId);
        }

        if ($genreId = request('genre_id')) {
            $docsQuery->where('genre_id', $genreId);
        }

        $documents = $docsQuery->orderByDesc('updated_at')->paginate(10)->withQueryString();

        $fields = \App\Models\Field::orderBy('name')->get();
        $genres = \App\Models\Genre::orderBy('name')->get();
    @endphp

    {{-- Invisible scrollbar helper --}}
    <style>
        .scroll-invisible {
            scrollbar-width: none;        /* Firefox */
            -ms-overflow-style: none;     /* IE/Edge */
        }
        .scroll-invisible::-webkit-scrollbar {
            width: 0;
            height: 0;
        }
    </style>

    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative max-w-6xl mx-auto px-4 py-6 space-y-6">

            {{-- HEADER / HERO --}}
            <section class="grid grid-cols-1 gap-4 items-start">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        Welcome back
                    </p>
                    <h1 class="mt-1 text-2xl md:text-3xl font-extrabold tracking-tight">
                        Hi, {{ $user->name }} —
                        <span class="bg-gradient-to-r from-purple-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            your library is ready.
                        </span>
                    </h1>
                    <p class="mt-2 text-sm md:text-base text-slate-600 dark:text-slate-300 max-w-xl">
                        Browse published documents, download files you’re allowed to, and open details to leave comments.
                    </p>
                </div>

                {{-- Quick stats (same for all roles) --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    {{-- Total visible (published only) --}}
                    <div class="rounded-2xl border border-slate-200 bg-white/90 p-3 shadow-sm
                                dark:border-slate-700 dark:bg-slate-900/80 dark:shadow-[0_18px_40px_rgba(15,23,42,0.7)]">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Total documents
                            </span>
                            <span class="text-lg">📚</span>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-50">
                            {{ $totalDocuments }}
                        </div>
                        <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                            Published documents available to you
                        </p>
                    </div>

                    {{-- Published (same number, but more explicit) --}}
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 p-3 shadow-sm
                                dark:border-emerald-500/50 dark:bg-emerald-500/10">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] uppercase tracking-wide text-emerald-700 dark:text-emerald-200">
                                Published
                            </span>
                            <span class="text-lg">✅</span>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-emerald-800 dark:text-emerald-200">
                            {{ $publishedCount }}
                        </div>
                        <p class="mt-1 text-[11px] text-emerald-700/80 dark:text-emerald-200/80">
                            Also visible on the public portal
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-3 shadow-sm
                                dark:border-slate-700 dark:bg-slate-900/80">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] uppercase tracking-wide text-slate-600 dark:text-slate-300">
                                Comments
                            </span>
                            <span class="text-lg">💬</span>
                        </div>
                        <p class="mt-3 text-[11px] text-slate-500 dark:text-slate-400">
                            Open a document to read and write comments.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-3 shadow-sm
                                dark:border-slate-700 dark:bg-slate-900/80">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] uppercase tracking-wide text-slate-600 dark:text-slate-300">
                                Downloads
                            </span>
                            <span class="text-lg">⬇️</span>
                        </div>
                        <p class="mt-3 text-[11px] text-slate-500 dark:text-slate-400">
                            Download is allowed based on your role.
                        </p>
                    </div>
                </div>
            </section>

            {{-- SEARCH / FILTERS --}}
            <section class="mt-2 mb-2 flex flex-wrap gap-3 items-center text-xs md:text-sm">
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-1 flex-wrap gap-3 items-center">
                    {{-- search --}}
                    <div class="flex-1 min-w-[220px] flex items-center gap-2 rounded-full border border-slate-300 bg-white text-slate-800 px-3 py-2
                                dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-100">
                        <span>🔍</span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search by title, author, field..."
                            class="bg-transparent border-0 outline-none text-xs md:text-sm text-slate-800 placeholder:text-slate-400 w-full dark:text-slate-100 dark:placeholder:text-slate-500"
                        >
                    </div>

                    {{-- filters (field + type only, no status) --}}
                    <div class="flex flex-wrap gap-2 text-[0.75rem]">
                        {{-- Field select --}}
                        <div class="relative">
                            <select
                                name="field_id"
                                class="block w-full rounded-full border border-slate-300 bg-white/90 px-3 pr-9 py-1.5 text-[0.75rem] text-slate-800 shadow-sm
                                    appearance-none
                                    focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                    dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:shadow-none
                                    dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            >
                                <option value="">All fields</option>
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}" @selected(request('field_id') == $field->id)>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.65rem] text-slate-400"
                            >
                                ▾
                            </span>
                        </div>

                        {{-- Genre select --}}
                        <div class="relative">
                            <select
                                name="genre_id"
                                class="block w-full rounded-full border border-slate-300 bg-white/90 px-3 pr-9 py-1.5 text-[0.75rem] text-slate-800 shadow-sm
                                    appearance-none
                                    focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                    dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:shadow-none
                                    dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            >
                                <option value="">All types</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" @selected(request('genre_id') == $genre->id)>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.65rem] text-slate-400"
                            >
                                ▾
                            </span>
                        </div>

                        {{-- Apply button --}}
                        <button
                            type="submit"
                            class="rounded-full border border-slate-300 bg-white/95 px-3 py-1.5 text-slate-800 text-[0.75rem] hover:bg-slate-100 hover:border-indigo-300
                                dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95 dark:hover:border-indigo-400"
                        >
                            Apply
                        </button>
                    </div>

                </form>
            </section>

            {{-- DOCUMENTS LIST --}}
            <section class="mt-2">
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-4
                            dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                    <div class="flex items-baseline justify-between gap-2 mb-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                                Published documents
                            </div>
                            <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                                Open a document to see details, download, and leave comments.
                            </div>
                        </div>
                        <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                            {{ $documents->total() }} results
                        </div>
                    </div>

                    {{-- invisible scroll bar here --}}
                    <div class="max-h-[420px] overflow-y-auto pr-1 space-y-1.5 scroll-invisible">
                        @forelse($documents as $document)
                            @php
                                $status = $document->status; // will be "published"
                                $badgeClass = 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-200 dark:border-emerald-400/70';
                            @endphp

                            <div class="flex justify-between gap-3 px-3 py-3 rounded-[14px] border border-transparent cursor-pointer transition
                                        hover:bg-slate-50 hover:border-indigo-300/70
                                        dark:hover:bg-slate-950/90 dark:hover:border-indigo-400/70">
                                {{-- left: info --}}
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm font-semibold truncate text-slate-900 dark:text-slate-100">
                                            <a href="{{ route('documents.show', $document) }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">
                                                {{ $document->title }}
                                            </a>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full border text-[0.65rem] capitalize {{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </div>

                                    <div class="mt-0.5 text-[0.78rem] text-slate-500 dark:text-slate-400">
                                        {{ $document->author_name ?? 'Unknown author' }}
                                        @if($document->publication_year)
                                            • {{ $document->publication_year }}
                                        @endif
                                        @if(optional($document->field)->name)
                                            • {{ optional($document->field)->name }}
                                        @endif
                                        @if(optional($document->genre)->name)
                                            • {{ optional($document->genre)->name }}
                                        @endif
                                        @if(optional($document->uploader)->name)
                                            • <span class="italic">Published by {{ $document->uploader->name }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-1 flex flex-wrap gap-1.5">
                                        @if(optional($document->field)->name)
                                            <span class="text-[0.7rem] px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200
                                                        dark:bg-indigo-600/60 dark:text-indigo-50 dark:border-indigo-300/80">
                                                {{ $document->field->name }}
                                            </span>
                                        @endif
                                        @if(optional($document->genre)->name)
                                            <span class="text-[0.7rem] px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200
                                                        dark:bg-slate-900 dark:text-slate-200 dark:border-slate-600">
                                                {{ $document->genre->name }}
                                            </span>
                                        @endif
                                        @if($document->keywords)
                                            <span class="text-[0.7rem] px-2 py-0.5 rounded-full bg-slate-50 text-slate-700 border border-slate-200 max-w-[220px] truncate
                                                        dark:bg-slate-900 dark:text-slate-200 dark:border-slate-600">
                                                Keywords: {{ $document->keywords }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- right: actions --}}
                                <div class="self-end flex flex-col items-end gap-1 text-[0.75rem] whitespace-nowrap">
                                    <div class="flex gap-1">
                                        <a href="{{ route('documents.show', $document) }}"
                                           class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-slate-300 bg-white text-slate-800 hover:bg-slate-100
                                                  dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95">
                                            View & comment
                                        </a>

                                        @can('download-documents')
                                            <a href="{{ route('documents.download', $document) }}"
                                               class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-transparent bg-gradient-to-r from-indigo-500 to-emerald-500 text-white text-[0.75rem]">
                                                Download
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-slate-300 bg-slate-50 text-slate-400 cursor-not-allowed
                                                         dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-500">
                                                No download
                                            </span>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                No documents match your filters yet.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        {{ $documents->links() }}
                    </div>
                </div>
            </section>

            <footer class="pb-6 text-center text-[0.75rem] text-slate-400 dark:text-slate-500">
                Dashboard · {{ now()->year }}
            </footer>

        </div>
    </div>
</x-app-layout>
