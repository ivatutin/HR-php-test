@extends('layout')

@section('content')
    <div class="panel panel-succes">
        <div class="panel-heading">
            Россия &raquo; Брянская область &raquo; Брянск
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <img src="https://yastatic.net/weather/i/icons/blueye/color/svg/{{ $data['fact']['icon'] }}.svg">
                </div>
                <div class="col-sm-3">
                    <h1>{{ $data['fact']['temp'] }}°C</h1>
                    {{ $data['fact']['condition_title'] }}<br>
                    Ощущаемая температура {{ $data['fact']['feels_like'] }}°C.<br>
                </div>
                <div class="col-sm-3">
                    Ветер {{ $data['fact']['wind_dir_title'] }}, {{ $data['fact']['wind_speed'] }}м/с<br>
                    Ппорывы ветра до {{ $data['fact']['wind_gust'] }}м/с<br>
                    Давление {{ $data['fact']['pressure_mm'] }} мм рт. ст.<br>
                    Влажность воздуха {{ $data['fact']['humidity'] }}%
                </div>
                <div class="col-sm-3">
                    {{ $data['fact']['prec_strength_title'] }}<br>
                    {{ $data['fact']['cloudness_title'] }}
                    @if (isset($data['fact']['temp_water']))
                        Температура воды {{ $data['fact']['temp_water'] }}°C. ??<br>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
