<x-app-layout title="Авторизация">s
    @section('content')
        <div class="w-100 m-auto" style="max-width: 330px; padding: 1rem">
            <form action="{{ route('authenficate') }}" method="post">
                @csrf
                <h3 class="mb-3">Авторизация</h3>
                <div class="form-floating mb-3">
                    <input type="text" name="login" placeholder="Логин" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" id="logins">
                    <label for="login">Логин</label>
                    @error('login')
                    <span class="d-block invalid-feedback">
                     {{ $message }}
                </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" placeholder="Пароль" class="form-control" name="password" id="password">
                    <label for="password">Пароль</label>
                </div>
                <input type="submit" class="col-6 btn btn-primary" value="Войти">
            </form>
        </div>
    @endsection
</x-app-layout>

