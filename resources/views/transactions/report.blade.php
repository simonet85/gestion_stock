<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .company-info {
            margin-bottom: 30px;
            color: #666;
        }
        .date-range {
            margin-bottom: 20px;
            text-align: right;
            color: #666;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        .total-section {
            margin-top: 30px;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }
        .type-header {
            color: #2c3e50;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .montant {
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            margin-top: 30px;
            text-align: right;
            font-size: 1.2em;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Transactions</h1>
        <p class="company-info">StockPro</p>
    </div>

    <div class="date-range">
        <p>Période: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <th>Total Ventes</th>
                <th>Total Achats</th>
                <th>Total Annulations</th>
                <th>Bénéfice Net</th>
            </tr>
            <tr>
                <td class="montant">{{ number_format($totalVentes, 2) }} CFA</td>
                <td class="montant">{{ number_format($totalAchats, 2) }} CFA</td>
                <td class="montant">{{ number_format($totalAnnulations, 2) }} CFA</td>
                <td class="montant">{{ number_format($totalVentes - $totalAchats, 2) }} CFA</td>
            </tr>
        </table>
    </div>

    @foreach(['vente', 'achat', 'annulé'] as $type)
        @if($transactions->has($type))
            <h3 class="type-header">{{ ucfirst($type) }}s</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Utilisateur</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions->get($type) as $transaction)
                        <tr>
                            <td>{{ $transaction->date_transaction->format('d/m/Y') }}</td>
                            <td>{{ $transaction->produit->nom }}</td>
                            <td>{{ $transaction->quantité }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td class="montant">{{ number_format($transaction->montant, 2) }} CFA</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total {{ ucfirst($type) }}s:</strong></td>
                        <td class="montant">
                            <strong>{{ number_format($transactions->get($type)->sum('montant'), 2) }} CFA</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endforeach

    <div class="grand-total">
        <p><strong>Bénéfice Net Total: {{ number_format($totalVentes - $totalAchats, 2) }} CFA</strong></p>
    </div>
</body>
</html>
