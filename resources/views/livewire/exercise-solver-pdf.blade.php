<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Solution - {{ $subject }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            line-height: 1.6;
            color: #1f2937;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .subject-tag {
            display: inline-block;
            background-color: #eff6ff;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #bfdbfe;
        }
        h1 { 
            color: #1e3a8a; 
            margin-top: 10px;
            font-size: 24px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
        }
        .problem-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            font-style: italic;
        }
        .solution-box {
            background-color: #ffffff;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            padding: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <div class="subject-tag">{{ $subject }}</div>
        <h1>Résolution d'Exercice</h1>
        <p style="font-size: 12px; color: #6b7280;">Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
    
    <div class="section">
        <div class="section-title">Énoncé de l'exercice</div>
        <div class="problem-box">
            {{ $problemStatement }}
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Solution détaillée</div>
        <div class="solution-box">
            {!! $solutionHtml !!}
        </div>
    </div>
    
    <div class="footer">
        <p>Document généré par l'Assistant Étudiant IA • Studdy Friend</p>
    </div>
    
</body>
</html>
