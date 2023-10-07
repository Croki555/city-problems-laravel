<x-admin-layout title="Изменение статуса">
    @section('content')
        <div class="mb-3">
            <a href="{{ route('manage.statuses') }}">Вернуться назад</a>
        </div>
        <form action="{{ route('edit.status.completed', ['id' => $id]) }}" class="d-flex flex-column gap-2" enctype="multipart/form-data" method="post" style="max-width: 350px">
            @csrf
            @method('PATCH')
            <div>
                <label for="image" class="form-label">Прикрепите фотографию в качестве доказательства</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="submit" value="Изменить статус" class="btn btn-primary">
            </div>
        </form>
    @endsection
</x-admin-layout>
