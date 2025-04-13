<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Examens</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { color: #4D44B5; font-size: 24px; font-weight: bold; }
        .subtitle { color: #6B7280; font-size: 14px; margin-bottom: 10px; }
        .period { font-size: 14px; margin-bottom: 20px; }
        .section-title { color: #4D44B5; font-size: 18px; font-weight: bold; margin: 15px 0 10px 0; border-bottom: 1px solid #E5E7EB; padding-bottom: 5px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { border: 1px solid #E5E7EB; border-radius: 8px; padding: 15px; text-align: center; }
        .stat-value { color: #4D44B5; font-size: 24px; font-weight: bold; margin: 5px 0; }
        .stat-label { color: #6B7280; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #F3F4F6; color: #374151; text-align: left; padding: 8px; font-size: 12px; }
        td { border: 1px solid #E5E7EB; padding: 8px; font-size: 12px; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; display: inline-block; }
        .badge-success { background-color: #D1FAE5; color: #065F46; }
        .badge-warning { background-color: #FEF3C7; color: #92400E; }
        .badge-danger { background-color: #FEE2E2; color: #991B1B; }
        .badge-info { background-color: #DBEAFE; color: #1E40AF; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Rapport des Examens</div>
        <div class="subtitle">Statistiques et analyses des examens passés</div>
        <div class="period">Période du {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</div>
    </div>

    <!-- Statistiques principales -->
    <div class="section-title">Statistiques Globales</div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_examens'] }}</div>
            <div class="stat-label">Examens total</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['examens_termines'] }}</div>
            <div class="stat-label">Examens terminés</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['taux_reussite_global'] ? number_format($stats['taux_reussite_global'], 2) . '%' : 'N/A' }}</div>
            <div class="stat-label">Taux de réussite</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['candidats_inscrits'] }}</div>
            <div class="stat-label">Candidats inscrits</div>
        </div>
    </div>

    <!-- Taux de réussite par type -->
    <div class="section-title">Taux de Réussite par Type d'Examen</div>
    <table>
        <thead>
            <tr>
                <th>Type d'examen</th>
                <th>Nombre d'examens</th>
                <th>Taux de réussite moyen</th>
                <th>Candidats présents</th>
            </tr>
        </thead>
        <tbody>
            @foreach($successRates as $rate)
                <tr>
                    <td>{{ $rate->type }}</td>
                    <td>{{ $rate->total }}</td>
                    <td>{{ number_format($rate->taux_moyen, 2) }}%</td>
                    <td>{{ $rate->total_presents }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Top moniteurs -->
    <div class="section-title">Top Moniteurs</div>
    <table>
        <thead>
            <tr>
                <th>Moniteur</th>
                <th>Examens terminés</th>
                <th>Taux de réussite moyen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($moniteursStats as $moniteur)
                <tr>
                    <td>{{ $moniteur->name }}</td>
                    <td>{{ $moniteur->exams_termines }}</td>
                    <td>
                        <span class="badge {{ $moniteur->taux_reussite_moyen >= 70 ? 'badge-success' : ($moniteur->taux_reussite_moyen >= 50 ? 'badge-warning' : 'badge-danger') }}">
                            {{ $moniteur->taux_reussite_moyen ? number_format($moniteur->taux_reussite_moyen, 2) . '%' : 'N/A' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Détails des examens -->
    <div class="section-title">Détails des Examens</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Taux réussite</th>
                <th>Candidats (présents/inscrits)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($exam->date_exam)->format('d/m/Y') }}</td>
                    <td>{{ $exam->type }}</td>
                    <td>
                        <span class="badge {{ $exam->statut === 'termine' ? 'badge-success' : ($exam->statut === 'en_cours' ? 'badge-info' : 'badge-warning') }}">
                            {{ $exam->statut === 'termine' ? 'Terminé' : ($exam->statut === 'en_cours' ? 'En cours' : 'Planifié') }}
                        </span>
                    </td>
                    <td>{{ $exam->taux_reussite ? number_format($exam->taux_reussite, 2) . '%' : 'N/A' }}</td>
                    <td>{{ $exam->nombre_presents ?? 0 }}/{{ $exam->nombre_inscrits ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; color: #6B7280; font-size: 11px;">
        Généré le {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>
</html>