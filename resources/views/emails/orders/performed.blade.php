@component('mail::message')
Заказ № {{ $order['id'] }}

Состав заказа:
@component('mail::table')
| Товар         | Цена          | Кол-во        | Стоимость  |
| ------------- |:-------------:|:-------------:| ----------:|
@foreach ($order['products'] as $product)
| {{ $product['name'] }} | {{ $product['pivot']['price'] }} | {{ $product['pivot']['quantity'] }} | {{ $product['pivot']['quantity']*$product['pivot']['price'] }} |
@endforeach
@endcomponent

Стоимость заказза - {{ $order['cost'] }}


-------------------------
С уважением,<br>
{{ config('app.name') }}
@endcomponent
