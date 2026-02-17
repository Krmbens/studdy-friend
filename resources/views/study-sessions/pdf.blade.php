<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Session d'Étude - {{ $session->subject }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #1e3a8a; margin: 0; font-size: 24px; }
        .meta { color: #6b7280; font-size: 12px; margin-top: 5px; }
        .info-grid { display: table; width: 100%; margin: 20px 0; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; font-weight: bold; padding: 8px; background: #f3f4f6; width: 30%; }
        .info-value { display: table-cell; padding: 8px; border-bottom: 1px solid #e5e7eb; }
        .notes-section { margin-top: 30px; padding: 15px; background: #f9fafb; border-left: 4px solid #3b82f6; }
        .notes-title { font-weight: bold; color: #1e3a8a; margin-bottom: 10px; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Session d'Étude</h1>
        <div class="meta">Rapport généré le {{ now()->locale('fr')->isoFormat('DD MMMM YYYY à HH:mm') }}</div>
    </div>

    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Matière</div>
            <div class="info-value">{{ $session->subject }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date de Session</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($session->session_date)->locale('fr')->isoFormat('dddd DD MMMM YYYY') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Durée</div>
            <div class="info-value">{{ floor($session->duration_minutes / 60) }}h {{ $session->duration_minutes % 60 }}m ({{ $session->duration_minutes }} minutes)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Enregistré le</div>
            <div class="info-value">{{ $session->created_at->locale('fr')->isoFormat('DD MMMM YYYY à HH:mm') }}</div>
        </div>
    </div>

    @if($session->notes)
    <div class="notes-section">
        <div class="notes-title">📝 Notes de Session</div>
        <div>{{ $session->notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p>Study Friend - Réussissez vos études</p>
        <p>Document confidentiel - Usage personnel uniquement</p>
    </div>
</body>
</html>
