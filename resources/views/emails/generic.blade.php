<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #4b5563; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">{{ $subjectText }}</div>
        <div>
            {!! nl2br(e($contentText)) !!}
        </div>
        <div class="footer">
            Cordialement,<br>
            L'équipe {{ config('app.name') }}
        </div>
    </div>
</body>
</html>
