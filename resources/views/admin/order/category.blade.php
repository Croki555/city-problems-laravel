<x-admin-layout title="Управление категориями заявок">
    @section('content')
        <table class="table" style="max-width: 500px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->title }}</td>
                    <td>
                        <form action="{{ route('deleteCategory', ['id'=> $category->id]) }}" class="form-delete" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Удалить" class="btn btn-link">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <h2>Добавление категорий</h2>
            <form class="row row-cols-2" action="{{ route('createCategory') }}" method="post">
                @csrf
                @method('PUT')
                <div class="col-6">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Название" name="title">
                    @error('title')
                    <span class="invalid-feedback"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="submit" class="btn btn-primary" value="Добавить">
                </div>
            </form>
        </div>
    @endsection
</x-admin-layout>
