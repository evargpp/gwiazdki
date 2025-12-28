<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Raport restauracji</title>
    <style>
        /* Podstawowy wygląd do wydruku */
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 1.5cm;
        }

        h1 {
            text-align: center;
            margin-bottom: 1em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        @media print {
            body {
                margin: 0.5cm;
            }
            a {
                text-decoration: none;
                color: #000;
            }
        }
    </style>
</head>
<body>

    <h1>Raport restauracji – lista według ocen</h1>

    <table>
        <thead>
            <tr>
                <th style="width: 40%">Nazwa</th>
                <th style="width: 40%">Adres</th>
                <th style="width: 10%">Średnia ocena</th>
                <th style="width: 10%">Liczba opinii</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->name }}</td>
                    <td>{{ $restaurant->address }}</td>
                    <td>{{ $restaurant->reviews_avg_rating ? number_format($restaurant->reviews_avg_rating, 1) : 'brak' }}</td>
                    <td>{{ $restaurant->reviews_count ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Raport wygenerowano: {{ now()->format('d-m-Y H:i') }}</p>
    <p>Raport dla uzytkownika: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>

</body>
</html>
