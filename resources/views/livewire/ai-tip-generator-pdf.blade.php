<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Plan d'Étude - {{ $subject }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #1e3a8a; margin-top: 0; font-size: 22px; text-transform: uppercase; }
        .meta { font-size: 10px; color: #6b7280; margin-bottom: 20px; }
        .profile-grid { display: table; width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .profile-item { display: table-cell; padding: 10px; border: 1px solid #e5e7eb; background-color: #f9fafb; width: 33.33%; }
        .profile-label { font-size: 8px; font-weight: bold; color: #3b82f6; text-transform: uppercase; margin-bottom: 5px; }
        .profile-value { font-size: 11px; color: #111827; font-weight: bold; }
        .plan-content { background-color: #ffffff; border: 1px solid #f3f4f6; border-radius: 12px; padding: 25px; font-size: 12px; }
        .footer { margin-top: 50px; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 15px; }
        .markdown-plan { white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Plan d'Étude: {{ $subject }}</h1>
        <div class="meta">Généré le {{ $generatedAt->format('d/m/Y à H:i') }}</div>
    </div>

    <div class="profile-grid">
        <div class="profile-item">
            <div class="profile-label">Niveau</div>
            <div class="profile-value">{{ $academicLevel }}</div>
        </div>
        <div class="profile-item">
            <div class="profile-label">Style</div>
            <div class="profile-value">{{ $learningStyle }}</div>
        </div>
        <div class="profile-item">
            <div class="profile-label">Intensité</div>
            <div class="profile-value">{{ $hours }}h/Jour</div>
        </div>
    </div>

    <div class="plan-content">
        <div class="markdown-plan">
            {!! $plan !!}
        </div>
    </div>

    <div class="footer">
        <p>Studdy Friend • Votre assistant d'apprentissage intelligent</p>
    </div>
</body>
</html>
