<x-admin-layout title="Админка">
    @section('content')
        <h1>Добро пожаловать {{ auth('web')->user()->name }}</h1>
    @endsection
</x-admin-layout>
