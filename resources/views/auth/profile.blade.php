<x-app-layout title="Личный кабинет пользователя">
    @section('content')
        <div class="row w-25">
            <label for="status">Фильтрация по статусу:</label>
            <form method="get">
                <select name="status" class="form-control">
                    <option selected disabled>Статус</option>
                    <option value="0" @selected(old('status') == 0)>Все</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" @selected($status->id == $oldStatus)>{{ $status->title }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        @if($orders->count() > 0)
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Время</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Категория</th>
                    <th>Статус</th>
                    <th>Причина отказа</th>
                    <th></th>
                </thead>
                <tbody
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->title }}</td>
                        <td>{{ $order->description }}</td>
                        <td>{{ $order->category->title }}</td>
                        <td>{{ $order->status->title }}</td>
                        <td>
                            @if($order->status->title == 'Отклонена')
                                {{ $order->rejection_reason }}
                                @else
                                -
                            @endif
                        </td>
                        @if($order->status->title == 'Новая')
                            <td>
                                <form action="{{ route('deleteOrder', ['id'=> $order->id]) }}" class="form-delete"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Удалить" class="btn btn-link p-0">
                                </form>
                            </td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2>Заявок нет</h2>
        @endif

        <div>
            <a href="{{ route('createOrder') }}" class="btn-link">Создать заявку</a>
        </div>
    @endsection
    <x-slot name="scripts">
        <script>
            $('select[name="status"]').change(function () {
                $(this).closest('form').submit();
            })
            $('.form-delete').on('submit', () => {
                if (confirm('Подтвердите для удаления')) {
                    return true;
                }
                return false
            })
        </script>
    </x-slot>
</x-app-layout>
