<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistiques - {{ $user->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f3f4f6; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 50px; text-align: center; color: #666; font-size: 12px; }
        .stats-grid { margin-bottom: 30px; }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>📊 Rapport de Statistiques</h1>
        <p>{{ $user->name }} - {{ $generatedAt->format('d/m/Y H:i') }}</p>
    </div>
    
    <div class="stats-grid">
        <h2>Résumé Global</h2>
        <table>
            <tr>
                <th>Métrique</th>
                <th>Valeur</th>
            </tr>
            <tr>
                <td>Total Devoirs</td>
                <td>{{ $totalAssignments }}</td>
            </tr>
            <tr>
                <td>Devoirs Terminés</td>
                <td>{{ $completedAssignments }}</td>
            </tr>
            <tr>
                <td>Taux de Complétion</td>
                <td>{{ $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100) : 0 }}%</td>
            </tr>
            <tr>
                <td>Temps d'Étude Total</td>
                <td>{{ floor($totalStudyTime / 60) }}h {{ $totalStudyTime % 60 }}m</td>
            </tr>
        </table>
    </div>
    
    <div class="stats-grid">
        <h2>Matières les Plus Étudiées</h2>
        <table>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Temps Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSubjects as $subject)
                    <tr>
                        <td>{{ $subject->subject }}</td>
                        <td>{{ floor($subject->total / 60) }}h {{ $subject->total % 60 }}m</td>
                    </tr>
                @endforeach
                @if($topSubjects->isEmpty())
                    <tr>
                        <td colspan="2" style="text-align: center;">Aucune donnée disponible</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p>Généré automatiquement par AI Student Assistant</p>
    </div>
    
</body>
</html>
