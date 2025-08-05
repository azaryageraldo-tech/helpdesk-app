<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Balasan Tiket</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 90%; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 24px; font-weight: bold; color: #444; margin-bottom: 20px; }
        .content { margin-bottom: 20px; }
        .quote { background-color: #f9f9f9; border-left: 4px solid #eee; padding: 15px; margin: 15px 0; }
        .button { display: inline-block; background-color: #0d6efd; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Balasan Baru untuk Tiket Anda</div>
        
        <div class="content">
            {{-- Pesan ini akan berbeda tergantung siapa penerimanya --}}
            @if($reply->user->is_admin)
                <p>Halo {{ $ticket->user->name }},</p>
                <p>Tim support kami telah memberikan balasan untuk tiket Anda dengan judul <strong>"{{ $ticket->title }}"</strong>.</p>
            @else
                <p>Halo Tim Support,</p>
                <p>Pengguna <strong>{{ $reply->user->name }}</strong> telah memberikan balasan baru pada tiket #{{ $ticket->id }} dengan judul <strong>"{{ $ticket->title }}"</strong>.</p>
            @endif

            <div class="quote">
                <p><strong>Isi Balasan:</strong></p>
                <p><em>"{!! nl2br(e($reply->body)) !!}"</em></p>
            </div>
            
            <p>Silakan klik tombol di bawah ini untuk melihat detail tiket selengkapnya.</p>
            
            <a href="{{ route('tickets.show', $ticket->id) }}" class="button">Lihat Tiket</a>
        </div>

        <div class="footer">
            <p>Ini adalah email otomatis. Mohon untuk tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>