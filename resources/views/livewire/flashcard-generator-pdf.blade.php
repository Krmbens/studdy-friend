<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Flashcards - {{ $topic }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 30px; }
        h1 { color: #1e3a8a; margin-top: 0; font-size: 22px; text-transform: uppercase; }
        .meta { font-size: 10px; color: #6b7280; }
        .card { margin-bottom: 20px; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; page-break-inside: avoid; }
        .front { background-color: #f9fafb; padding: 15px; border-bottom: 1px dashed #e5e7eb; }
        .back { background-color: #ffffff; padding: 15px; }
        .label { font-size: 9px; font-weight: bold; color: #3b82f6; text-transform: uppercase; margin-bottom: 5px; }
        .text { font-size: 13px; color: #111827; font-weight: bold; }
        .answer-text { font-size: 12px; color: #4b5563; font-style: italic; }
        .footer { margin-top: 50px; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $topic }}</h1>
        <div class="meta">Paquet de {{ $deck->cards->count() }} flashcards • Généré le {{ $generatedAt->format('d/m/Y') }}</div>
    </div>

    @foreach($deck->cards as $index => $card)
        <div class="card">
            <div class="front">
                <div class="label">Carte #{{ $index + 1 }} - Question</div>
                <div class="text">{{ $card->front_content }}</div>
            </div>
            <div class="back">
                <div class="label">Réponse</div>
                <div class="answer-text">{{ $card->back_content }}</div>
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>Studdy Friend • Optimisez votre mémorisation avec l'IA</p>
    </div>
</body>
</html>
