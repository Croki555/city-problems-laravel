<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xxl d-flex justify-content-end">
            <ul class="navbar-nav">
                @auth('web')
                    @if(auth()->user()->is_admin == 1)
                        <li class="nav-item">
                            <a href="{{ route('admin') }}" class="nav-link">Админка</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link">Личный кабинет</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form>
                            <a href="{{ route('logout') }}" onclick="this.closest('form').submit()" class="nav-link">Выйти</a>
                        </form>
                    </li>
                @endauth
                @guest('web')
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Войти</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>
