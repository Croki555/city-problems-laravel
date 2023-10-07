<x-admin-layout title="Изменение статуса">
    @section('content')
        <div class="mb-3">
            <a href="{{ route('manage.statuses') }}">Вернуться назад</a>
        </div>

        <form action="{{ route('edit.status.cancel', ['id' => $id]) }}" class="d-flex flex-column gap-4" enctype="multipart/form-data" method="post" style="max-width: 350px">
            @csrf
            @method('PATCH')
            <div>
                <label for="message" class="form-label">Обязательно указать причину отказа</label>
                <textarea name="message" cols="30" rows="10" class="form-control @error('message') is-invalid @enderror"></textarea>
                @error('message')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="submit" value="Изменить статус" class="btn btn-primary align-self-start">
            </div>
        </form>
    @endsection
</x-admin-layout>
