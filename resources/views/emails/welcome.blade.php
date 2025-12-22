<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #2563eb; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Bienvenue, {{ $user->display_name }} !</div>
        <p>Nous sommes ravis de vous accueillir sur <strong>{{ config('app.name') }}</strong>.</p>
        <p>Votre compte a été créé avec succès. Vous pouvez maintenant accéder à tous nos services d'hébergement performants.</p>
        <p>Si vous avez des questions, n'hésitez pas à contacter notre support.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>




