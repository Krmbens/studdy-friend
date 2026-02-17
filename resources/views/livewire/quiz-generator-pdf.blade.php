<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quiz - {{ $subject }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #1e3a8a; margin-top: 0; font-size: 20px; text-transform: uppercase; }
        .meta { font-size: 10px; color: #6b7280; margin-bottom: 20px; }
        .question-block { margin-bottom: 25px; page-break-inside: avoid; border: 1px solid #f3f4f6; border-radius: 8px; padding: 15px; }
        .q-text { font-weight: bold; font-size: 13px; color: #111827; margin-bottom: 10px; }
        .option { font-size: 12px; color: #4b5563; margin-left: 20px; margin-bottom: 4px; }
        .correct { color: #059669; font-weight: bold; margin-top: 8px; font-size: 11px; }
        .explanation { background-color: #f0f9ff; color: #0369a1; padding: 10px; border-radius: 6px; font-size: 10.5px; margin-top: 8px; font-style: italic; }
        .score-box { background-color: #3b82f6; color: white; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Quiz: {{ $subject }}</h1>
        <div class="meta">Généré le {{ $generatedAt->format('d/m/Y à H:i') }}</div>
    </div>

    @if($score !== null)
        <div class="score-box">
            <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Score Obtenu</div>
            <div style="font-size: 24px; font-weight: 900;">{{ round($score) }}%</div>
        </div>
    @endif

    @foreach($questions as $index => $q)
        <div class="question-block">
            <div class="q-text">{{ $index + 1 }}. {{ $q['question'] }}</div>
            @foreach($q['options'] as $opt)
                <div class="option">• {{ $opt }}</div>
            @endforeach
            <div class="correct">Réponse correcte: {{ $q['correct_answer'] }}</div>
            @if($q['explanation'])
                <div class="explanation">
                    <strong>Explication:</strong> {{ $q['explanation'] }}
                </div>
            @endif
        </div>
    @endforeach

    <div class="footer">
        <p>Généré par Studdy Friend • Votre partenaire de réussite IA</p>
    </div>
</body>
</html>
