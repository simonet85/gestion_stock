<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Approvisionnement;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['produit', 'user'])
            ->orderBy('date_transaction', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
    public function export()
    {
        $transactions = Transaction::with(['produit', 'user'])
            ->orderBy('date_transaction', 'desc')
            ->get();

        return Excel::download(new TransactionsExport($transactions), 'transactions.xlsx');
    }
    public function generateReport(Request $request)
    {
        $startDate = $request->start_date 
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth()->startOfDay();
        
        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();
    
        $transactions = Transaction::with(['produit.approvisionnements', 'user', 'produit.commandes'])
            ->whereBetween('date_transaction', [$startDate, $endDate])
            ->get()
            ->map(function ($transaction) {
                if ($transaction->type === 'vente') {
                    $commande = Commande::whereHas('produits', function($query) use ($transaction) {
                        $query->where('produit_id', $transaction->produit_id)
                            ->where('commande_produit.quantite', $transaction->quantité);
                    })->first();
                    
                    $transaction->montant = $commande 
                        ? $commande->produits->where('id', $transaction->produit_id)->first()->pivot->prix_unitaire * $transaction->quantité
                        : 0;
                } elseif ($transaction->type === 'achat') {
                    $approvisionnement = $transaction->produit->approvisionnements()
                        ->where('quantité_fournie', $transaction->quantité)
                        ->where('date_livraison', $transaction->date_transaction)
                        ->first();
                        
                    $transaction->montant = $approvisionnement 
                        ? $approvisionnement->prix_unitaire * $transaction->quantité
                        : 0;
                }
                return $transaction;
            })
            ->groupBy('type');
    
        // Calculate totals
        $totalVentes = $transactions->get('vente', collect())->sum('montant');
        $totalAchats = $transactions->get('achat', collect())->sum('montant');
    
        $pdf = PDF::loadView('transactions.report', [
            'transactions' => $transactions,
            'totalVentes' => $totalVentes,
            'totalAchats' => $totalAchats,
            'totalAnnulations' => $transactions->get('annulé', collect())->sum('montant'),
            'startDate' => $startDate->format('d/m/Y'),
            'endDate' => $endDate->format('d/m/Y'),
            'grandTotal' => $totalVentes - $totalAchats // Add net total
        ]);
    
        return $pdf->download('rapport_transactions.pdf');
    }
    

    
}
