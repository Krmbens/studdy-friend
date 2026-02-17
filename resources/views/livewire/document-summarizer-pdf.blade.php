<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Résumé de Document</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; margin-bottom: 30px; }
        .style-tag { display: inline-block; background-color: #eff6ff; color: #1e40af; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: bold; text-transform: uppercase; border: 1px solid #bfdbfe; }
        h1 { color: #1e3a8a; margin-top: 10px; font-size: 24px; }
        .content-box { background-color: #ffffff; border: 1px solid #f3f4f6; border-radius: 12px; padding: 20px; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="style-tag">{{ $style }}</div>
        <h1>Résumé de Document</h1>
        <p style="font-size: 12px; color: #6b7280;">Généré le {{ $generatedAt->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="content-box">
        {!! \Illuminate\Support\Str::markdown($summary) !!}
    </div>
    <div class="footer">
        <p>Document généré par l'Assistant Étudiant IA • Studdy Friend</p>
    </div>
</body>
</html>
