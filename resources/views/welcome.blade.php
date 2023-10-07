<x-app-layout title="Главная">
    @section('content')
        <div class="mb-5">
            <h3 class="mb-3">Количество пользователей: <span class="countUsers">{{ $countUsers }}</span></h3>
            <h3>Количество решенных заявок: <span class="countApplication">{{ $countOrdersCompleted }}</span></h3>
        </div>
        <x-slot name="scripts">
            <script>
                function countUsersOrders() {
                    $.ajax({
                        url: 'http://laravel/',
                        method: 'GET',
                        data: {
                            'countUsersApplication': true,
                        },
                        success: function (data) {
                            $('.countUsers').text(data.countUsers);
                            $('.countApplication').text(data.countApplication);
                        }
                    })
                }
                window.setInterval(countUsersOrders, 5000);
            </script>
        </x-slot>
        <div class="row row-cols-md-2 g-4 mb-3">
            @foreach($ordersCompleted as $order)
                <div class="col">
                    <div class="card">
                        <img src="http://laravel/image/orders/{{ $order->before_url }}" class="card-img-top"
                             alt="{{ $order->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->title }}</h5>
                            <p class="card-text">{{ $order->description }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Категория: <b>{{ $order->category->title }}</b></li>
                            <li class="list-group-item">Статус: <span class="text-success">{{ $order->status->title }}</span></li>
                            <li class="list-group-item">{{ $order->updated_at }}</li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $ordersCompleted->links() }}
        </div>
    @endsection
</x-app-layout>
