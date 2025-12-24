<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #fee2e2; border-radius: 8px; background-color: #fef2f2; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #dc2626; }
        .content { padding: 15px; background: white; border-radius: 4px; border: 1px solid #fecaca; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Alerte Système - {{ config('app.name') }}</div>
        <div class="content">
            {{ $alertMessage }}
        </div>
        <p>Ceci est une notification automatique générée par le système.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</body>
</html>








