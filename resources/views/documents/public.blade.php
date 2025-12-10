<x-guest-layout>
    {{-- invisible scrollbar helper just for this page --}}
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

        <div class="relative max-w-6xl mx-auto px-4 py-6">

            {{-- HERO --}}
            <section class="grid grid-cols-1 gap-6 items-center pt-2 pb-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                        Your
                        <span class="bg-gradient-to-r from-purple-500 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            campus library
                        </span>, but actually searchable.
                    </h1>
                    <p class="mt-3 text-sm md:text-base text-slate-600 dark:text-slate-300 max-w-xl">
                        Explore books, newspapers, and research projects in a single place.
                        Guests can browse published documents without any login.
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2 text-[0.75rem]">
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-300 bg-white/90 text-slate-700 dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            <span>⚡</span> Instant search by title, author, field
                        </div>
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-300 bg-white/90 text-slate-700 dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            <span>📚</span> Books · Newspapers · Projects
                        </div>
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-slate-300 bg-white/90 text-slate-700 dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200">
                            <span>🌐</span> Public read-only access
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <a href="#documents"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs md:text-sm border border-transparent bg-gradient-to-r from-indigo-500 to-emerald-500 text-white shadow-[0_14px_40px_rgba(56,189,248,0.45)] hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)]">
                            Start browsing
                        </a>
                        <span class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                            Public page shows only <span class="text-emerald-600 dark:text-emerald-400">published</span> documents.
                        </span>
                    </div>
                </div>
            </section>

            {{-- SEARCH / FILTERS --}}
            <section class="mt-2 mb-4 flex flex-wrap gap-3 items-center text-xs md:text-sm">
                <form method="GET" action="{{ route('home') }}" class="flex flex-1 flex-wrap gap-3 items-center">
                    {{-- search --}}
                    <div class="flex-1 min-w-[220px] flex items-center gap-2 rounded-full border border-slate-300 bg-white text-slate-800 px-3 py-2
                                dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-100">
                        <span>🔍</span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search documents by title, author, field..."
                            class="bg-transparent border-0 outline-none text-xs md:text-sm text-slate-800 placeholder:text-slate-400 w-full dark:text-slate-100 dark:placeholder:text-slate-500"
                        >
                    </div>

                    {{-- filters --}}
                    <div class="flex flex-wrap gap-2 text-[0.75rem]">
                        <div class="relative">
                            <select
                                name="field_id"
                                class="appearance-none rounded-full border border-slate-300 bg-white px-3 pr-7 py-1.5 text-[0.75rem] text-slate-800
                                       dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100"
                            >
                                <option value="">All fields</option>
                                @isset($fields)
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}" @selected(request('field_id') == $field->id)>
                                            {{ $field->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[0.6rem] text-slate-400">▾</span>
                        </div>

                        <div class="relative">
                            <select
                                name="genre_id"
                                class="appearance-none rounded-full border border-slate-300 bg-white px-3 pr-7 py-1.5 text-[0.75rem] text-slate-800
                                       dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100"
                            >
                                <option value="">All types</option>
                                @isset($genres)
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" @selected(request('genre_id') == $genre->id)>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[0.6rem] text-slate-400">▾</span>
                        </div>

                        <button
                            type="submit"
                            class="rounded-full border border-slate-300 bg-white px-3 py-1.5 text-slate-800 hover:bg-slate-100
                                   dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95">
                            Apply
                        </button>
                    </div>
                </form>
            </section>

            {{-- DOCUMENTS LIST --}}
            <section id="documents" class="mt-2">
                <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)] p-4
                            dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                    <div class="flex items-baseline justify-between gap-2 mb-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-900 dark:text-slate-50">Documents</div>
                            <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                                Public view of your document library (published only).
                            </div>
                        </div>
                        <div class="text-[0.75rem] text-slate-500 dark:text-slate-400">
                            {{ $documents->total() }} results
                        </div>
                    </div>

                    <div class="max-h-[420px] overflow-y-auto pr-1 space-y-1.5 scroll-invisible">
                        @forelse($documents as $document)
                            <div class="flex justify-between gap-3 px-3 py-3 rounded-[14px] border border-transparent cursor-pointer transition
                                        hover:bg-slate-50 hover:border-indigo-300/70
                                        dark:hover:bg-slate-950/90 dark:hover:border-indigo-400/70">
                                {{-- left: info --}}
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold truncate text-slate-900 dark:text-slate-100">
                                        <a href="{{ route('documents.show', $document) }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">
                                            {{ $document->title }}
                                        </a>
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
                                <div class="self-end flex items-center gap-2 text-[0.75rem] whitespace-nowrap">
                                    <a href="{{ route('documents.show', $document) }}"
                                       class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-slate-300 bg-white text-slate-800 hover:bg-slate-100
                                              dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95">
                                        View details
                                    </a>

                                    @auth
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
                                    @else
                                        <a href="{{ route('login') }}"
                                           class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-indigo-300 bg-white text-indigo-600 text-[0.75rem] hover:bg-indigo-50
                                                  dark:border-indigo-400 dark:bg-slate-900/95 dark:text-indigo-200 dark:hover:bg-slate-800/95">
                                            Login to download
                                        </a>
                                    @endauth
                                </div>

                            </div>
                        @empty
                            <div class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                No published documents match your search yet.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        {{ $documents->withQueryString()->links() }}
                    </div>
                </div>
            </section>

            <footer class="mt-8 pb-6 text-center text-[0.75rem] text-slate-400 dark:text-slate-500">
                Document Library – Public Portal · {{ now()->year }}
            </footer>
        </div>
    </div>
</x-guest-layout>
