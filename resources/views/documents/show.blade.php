<x-guest-layout>
    {{-- helper to hide scrollbars for embedded viewer --}}
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

    @php
        $fileUrl = $document->file_path ? asset('storage/' . $document->file_path) : null;
        $extension = $document->file_path
            ? strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION))
            : null;
    @endphp

    <div class="relative min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        {{-- Gradient blobs --}}
        <div class="pointer-events-none fixed -top-24 -left-10 w-80 h-80 rounded-full blur-3xl bg-indigo-300/40 dark:bg-indigo-500/40"></div>
        <div class="pointer-events-none fixed -bottom-24 -right-10 w-64 h-64 rounded-full blur-3xl bg-emerald-300/40 dark:bg-emerald-500/40"></div>
        <div class="pointer-events-none fixed top-1/3 right-10 w-60 h-60 rounded-full blur-3xl bg-orange-300/40 dark:bg-orange-500/40"></div>

        <div class="relative max-w-4xl mx-auto py-8 px-4 space-y-6">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-300 bg-emerald-50/90 px-3.5 py-3 text-sm text-emerald-800 shadow-sm
                            dark:bg-emerald-900/40 dark:border-emerald-500/60 dark:text-emerald-100">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Top bar: back + meta --}}
            <div class="flex items-center justify-between gap-3">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 bg-white/90 text-xs md:text-sm text-slate-600 hover:bg-slate-100
                          dark:border-slate-600 dark:bg-slate-900/80 dark:text-slate-200 dark:hover:bg-slate-800/90">
                    ← Back
                </a>

                <div class="text-[11px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                    Document details
                </div>
            </div>

            {{-- Document header card --}}
            <div class="rounded-[18px] border border-slate-200 bg-white/95 p-5 shadow-[0_18px_40px_rgba(148,163,184,0.35)]
                        dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-50">
                    {{ $document->title }}
                </h1>

                <div class="mt-2 text-xs md:text-sm text-slate-600 dark:text-slate-300 space-y-0.5">
                    <div>
                        {{ $document->author_name ?? 'Unknown author' }}
                        @if($document->publication_year)
                            · {{ $document->publication_year }}
                        @endif
                        @if(optional($document->field)->name)
                            · {{ $document->field->name }}
                        @endif
                        @if(optional($document->genre)->name)
                            · {{ $document->genre->name }}
                        @endif
                    </div>

                    @if(optional($document->uploader)->name)
                        <div class="text-[0.8rem] text-slate-500 dark:text-slate-400">
                            Published by <span class="font-medium text-slate-700 dark:text-slate-200">
                                {{ $document->uploader->name }}
                            </span>
                        </div>
                    @endif

                    @if($document->keywords)
                        <div class="mt-1 flex flex-wrap gap-1.5 items-center">
                            <span class="text-[0.7rem] uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                Keywords:
                            </span>
                            <span class="text-[0.7rem] px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200
                                         dark:bg-slate-900 dark:text-slate-200 dark:border-slate-600">
                                {{ $document->keywords }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Download --}}
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    @auth
                        @can('download-documents')
                            <a href="{{ route('documents.download', $document) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 text-white text-xs md:text-sm shadow-[0_12px_30px_rgba(56,189,248,0.45)] hover:shadow-[0_16px_40px_rgba(56,189,248,0.6)]">
                                📥 Download document
                            </a>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-slate-300 bg-slate-50 text-xs md:text-sm text-slate-400 cursor-not-allowed
                                         dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-500">
                                No download permission
                            </span>
                        @endcan
                    @else
                        <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400">
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 underline underline-offset-2 hover:text-indigo-700 dark:hover:text-indigo-300">
                                Login
                            </a>
                            to download this document.
                        </p>
                    @endauth
                </div>
            </div>

            {{-- Document viewer --}}
            <div class="rounded-[18px] border border-slate-200 bg-white/95 shadow-[0_18px_40px_rgba(148,163,184,0.35)]
                        dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">
                <div class="px-4 pt-4 pb-2 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                        Document preview
                    </div>
                    <div class="text-[0.7rem] text-slate-500 dark:text-slate-400">
                        @if($extension)
                            File type: .{{ $extension }}
                        @else
                            No file attached
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-200 dark:border-slate-700/70">
                    @if($fileUrl && $extension === 'pdf')
                        {{-- Inline PDF viewer --}}
                        <div class="h-[600px] scroll-invisible overflow-y-auto">
                            <iframe
                                src="{{ $fileUrl }}#view=FitH"
                                class="w-full h-full border-0 rounded-b-[18px]"
                            ></iframe>
                        </div>
                    @elseif($fileUrl)
                        {{-- Fallback for non-PDF files --}}
                        <div class="px-4 py-6 text-sm text-slate-600 dark:text-slate-300">
                            Preview is only available for <span class="font-medium">PDF</span> files.
                            This file type (<span class="font-mono text-xs">.{{ $extension }}</span>) can be downloaded instead.
                            @auth
                                @can('download-documents')
                                    <div class="mt-3">
                                        <a href="{{ route('documents.download', $document) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500 text-white text-xs">
                                            📥 Download &amp; open
                                        </a>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @else
                        <div class="px-4 py-6 text-sm text-slate-500 dark:text-slate-400">
                            No file is attached to this document.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Comments section --}}
            <section class="space-y-4">
                <div class="rounded-[18px] border border-slate-200 bg-white/95 p-5 shadow-[0_18px_40px_rgba(148,163,184,0.35)]
                            dark:border-slate-600/70 dark:bg-slate-900/85 dark:shadow-[0_22px_50px_rgba(15,23,42,0.9)]">

                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-50">
                        Comments
                    </h2>

                    {{-- Comment form (only for logged-in users) --}}
                    @auth
                        <form method="POST" action="{{ route('documents.comments.store', $document) }}" class="mt-3 space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-slate-800 dark:text-slate-100 mb-1">
                                    Your comment
                                </label>
                                <textarea
                                    name="content"
                                    rows="3"
                                    class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900 shadow-sm
                                           focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-400
                                           dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50 dark:shadow-none
                                           dark:focus:ring-indigo-500/40 dark:focus:border-indigo-400 @error('content') border-rose-400 dark:border-rose-500 @enderror"
                                    placeholder="Share your thoughts about this document..."
                                >{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- ⭐ Star rating input --}}
                            <div class="flex flex-wrap items-center gap-3">
                                <div>
                                    <span class="block text-xs font-medium text-slate-700 dark:text-slate-200 mb-1">
                                        Rating (optional)
                                    </span>

                                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">

                                    <div class="flex items-center gap-1" id="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button
                                                type="button"
                                                class="star-btn text-lg leading-none"
                                                data-value="{{ $i }}"
                                                aria-label="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}"
                                            >
                                                <span class="@if(old('rating') >= $i) text-amber-400 @else text-slate-300 dark:text-slate-600 @endif">
                                                    ★
                                                </span>
                                            </button>
                                        @endfor
                                        <span class="ml-2 text-[0.75rem] text-slate-500 dark:text-slate-400" id="rating-label">
                                            @if(old('rating'))
                                                {{ old('rating') }}/5
                                            @else
                                                Tap a star to rate
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="ml-auto inline-flex items-center px-4 py-2 rounded-full bg-slate-900 text-white text-xs md:text-sm hover:bg-slate-800
                                               dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-200">
                                    Post comment
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 underline underline-offset-2 hover:text-indigo-700 dark:hover:text-indigo-300">
                                Login
                            </a>
                            to leave a comment.
                        </p>
                    @endauth

                    {{-- Existing comments --}}
                    <div class="mt-4 space-y-3">
                        @forelse($document->comments as $comment)
                            <div class="rounded-xl border border-slate-200 bg-white/95 px-3.5 py-2.5 text-sm shadow-sm
                                        dark:border-slate-700 dark:bg-slate-900/90">
                                <div class="flex items-start justify-between mb-1">
                                    <div>
                                        <div class="font-semibold text-slate-800 dark:text-slate-100">
                                            {{ optional($comment->user)->name ?? 'Unknown user' }}
                                        </div>

                                        @if($comment->rating)
                                            <div class="flex items-center gap-0.5 mt-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-[0.8rem] {{ $i <= $comment->rating ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600' }}">
                                                        ★
                                                    </span>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="text-[0.7rem] text-slate-500 dark:text-slate-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>

                                        {{-- 3 dots menu: only for owner or admin/lecturer --}}
                                        @auth
                                            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin() || auth()->user()->isLecturer())
                                                <div class="relative">
                                                    <button
                                                        type="button"
                                                        class="px-2 py-1 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100"
                                                        onclick="toggleCommentMenu({{ $comment->id }})"
                                                    >
                                                        ⋯
                                                    </button>

                                                    <div id="comment-menu-{{ $comment->id }}"
                                                         class="hidden absolute right-0 mt-1 w-32 rounded-lg border border-slate-200 bg-white shadow-lg
                                                                dark:border-slate-700 dark:bg-slate-800 text-xs">
                                                        <button
                                                            type="button"
                                                            class="w-full text-left px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700"
                                                            onclick="startEditComment({{ $comment->id }})"
                                                        >
                                                            ✏️ Edit
                                                        </button>

                                                        <form
                                                            method="POST"
                                                            action="{{ route('documents.comments.destroy', [$document, $comment]) }}"
                                                            onsubmit="return confirm('Delete this comment?')"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="w-full text-left px-3 py-2 text-rose-600 hover:bg-rose-50
                                                                       dark:text-rose-400 dark:hover:bg-rose-900/40"
                                                            >
                                                                🗑 Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                {{-- comment text / edit form toggle --}}
                                <div id="comment-view-{{ $comment->id }}">
                                    <p class="text-sm text-slate-700 dark:text-slate-200">
                                        {{ $comment->content }}
                                    </p>
                                </div>

                                {{-- hidden inline edit form --}}
                                @auth
                                    @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin() || auth()->user()->isLecturer())
                                        <div id="comment-edit-{{ $comment->id }}" class="hidden mt-2">
                                            <form method="POST" action="{{ route('documents.comments.update', [$document, $comment]) }}" class="space-y-2">
                                                @csrf
                                                @method('PATCH')

                                                <textarea
                                                    name="content"
                                                    rows="3"
                                                    class="w-full rounded-xl border border-slate-300 bg-white/90 px-3 py-2.5 text-sm text-slate-900
                                                           dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-50"
                                                >{{ $comment->content }}</textarea>

                                                {{-- simple numeric rating field (optional) --}}
                                                <input
                                                    type="number"
                                                    name="rating"
                                                    min="1"
                                                    max="5"
                                                    value="{{ $comment->rating }}"
                                                    class="w-20 rounded-lg border border-slate-300 px-2 py-1 text-xs
                                                           dark:border-slate-600 dark:bg-slate-900 dark:text-slate-50"
                                                    placeholder="Rating"
                                                >

                                                <div class="flex justify-end gap-2">
                                                    <button
                                                        type="button"
                                                        onclick="cancelEditComment({{ $comment->id }})"
                                                        class="px-3 py-1.5 rounded-full border border-slate-300 text-xs text-slate-600
                                                               dark:border-slate-600 dark:text-slate-300"
                                                    >
                                                        Cancel
                                                    </button>
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-1.5 rounded-full bg-slate-900 text-white text-xs
                                                               dark:bg-slate-100 dark:text-slate-900"
                                                    >
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                No comments yet. Be the first to review this document.
                            </p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- JS: star rating + comment menu/edit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ----- Star rating for create form -----
            const input = document.getElementById('rating-input');
            const stars = document.querySelectorAll('.star-btn');
            const label = document.getElementById('rating-label');

            function syncStars(value) {
                stars.forEach(btn => {
                    const v = parseInt(btn.dataset.value, 10);
                    const star = btn.querySelector('span');
                    if (value && v <= value) {
                        star.classList.add('text-amber-400');
                        star.classList.remove('text-slate-300', 'dark:text-slate-600');
                    } else {
                        star.classList.add('text-slate-300', 'dark:text-slate-600');
                        star.classList.remove('text-amber-400');
                    }
                });

                if (label) {
                    label.textContent = value ? `${value}/5` : 'Tap a star to rate';
                }
            }

            stars.forEach(btn => {
                btn.addEventListener('click', () => {
                    const value = parseInt(btn.dataset.value, 10);
                    if (input) {
                        input.value = value;
                    }
                    syncStars(value);
                });
            });

            // Initialize from old() value if present
            const initial = parseInt(input?.value || '0', 10);
            if (initial) {
                syncStars(initial);
            }
        });

        // ----- Comment menu + inline edit -----
        function toggleCommentMenu(id) {
            const menu = document.getElementById('comment-menu-' + id);
            if (!menu) return;

            // close all other menus
            document.querySelectorAll('[id^="comment-menu-"]').forEach(el => {
                if (el !== menu) el.classList.add('hidden');
            });

            menu.classList.toggle('hidden');
        }

        function startEditComment(id) {
            const view = document.getElementById('comment-view-' + id);
            const edit = document.getElementById('comment-edit-' + id);
            const menu = document.getElementById('comment-menu-' + id);

            if (view && edit) {
                view.classList.add('hidden');
                edit.classList.remove('hidden');
            }
            if (menu) {
                menu.classList.add('hidden');
            }
        }

        function cancelEditComment(id) {
            const view = document.getElementById('comment-view-' + id);
            const edit = document.getElementById('comment-edit-' + id);

            if (view && edit) {
                edit.classList.add('hidden');
                view.classList.remove('hidden');
            }
        }

        // close menus when clicking outside
        document.addEventListener('click', function (e) {
            const isMenuButton = e.target.closest('button[onclick^="toggleCommentMenu"]');
            const isMenu = e.target.closest('[id^="comment-menu-"]');

            if (!isMenuButton && !isMenu) {
                document.querySelectorAll('[id^="comment-menu-"]').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        });
    </script>
</x-guest-layout>
