<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.min.css">
</head>
<body>
<main class="overflow-hidden">
    <div class="row">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark col-2" style="height: 100vh">
            <h3>Админка</h3>
            <hr>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link text-white">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.categories') }}" class="nav-link text-white @if($_SERVER['REQUEST_URI'] == '/manage-categories') active @endif">Управление категориями заявок</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manage.statuses') }}" class="nav-link text-white @if($_SERVER['REQUEST_URI'] == '/manage-statuses') active @endif">Управление статусами заявок</a>
                </li>
                <li class="nav-item">
                    <form method="post">
                        <a href="{{ route('logout') }}" onclick="this.closest('form').submit()" class="nav-link text-white">Выйти</a>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-10">
            <div class="container-fluid m-0 pt-5">
                @yield('content')
            </div>
        </div>
    </div>
</main>
<script src="js/jquery-1.11.3.js"></script>
@if(isset($scripts))
    {{ $scripts }}
@endif
</body>
</html>
