<x-app-layout title="Создание заявки">
    @section('content')
        <form action="{{ route('storeOrder') }}"  method="post" class="d-flex flex-column m-auto gap-4" style="max-width: 300px" enctype="multipart/form-data">
            @csrf
            <div class="form-floating">
                <input type="text" class="form-control  @error('title') is-invalid @enderror" name="title" value="Тестовое название" placeholder="#">
                <label for="title">Название:</label>
                @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option selected disabled>Категория</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                @error('category')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating">
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="#">Тестовое описание</textarea>
                <label for="description">Описание:</label>
                @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="file" class="form-control @error('before_url') is-invalid @enderror" name="before_url">
                @error('before_url')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <input type="submit"  class="btn btn-primary align-self-start" value="Создать">
            </div>
        </form>
    @endsection
</x-app-layout>
