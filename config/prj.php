<?php

return [
    'mail_from' => [
        'address' => 'test@local.loc',
        'name' => 'Test Name'
    ],
    'yandex_weather_api_host' => 'https://api.weather.yandex.ru/v1/forecast',
    'yndex_key' => 'bd37d928-3d07-400a-a373-f388f484e976',
    'products_on_page' => 25,
    'orders_on_page' => 50,
    'status_list' => [
        '0' =>  'новый',
        '10' => 'подтвержден',
        '20' => 'завершен'
    ],
    'order_tabs' => [
        'all' => [
            'type' => '',
            'title' => 'Все заказы',
            'on_page' => 50
        ],
        'overdue' => [
            'type' => 'overdue',
            'title' => 'Просроченные',
            'on_page' => 0
        ],
        'current' => [
            'type' => 'current',
            'title' => 'Текущие',
            'on_page' => 50
        ],
        'new' => [
            'type' => 'new',
            'title' => 'Новые',
            'on_page' => 50
        ],
        'performed' => [
            'type' => 'performed',
            'title' => 'Выполненные',
            'on_page' => 50
        ]
    ]
];