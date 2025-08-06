<?php

return [

    // ...

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
            // GANTI BLOK client_options DENGAN INI
            'client_options' => [
                // Memaksa Guzzle untuk menggunakan PHP Stream Handler, bukan cURL
                'handler' => new \GuzzleHttp\Handler\StreamHandler(),
            ],
        ],

        // ...

    ],

];
