<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Document Library') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-50 antialiased">

@php
    $user = auth()->user();
    $isManager = $user && (
        (method_exists($user, 'isAdmin') && $user->isAdmin()) ||
        (method_exists($user, 'isLecturer') && $user->isLecturer())
    );
@endphp

<div class="min-h-screen flex flex-col">
    @if ($isManager)
        {{-- ADMIN / LECTURER: sidebar + main, NO topbar --}}
        <div class="flex flex-1 bg-slate-950 text-slate-50">
            @include('layouts.sidebar')

            <main class="flex-1 overflow-y-auto bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
                {{ $slot }}
            </main>
        </div>
    @else
        {{-- STUDENT (or any non-manager logged-in user): topbar + full-width content --}}
        @include('layouts.navigation')

        <main class="flex-1 bg-slate-50 dark:bg-slate-900">
            {{ $slot }}
        </main>
    @endif
</div>

{{-- Dark / light toggle script --}}
<script>
    (function () {
        const root = document.documentElement;
        const btn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');
        const label = document.getElementById('theme-toggle-text');

        if (!btn) return;

        function setTheme(mode) {
            if (mode === 'dark') {
                root.classList.add('dark');
                icon.textContent = '🌞';
                label.textContent = 'Light';
            } else {
                root.classList.remove('dark');
                icon.textContent = '🌙';
                label.textContent = 'Dark';
            }
        }

        const saved = localStorage.getItem('theme');
        if (saved === 'dark' || saved === 'light') {
            setTheme(saved);
        } else {
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;
            setTheme(prefersDark ? 'dark' : 'light');
        }

        btn.addEventListener('click', () => {
            const isDark = root.classList.contains('dark');
            const next = isDark ? 'light' : 'dark';
            setTheme(next);
            localStorage.setItem('theme', next);
        });
    })();
</script>

</body>
</html>
