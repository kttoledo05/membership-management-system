<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Membership Management and Transaction Processing System' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar no-print">
            <div class="brand-block">
                <div class="brand-mark">M</div>
                <div>
                    <div class="brand">MMP System</div>
                    <small>Management Portal</small>
                </div>
            </div>

            <p class="menu-label">MAIN MENU</p>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span>⌂</span> Dashboard</a>
            <a class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}"><span>♙</span> Members</a>
            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}"><span>▣</span> Transactions</a>

            <p class="menu-label">MANAGEMENT</p>
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"><span>◈</span> Categories</a>
            <a class="nav-link {{ request()->routeIs('levels.*') ? 'active' : '' }}" href="{{ route('levels.index') }}"><span>✦</span> Membership levels</a>

            <div class="sidebar-bottom">
                <div class="user-mini"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>Administrator</small></div></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-link" type="submit">↪ Sign out</button></form>
            </div>
        </aside>

        <div class="content-area">
            <header class="topbar no-print"><div><span class="topbar-title">Membership Management and Transaction Processing System</span><span class="topbar-subtitle">A simple way to organize your membership records</span></div><div class="topbar-date">{{ now()->format('F d, Y') }}</div></header>

            <main class="container">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
