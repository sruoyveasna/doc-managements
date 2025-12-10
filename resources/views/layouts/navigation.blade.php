@php
    use Illuminate\Support\Facades\Route;

    $user = auth()->user();
    $routeName = Route::currentRouteName();
    $isAuthPage = in_array($routeName, ['login', 'register']);
@endphp

<nav class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/80 backdrop-blur-xl dark:border-slate-700/40 dark:bg-slate-950/80">
    <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">

        {{-- LEFT: Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div
                class="w-9 h-9 rounded-full bg-[conic-gradient(at_top,_#6366f1,_#22c55e,_#f97316,_#ec4899,_#6366f1)] flex items-center justify-center text-xs font-extrabold text-white shadow-[0_10px_24px_rgba(99,102,241,0.55)]"
            >
                DL
            </div>
            <div class="hidden sm:block leading-tight">
                <div class="text-sm font-semibold text-slate-900 dark:text-slate-50">
                    Document Library
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400">
                    Public Portal
                    @auth
                        · {{ ucfirst($user->role ?? 'user') }}
                    @endauth
                </div>
            </div>
        </a>

        {{-- RIGHT: actions --}}
        <div class="flex items-center gap-2 text-xs">

            {{-- Theme toggle (always visible) --}}
            <button
                id="theme-toggle"
                type="button"
                class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-slate-100/90 text-slate-800 hover:bg-slate-200/90 dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-100 dark:hover:bg-slate-800/90"
            >
                <span id="theme-toggle-icon">🌙</span>
                <span id="theme-toggle-text">Dark</span>
            </button>

            @if($isAuthPage)
                {{-- On login/register: only logo + theme toggle --}}
            @else
                @auth
                    {{-- Logged-in (student etc.) --}}
                    <a href="{{ route('dashboard') }}"
                       class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-slate-50 text-slate-800 hover:bg-slate-100
                              dark:border-slate-600 dark:bg-slate-900/90 dark:text-slate-100 dark:hover:bg-slate-800/90">
                        <span>📊</span> <span>Dashboard</span>
                    </a>

                    <div class="hidden sm:flex items-center gap-2">
                        <span class="text-slate-500 dark:text-slate-400">Hi,</span>
                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $user->name }}</span>

                        <a href="{{ route('profile.edit') }}"
                           class="px-2 py-1 rounded-full border border-slate-300 text-[11px] text-slate-700 hover:bg-slate-100
                                  dark:border-slate-600 dark:text-slate-100 dark:hover:bg-slate-800/90">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-2 py-1 rounded-full bg-rose-500 text-[11px] text-white hover:bg-rose-600">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Guest / outsider: Login / Register --}}
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-transparent bg-gradient-to-r from-indigo-500 to-emerald-500 text-white shadow-[0_14px_40px_rgba(56,189,248,0.45)] hover:shadow-[0_18px_45px_rgba(56,189,248,0.65)] text-[0.8rem]">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-300 bg-slate-50 text-slate-800 hover:bg-slate-100 text-[0.8rem]
                                  dark:border-slate-600 dark:bg-slate-900/95 dark:text-slate-100 dark:hover:bg-slate-800/95">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>
