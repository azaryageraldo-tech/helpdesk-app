<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Pusher\Pusher; // <-- Tambahkan ini

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');

        // TAMBAHKAN BLOK KODE INI
        Broadcast::extend('pusher', function ($app, array $config) {
            $options = $config['options'] ?? [];

            // Atur client_options secara manual untuk menonaktifkan verifikasi SSL
            $clientOptions = [
                'curl' => [
                    'verify' => false
                ]
            ];

            return new Pusher(
                $config['key'],
                $config['secret'],
                $config['app_id'],
                $options,
                new \GuzzleHttp\Client($clientOptions)
            );
        });
    }
}
