@extends('layout')
@section('content')
    <div class="card uper">
        <div class="card-body">
            <form method="post" action="{{ route('order.update', ['id' => $order['id']]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>E-mail клиента :</label>
                    {!! Form::text('client_email', $order['client_email'], ['class' => 'form-control']) !!}
                    @if ($errors->has('client_email'))
                        <div class="error-msg">{{ $errors->first('client_email') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Партнер :</label>
                    <select name="partner_id" class="form-control">
                        <option value="">- выбрать -</option>
                        @foreach ($partners as $partner)
                        <option value="{{ $partner['id'] }}" {{old('partner_id',$partner['id'])==$order['partner_id']? 'selected':''}}>{{ $partner['name'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('partner_id'))
                        <div class="error-msg">{{ $errors->first('partner_id') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Статус заказа :</label>
                    {!! Form::select('status', [-1 => '- выбрать -'] + config('prj.status_list'), $order['status'], ['class' => 'form-control']) !!}
                    @if ($errors->has('status'))
                        <div class="error-msg">{{ $errors->first('status') }}</div>
                    @endif
                </div>
                <h3>Список продуктов</h3>
                <table class="table table-hover table-striped">
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
                    <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th>Cтоимость заказ</th>
                        <th>{{ $order['cost'] }}</th>
                    </tr>
                    </tfoot>
                </table>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
@endsection