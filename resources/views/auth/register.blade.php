<x-app-layout title="Регистрация">
    @section('content')
        <div class="w-100 m-auto" style="max-width: 330px; padding: 1rem">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <h3 class="mb-3">Регистрация</h3>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name"
                           regex="^[А-Яа-яЁё\-\s]+$" required placeholder="#"
                           error="Обязательное поле, разрешенные символы (кириллица, пробел и тире);">
                    <label for="name">Имя</label>
                    <span error="name"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="surname" value="{{ old('surname') }}" id="surname"
                           required
                           regex="^[А-Яа-я\-\s]+$" placeholder="#"
                           error="Обязательное поле, разрешенные символы (кириллица, пробел и тире)">
                    <label class="form-label" for="surname">Фамилия</label>
                    <span error="surname"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="patronymic" value="{{ old('patronymic') }}"
                           id="patronymic" regex="^[А-Яа-я\-\s]+$" placeholder="#"
                           error="Не обязательное поле, разрешенные символы (кириллица, пробел и тире)">
                    <label for="patronymic">Отчество</label>
                    <span error="patronymic"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="login" value="{{ old('login') }}" id="login"
                           error="Обязательное поле, разрешенные символы (латиница, цифры и тире)" placeholder="#" required>
                    <label class="form-label" for="login">Логин</label>
                    <span error="login"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" required
                           error="Обязательное поле для заполнения" placeholder="#">
                    <label for="email">Почта</label>
                    <span error="email"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" required placeholder="#" value="123456">
                    <label for="password">Пароль</label>
                    <span error="password"></span>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="#" value="123456">
                    <label for="password_confirmation">Подтверждение пароля:</label>
                    <span error="password_confirmation"></span>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-check-label" for="agree">Согласие с правилами регистрации:</label>
                    <input type="checkbox" class="form-check-input" name="agree" id="agree" required checked>
                    <span error="agree"></span>
                </div>
                <input type="submit" class="btn btn-primary" value="Зарегистрироваться">
            </form>
        </div>
    @endsection
    <x-slot name="scripts">
        <script type="module">
            $(document).ready(function () {
                $('input[type="text"]').blur(function () {
                    let regex = new RegExp($('input[type="text"]').attr('regex'));
                    $(this).removeClass('is-invalid is-valid').removeAttr('is-invalid')
                    $(`span[error=${$(this).attr('name')}]`).text('').removeClass('invalid-feedback');

                    if (!regex.test($(this).val()) && $(this).val().length > 0) {
                        $(`span[error=${$(this).attr('name')}]`)
                            .text($(this).attr('error'))
                            .addClass('invalid-feedback');
                        $(this).addClass('is-invalid').attr('is-invalid', '');
                    }else if (regex.test($(this).val())) {
                        $(`span[error=${$(this).attr('name')}]`).text('').removeClass('invalid-feedback');
                        $(this).removeClass('is-invalid').addClass('is-valid').removeAttr('is-invalid');
                    }
                })

                ajaxRequest('login', 'login', '^[A-Za-z0-9\-]+$', 'http://laravel/register', 'Обязательное поле, разрешенные символы (латиница, цифры и тире)');
                ajaxRequest('email', 'email', '^[a-z0-9]+[.]?[a-z0-9]+@[a-z]+.[a-z]+$', 'http://laravel/register', 'Не валидный адрес электронной почты');

                function ajaxRequest(inputName, spanName, regexString, urlAjax, errorTitle) {
                    let spanError = $(`span[error=${spanName}]`);
                    let input = $(`input[name=${inputName}]`);

                    input.blur(function () {
                        let regex = new RegExp(regexString);
                        if (!regex.test(input.val()) && input.val().length > 0) {
                            spanError.text(errorTitle)
                                .removeClass('valid')
                                .addClass('invalid-feedback');

                            input.removeClass('is-valid')
                                .addClass('is-invalid')
                                .attr('is-invalid', '');
                        }
                        if (regex.test(input.val())) {
                            $.ajax({
                                url: urlAjax,
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    [inputName]: input.val(),
                                    '_token': $('input[name="_token"]').val(),
                                },
                                success: function (data) {
                                    console.log(data);
                                },
                                error: function (data) {
                                    console.log(data);
                                    if (data.status === 200) {
                                        input.removeClass('is-invalid')
                                            .addClass('is-valid')
                                            .removeAttr('is-invalid', '');

                                        spanError.text('')
                                            .removeClass('invalid-feedback')
                                            .addClass('valid-feedback');
                                    }
                                    if (data.status === 422) {
                                        input.removeClass('is-valid')
                                            .addClass('is-invalid')
                                            .attr('is-invalid', '');

                                        spanError.text(data.responseJSON.errors[inputName])
                                            .removeClass('valid-feedback')
                                            .addClass('invalid-feedback');
                                    }
                                }
                            })
                        }
                    })
                }

                $('input[name="password"]').blur(function () {
                    if ($(this).val().length < 6 && $(this).val().length > 0) {
                        $(this).removeClass('is-valid').addClass('is-invalid') .attr('is-invalid', '');
                        $('input[name="password_confirmation"]').val('').css('background-color', '');
                        $(`span[error=${$(this).attr('name')}]`).removeClass('valid-feedback').addClass('invalid-feedback').text('Не менее 6-ти символов')
                    }
                    if($(this).val().length > 6){
                        $(this).removeClass('is-invalid').addClass('is-valid').removeAttr('is-invalid');
                        $('input[name="password_confirmation"]').val('').removeClass('is-valid');
                        $(`span[error=${$(this).attr('name')}]`).removeClass('invalid-feedback').addClass('valid-feedback').text('');
                    }
                })

                $('input[name="password_confirmation"]').blur(function () {

                    if ($(this).val() !== $('input[name="password"]').val() && $('input[name="password"]').val().length > 0) {
                        $(this).removeClass('is-valid').addClass('is-invalid').attr('is-invalid', '');
                        $(`span[error=${$(this).attr('name')}]`).removeClass('valid-feedback').addClass('invalid-feedback').text('Пароли не совпадают');
                    }

                    if($(this).val() === $('input[name="password"]').val() && $(this).val().length > 0) {
                        $(this).removeClass('is-invalid').addClass('is-valid').removeAttr('is-invalid', '');
                        $(`span[error=${$(this).attr('name')}]`).removeClass('invalid-feedback').addClass('valid-feedback').text('');
                    }
                })

                $('form').on('submit', function (ev) {
                    ev.preventDefault();
                    let sub = true;
                    $('input').each(function (inx, el) {
                        if ($(el).attr('is-invalid') !== undefined) {
                            sub = false;
                        }
                    })

                    if (sub) {
                        $.ajax({
                            url: 'http://laravel/register',
                            method: 'post',
                            data: {
                                'name': $('input[name="name"]').val(),
                                'surname': $('input[name="surname"]').val(),
                                'patronymic': $('input[name="patronymic"]').val(),
                                'login': $('input[name="login"]').val(),
                                'password': $('input[name="password"]').val(),
                                'email': $('input[name="email"]').val(),
                                '_token': $('input[name="_token"]').val(),
                            },
                            success: function (data) {
                                $(location).attr('href', 'http://laravel');
                            },
                        })
                    }
                })
            })
        </script>
    </x-slot>
</x-app-layout>
