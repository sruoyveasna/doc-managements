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
                        Documents
                    </p>
                    <h1 class="mt-1 text-2xl font-extrabold tracking-tight">
                        Create a
                        <span class="bg-gradient-to-r from-indigo-500 via-emerald-500 to-sky-500 bg-clip-text text-transparent">
                            new document
                        </span>
                    </h1>
                    <p class="mt-1 text-xs md:text-sm text-slate-600 dark:text-slate-300">
                        Fill in the metadata and upload the file. You can save as draft or publish immediately.
                    </p>
                </div>

                <a href="{{ route('documents.index') }}"
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

                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                            Title <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                   dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                   dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                        >
                    </div>

                    {{-- Year + Status --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                Publication year <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="publication_year"
                                value="{{ old('publication_year') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                Status <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    name="status"
                                    class="block w-full rounded-full border border-slate-300 bg-white/90 px-3 pr-9 py-2.5 text-sm text-slate-800 shadow-sm
                                           appearance-none
                                           focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                           dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:shadow-none
                                           dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                >
                                    <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                                    <option value="published" @selected(old('status') === 'published')>Published</option>
                                    <option value="archived" @selected(old('status') === 'archived')>Archived</option>
                                </select>
                                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.75rem] text-slate-400">
                                    ▾
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Keywords --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                            Keywords (comma separated)
                        </label>
                        <input
                            type="text"
                            name="keywords"
                            value="{{ old('keywords') }}"
                            class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                   dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                   dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                        >
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Example: algorithms, data structures, Java
                        </p>
                    </div>

                    {{-- Author name / Field / Genre --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        {{-- Author (free text) --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                Author name <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="author_name"
                                value="{{ old('author_name') }}"
                                class="w-full rounded-full border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                       dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-50 dark:shadow-none
                                       dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                            >
                            <p class="mt-1 text-[0.7rem] text-slate-500 dark:text-slate-400">
                                The name that will appear as the author on the public page.
                            </p>
                        </div>

                        {{-- Field --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                Field <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    name="field_id"
                                    class="block w-full rounded-full border border-slate-300 bg-white/90 px-3 pr-9 py-2.5 text-sm text-slate-800 shadow-sm
                                           appearance-none
                                           focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                           dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:shadow-none
                                           dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                >
                                    <option value="">Select field</option>
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}" @selected(old('field_id') == $field->id)>
                                            {{ $field->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.75rem] text-slate-400">
                                    ▾
                                </span>
                            </div>
                        </div>

                        {{-- Genre --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                Genre <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    name="genre_id"
                                    class="block w-full rounded-full border border-slate-300 bg-white/90 px-3 pr-9 py-2.5 text-sm text-slate-800 shadow-sm
                                           appearance-none
                                           focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                           dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:shadow-none
                                           dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400"
                                >
                                    <option value="">Select genre</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" @selected(old('genre_id') == $genre->id)>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.75rem] text-slate-400">
                                    ▾
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- File upload --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                            Document file <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="file"
                            name="file"
                            class="block w-full text-sm text-slate-700 dark:text-slate-200
                                   file:mr-3 file:py-1.5 file:px-3
                                   file:rounded-full file:border-0
                                   file:text-xs file:font-medium
                                   file:bg-indigo-600 file:text-white
                                   hover:file:bg-indigo-700
                                   dark:file:bg-indigo-500 dark:hover:file:bg-indigo-600"
                        >
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Allowed: pdf, doc, docx, txt · Max 10MB
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2 flex items-center gap-3">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 text-white text-sm shadow-[0_12px_30px_rgba(56,189,248,0.45)] hover:shadow-[0_16px_40px_rgba(56,189,248,0.6)]"
                        >
                            Save document
                        </button>

                        <a href="{{ route('documents.index') }}"
                           class="text-xs md:text-sm inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-white/90 text-slate-6
00 hover:bg-slate-100
                                  dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200 dark:hover:bg-slate-800/90">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
