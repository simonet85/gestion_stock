<?php
// app/Exports/TransactionsExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                'ID' => $transaction->id,
                'Type' => $transaction->type,
                'Date' => $transaction->date_transaction,
                'Produit' => $transaction->produit->nom,
                'Quantité' => $transaction->quantité,
                'Utilisateur' => $transaction->user->name
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Type',
            'Date',
            'Produit',
            'Quantité',
            'Utilisateur'
        ];
    }
}
