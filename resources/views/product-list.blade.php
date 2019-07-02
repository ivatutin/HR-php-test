@extends('layout')

@section('content')
    <table class="table table-striped table-hover" id="appProducts">
        <thead>
        <tr>
            <th>ID</th>
            <th>Наименование продукта</th>
            <th>Наименование поставщика</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['vendor']['name'] }}</td>
                <td>
                    <price-edit product_id="{{$product['id']}}" price="{{ $product['price'] }}"></price-edit>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
    @push('scripts')
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @endpush
@endsection