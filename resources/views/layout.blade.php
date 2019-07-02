<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ (isset($page_title) ? $page_title : config('app.name')) }}</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

</head>
<body>
<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}">Тестовое задание</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @php
                    $menu = [
                        'wheather' => 'Погода',
                        'order.list' => 'Заказы',
                        'product.list' => 'Продукты',
                    ]
                @endphp
                @foreach ($menu as $key => $item)
                <li class="{{ (request()->is($key.'*')) ? 'active' : '' }}"><a href="{{route($key)}}">{{$item}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="container main-container">
    <h1 class="msin-title">{{ (isset($page_title) ? $page_title : config('app.name')) }}</h1>
    @if (session('status'))
        <div class="alert alert-success">
            {!! session('status') !!}
        </div>
    @endif
    @yield('content')
</div>

<div id="footer">
    <div class="container">
        <p class="text-muted">Иван Ватутин <a href="mailto:ivatutin@gmail.com">ivatutin@gmail.com</a></p>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>