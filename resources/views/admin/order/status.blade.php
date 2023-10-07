<x-admin-layout title="Управление статусами заявок">
    @section('content')
        <h2>Заявки пользователей</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Время</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Причина отказа</th>
                        <th>Изменение статуса</th>
                    </tr>
                </thead>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>{{ $order->title }}</td>
                        <td>{{ $order->description }}</td>
                        <td>{{ $order->category->title }}</td>
                        <td>{{ $order->status->title }}</td>
                        <td>
                            @if($order->rejection_reason)
                                {{ $order->rejection_reason }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($order->status->title == 'Новая')
                                <a href="{{ route('form.status.completed', ['id'=> $order->id]) }}" class="btn-link link-success">Решена</a>
                                <a href="{{ route('form.status.cancel', ['id'=> $order->id]) }}" class="btn-link link-danger">Отклонена</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
    @endsection
</x-admin-layout>
