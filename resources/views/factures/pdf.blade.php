<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $facture->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
        <h2>N° {{ str_pad($facture->id, 5, '0', STR_PAD_LEFT) }}</h2>
    </div>

    <div class="company-info">
        <h3>{{ $company['name'] }}</h3>
        <p>{{ $company['address'] }}<br>
        Tél: {{ $company['phone'] }}</p>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Client:</strong></td>
                <td>{{ $facture->user->name }}</td>
                <td><strong>Date:</strong></td>
                <td>{{ $facture->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $facture->user->email }}</td>
                <td><strong>Statut:</strong></td>
                <td>{{ ucfirst($facture->statut_paiement) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture->commande->produits as $produit)
                <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->pivot->quantite }}</td>
                    <td>{{ number_format($produit->pivot->prix_unitaire, 2) }} CFA</td>
                    <td>{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 2) }} CFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <table style="width: 300px; margin-left: auto;">
            <tr>
                <td><strong>Total:</strong></td>
                <td>{{ number_format($facture->montant, 2) }} CFA</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Merci de votre confiance!</p>
        <p>Pour toute question concernant cette facture, veuillez nous contacter.</p>
    </div>
</body>
</html>
