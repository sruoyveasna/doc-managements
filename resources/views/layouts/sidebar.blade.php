@php
    /** @var \App\Models\User|null $user */
    $user = auth()->user();
@endphp

<aside
    class="w-64 hidden md:flex flex-col
           h-screen
           bg-white/90 border-r border-slate-200 backdrop-blur-xl text-slate-800
           dark:bg-slate-950/80 dark:border-slate-800/80 dark:text-slate-100"
>
    {{-- BRAND / LOGO --}}
    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800/80 flex items-center gap-3 shrink-0">
        <div
            class="w-9 h-9 rounded-2xl bg-gradient-to-br from-indigo-500 via-emerald-400 to-amber-400
                   flex items-center justify-center text-xs font-bold shadow-lg shadow-indigo-500/50 text-white"
        >
            DL
        </div>
        <div>
            <div class="text-sm font-semibold tracking-tight">
                DocLibrary Admin
            </div>
            <div class="text-[11px] text-slate-500 dark:text-slate-400">Control center</div>
        </div>
    </div>

    {{-- NAVIGATION (middle, scrollable if needed) --}}
    <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto custom-scroll">
        {{-- Home (public portal at /) --}}
        <a href="{{ route('home') }}"
           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                  {{ request()->routeIs('home')
                        ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                        : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
            <span>🏠</span>
            <span>Home</span>
        </a>

        {{-- Dashboard (logged-in landing page) --}}
        <a href="{{ route('dashboard') }}"
           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                  {{ request()->routeIs('dashboard')
                        ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                        : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
            <span>📊</span>
            <span>Dashboard</span>
        </a>

        {{-- Documents manager --}}
        <a href="{{ route('documents.index') }}"
           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                  {{ request()->routeIs('documents.index') || request()->routeIs('documents.edit') || request()->routeIs('documents.create')
                        ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                        : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
            <span>📁</span>
            <span>Documents</span>
        </a>

        {{-- Everything below ONLY for admins (lecturer sees only Home/Dashboard/Documents) --}}
        @if($user && $user->isAdmin())
            {{-- Users management --}}
            <a href="{{ route('users.index') }}"
               class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                      {{ request()->routeIs('users.index') || request()->routeIs('users.edit') || request()->routeIs('users.create')
                            ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                            : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
                <span>👥</span>
                <span>Users</span>
            </a>

            <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-800/70 text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-500">
                Catalog
            </div>

            {{-- Authors (still placeholder – not linked) --}}


            {{-- Fields management --}}
            <a href="{{ route('fields.index') }}"
               class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                      {{ request()->routeIs('fields.index') || request()->routeIs('fields.edit') || request()->routeIs('fields.create')
                            ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                            : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
                <span>🧭</span>
                <span>Fields</span>
            </a>

            {{-- Genres (turn into a link once genres management is built) --}}
            {{-- Genres management --}}
            <a href="{{ route('genres.index') }}"
            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                    {{ request()->routeIs('genres.index') || request()->routeIs('genres.edit') || request()->routeIs('genres.create')
                            ? 'bg-slate-100 text-slate-900 font-medium dark:bg-slate-800 dark:text-slate-50'
                            : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/80' }}">
                <span>🏷️</span>
                <span>Genres</span>
            </a>

        @endif
    </nav>

    {{-- FOOTER: user + theme toggle + dropdown --}}
    <div
        x-data="{ open: false }"
        class="px-4 py-3 border-t border-slate-200 dark:border-slate-800/80 text-xs flex items-center justify-between gap-3 shrink-0 relative"
    >
        {{-- User info + dropdown trigger --}}
        <button
            type="button"
            @click="open = !open"
            @click.away="open = false"
            class="flex items-center gap-2 text-left focus:outline-none"
        >
            <div class="flex flex-col">
                <span class="text-slate-500 dark:text-slate-400">
                    {{ $user?->name ?? 'Guest' }}
                </span>
                @if($user)
                    <span class="text-[11px] text-slate-400 dark:text-slate-500">
                        Role: <span class="capitalize">{{ $user->role }}</span>
                    </span>
                @endif
            </div>
            <span class="text-[0.7rem] text-slate-400">▾</span>
        </button>

        {{-- Theme toggle --}}
        <button
            type="button"
            id="sidebar-theme-toggle"
            class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-slate-300 bg-white shadow-sm text-slate-700
                   hover:bg-slate-100
                   dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
            title="Toggle light / dark mode"
        >
            <span id="sidebar-theme-icon">🌙</span>
        </button>

        {{-- User dropdown (Profile / Logout) --}}
        <div
            x-cloak
            x-show="open"
            x-transition.opacity.duration.150ms
            class="absolute left-4 right-4 bottom-14 z-30
                   rounded-xl border border-slate-200 bg-white shadow-lg text-xs
                   dark:border-slate-700 dark:bg-slate-900"
        >
            <div class="px-3 py-2 border-b border-slate-100 dark:border-slate-800">
                <div class="text-[11px] text-slate-400 dark:text-slate-500 uppercase tracking-wide">
                    Account
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">
                    {{ $user?->email }}
                </div>
            </div>

            <div class="py-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-3 py-2 hover:bg-slate-100 text-slate-700
                          dark:hover:bg-slate-800 dark:text-slate-200">
                    <span>👤</span>
                    <span>Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 text-left hover:bg-slate-100 text-slate-700
                               dark:hover:bg-slate-800 dark:text-slate-200"
                    >
                        <span>🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

{{-- Simple theme toggle script (uses Tailwind darkMode: "class") --}}
<script>
    (function () {
        const html = document.documentElement;
        const btn  = document.getElementById('sidebar-theme-toggle');
        const icon = document.getElementById('sidebar-theme-icon');

        if (!btn || !icon) return;

        function applyTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
                icon.textContent = '☀️';
            } else {
                html.classList.remove('dark');
                icon.textContent = '🌙';
            }
        }

        const stored = localStorage.getItem('theme');
        if (stored === 'dark' || stored === 'light') {
            applyTheme(stored);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }

        btn.addEventListener('click', () => {
            const isDark = html.classList.contains('dark');
            const next   = isDark ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    })();
</script>

{{-- hide scrollbars but keep scroll --}}
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
