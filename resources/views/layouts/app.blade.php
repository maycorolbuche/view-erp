<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('title')
        @if (!empty(trim($__env->yieldContent('title'))))
            ::
        @endif View FS
    </title>

    @include('layouts.partials.meta')

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @include('layouts.partials.css')
    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="overlay"></div>

    @include('layouts.partials.sidebar')


    <main class="main">
        <div class="hero-bg"></div>

        @include('layouts.partials.header')

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const collapseBtn = document.getElementById('collapseBtn');

        // Mobile open/close
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

        // Desktop collapse (icons only)
        collapseBtn.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('collapsed');
            // close all submenus when collapsing
            if (sidebar.classList.contains('collapsed')) {
                document.querySelectorAll('.submenu.open').forEach(s => s.classList.remove('open'));
                document.querySelectorAll('[aria-expanded="true"]').forEach(b => b.setAttribute('aria-expanded',
                    'false'));
            }
        });

        // Submenus
        document.querySelectorAll('[data-toggle-sub]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                if (sidebar.classList.contains('collapsed')) return;
                const id = btn.getAttribute('data-toggle-sub');
                const sub = document.getElementById(id);
                const open = sub.classList.toggle('open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });

        // Close mobile sidebar on link click
        document.querySelectorAll('.submenu a').forEach(a => {
            a.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>
