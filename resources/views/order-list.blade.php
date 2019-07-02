@extends('layout')

@section('content')

    <ul class="nav nav-tabs">
        @foreach (config('prj.order_tabs') as $val)
        <li class="{{ request()->get('type') == $val['type'] ? 'active' : '' }}"><a href="{{ route('order.list', ['type' => $val['type']]) }}">{{ $val['title'] }}</a></li>
        @endforeach
    </ul>

    <table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Партнер</th>
        <th>Стоимость</th>
        <th>Статус заказа</th>
        <th>Дата доставки</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td><a href="{{ route('order.edit', $order['id']) }}" class="font-big" target="_blank">{{ $order['id'] }}</a></td>
            <td>{{ $order['partner']['name'] }}</td>
            <td>{{ $order['cost'] }}</td>
            <td>{{ config('prj.status_list')[$order['status']] }}</td>
            <td>{{ $order['delivery_dt'] }}</td>
        </tr>
        <tr>
            <td colspan="5">
                <table class="table table-less">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Стоимость</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order['products'] as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['pivot']['price'] }}</td>
                            <td>{{ $product['pivot']['quantity'] }}</td>
                            <td>{{ $product['pivot']['quantity']*$product['pivot']['price'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection