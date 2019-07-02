<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Whether extends Model
{
    //
    static public function get() {
        return Cache::remember('wheather', 60, function () {
            $client = new Client([
                'base_uri' => config('prj.yandex_weather_api_host'),
                'headers' => [
                    'X-Yandex-API-Key' => config('prj.yndex_key')
                ]
            ]);
            $response = $client->request('GET', '', [
                'query' => [
                    'lat' => 53.25209,
                    'lon' => 34.37167,
                    'extra' => true
                ]
            ]);

            $ret = false;

            if (200 == $response->getStatusCode()) {
                $meta = [
                    'condition' => [
                        'clear' => 'ясно',
                        'partly-cloudy' => 'малооблачно',
                        'cloudy' => 'облачно с прояснениями',
                        'overcast' => 'пасмурно',
                        'partly-cloudy-and-light-rain' => 'небольшой дождь',
                        'partly-cloudy-and-rain' => 'дождь',
                        'overcast-and-rain' => 'сильный дождь',
                        'overcast-thunderstorms-with-rain' => 'сильный дождь, гроза',
                        'cloudy-and-light-rain' => 'небольшой дождь',
                        'overcast-and-light-rain'  => 'небольшой дождь',
                        'cloudy-and-rain' => 'дождь',
                        'overcast-and-wet-snow' => 'дождь со снегом',
                        'partly-cloudy-and-light-snow' => 'небольшой снег',
                        'partly-cloudy-and-snow'  => 'снег',
                        'overcast-and-snow' => 'снегопад',
                        'cloudy-and-light-snow' => 'небольшой снег',
                        'overcast-and-light-snow' => 'небольшой снег',
                        'cloudy-and-snow' => 'снег'
                    ],
                    'wind_dir' => [
                        'nw' => 'северо-западное',
                        'n' => 'северное',
                        'ne' => 'северо-восточное',
                        'e' => 'восточное',
                        'se' => 'юго-восточное',
                        's' => 'южное',
                        'sw' => 'юго-западное',
                        'w' => 'западное',
                        'с' => 'штиль'
                    ],
                    'prec_strength' => [
                        '0' =>'без осадков',
                        '0.25' => 'слабый дождь/слабый снег',
                        '0.5' => 'дождь/снег',
                        '0.75' => 'сильный дождь/сильный снег',
                        '1' => 'сильный ливень/очень сильный снег'
                    ],
                    'cloudness' => [
                        '0' => 'ясно',
                        '0.25' => 'малооблачно',
                        '0.5' => 'облачно с прояснениями',
                        '0.75' => 'облачно с прояснениями',
                        '1' => 'пасмурно'
                    ]
                ];
                $ret = json_decode($response->getBody(), true);
                $ret['fact']['condition_title'] = $meta['condition'][$ret['fact']['condition']];
                $ret['fact']['wind_dir_title'] = $meta['wind_dir'][$ret['fact']['wind_dir']];
                $ret['fact']['prec_strength_title'] = $meta['prec_strength'][$ret['fact']['prec_strength']];
                $ret['fact']['cloudness_title'] = $meta['cloudness'][$ret['fact']['cloudness']];
            }

            return $ret;
        });
    }
}
