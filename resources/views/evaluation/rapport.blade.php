<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'évaluation</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Rapport d'évaluation du stagiaire</h1>

    <!-- Vérification de l'existence du nom du stagiaire et de son service -->
    <p><strong>Stagiaire :</strong> {{ $stagiaire->user->name ?? 'Nom non disponible' }}</p>
    <p><strong>Service :</strong> {{ $stagiaire->service->nom ?? 'Service non disponible' }}</p>
    <p><strong>Date d'évaluation :</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <h3>Détails des tâches :</h3>

    <!-- Vérification si des travaux sont passés à la vue -->
    @if ($travaux->isEmpty())
        <p>Aucun travail associé au stagiaire.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Titre de la tâche</th>
                    <th>Description</th>
                    <th>Durée prévue</th>
                    <th>Durée effective</th>
                    <th>Note</th>
                    <th>Validation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($travaux as $tache)
                    <tr>
                        <td>{{ $tache->titre ?? 'Non disponible' }}</td>
                        <td>{{ $tache->description ?? 'Non disponible' }}</td>
                        <td>{{ $tache->duree_prevue ?? 'Non disponible' }}</td>
                        <td>{{ $tache->duree_effective ?? 'Non disponible' }}</td>
                        <td>{{ $tache->note ?? 'Non notée' }}</td>
                        <td>{{ $tache->validation_superviseur ? 'Validée' : 'Non validée' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h3>Note finale :</h3>
    <p><strong>{{ $note_finale }}/100</strong></p>
</body>
</html>
