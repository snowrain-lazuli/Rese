<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech 勤怠管理アプリ</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="left">
                <button class="hamburger" id="hamburger" aria-label="メニューを開く">
                    <div class="hamburger-lines">
                        <span class="bar bar-middle"></span>
                        <span class="bar bar-long"></span>
                        <span class="bar bar-short"></span>
                    </div>

                    <span class="close-icon">×</span>
                </button>
                <h1 class="logo">Rise</h1>
            </div>
            @yield('link')
        </header>

        <main class="content">
            @yield('content')
        </main>

        <div class="overlay-menu" id="overlayMenu">
            <ul>
                @auth
                @php
                $role = Auth::user()->role;
                @endphp

                @if ($role === 1)
                {{-- role1: 一般ユーザー --}}
                <li>
                    <form action="{{ route('shop.index') }}" method="get">
                        @csrf
                        <button type="submit">Home</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('mypage') }}" method="get">
                        @csrf
                        <button type="submit">Mypage</button>
                    </form>
                </li>

                @elseif ($role === 2)
                {{-- role2: 店舗代表者 --}}
                <li>
                    <form action="{{ route('shop.index') }}" method="get">
                        @csrf
                        <button type="submit">Home</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('owner') }}" method="get">
                        @csrf
                        <button type="submit">Making</button>
                    </form>
                </li>

                @elseif ($role === 3)
                {{-- role3: 管理者 --}}
                <li>
                    <form action="{{ route('shop.index') }}" method="get">
                        @csrf
                        <button type="submit">Home</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>

                <li><a href="/admin/register">Create Manager</a></li>

                @endif

                @else
                {{-- 未ログイン時 --}}
                <li>
                    <form action="{{ route('shop.index') }}" method="get">
                        @csrf
                        <button type="submit">Home</button>
                    </form>
                </li>
                <li><a href="/register">Registration</a></li>
                <li><a href="/login">Login</a></li>
                @endauth
            </ul>
        </div>

    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('js')
</body>

</html>