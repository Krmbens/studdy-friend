<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $assignment->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { color: #1e3a8a; margin: 0; font-size: 24px; }
        .meta { color: #6b7280; font-size: 12px; margin-top: 5px; }
        .status-badge { 
            display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; 
        }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-pending { background-color: #f3f4f6; color: #1f2937; }
        
        .priority-high { color: #ef4444; }
        .priority-medium { color: #f59e0b; }
        .priority-low { color: #10b981; }

        .section { margin-bottom: 20px; }
        .label { font-weight: bold; font-size: 12px; color: #4b5563; text-transform: uppercase; margin-bottom: 4px; }
        .value { font-size: 14px; }
        .description-box { background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 15px; border-radius: 8px; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $assignment->title }}</h1>
        <div class="meta">
            {{ $assignment->subject }} • 
            <span class="priority-{{ $assignment->priority }}">Priorité {{ ucfirst($assignment->priority) }}</span>
        </div>
    </div>

    <div class="section">
        <div class="label">Date limite</div>
        <div class="value">{{ \Carbon\Carbon::parse($assignment->deadline)->format('d/m/Y') }}</div>
    </div>

    <div class="section">
        <div class="label">Statut</div>
        <div class="value">
            @if($assignment->completed)
                <span class="status-badge status-completed">Terminé</span>
            @else
                <span class="status-badge status-pending">En cours</span>
            @endif
        </div>
    </div>

    @if($assignment->description)
    <div class="section">
        <div class="label">Description</div>
        <div class="description-box">
            {{ $assignment->description }}
        </div>
    </div>
    @endif

    <div class="footer">
        Céer par Neural Nexus • Assistant d'Étude Personnel
    </div>
</body>
</html>
