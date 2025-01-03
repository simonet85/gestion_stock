<?php

namespace App\Http\Controllers;

use App\Models\Facture;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with(['commande', 'user'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('factures.index', compact('factures'));
    }

    

    public function show(Facture $facture)
    {
        $facture->load(['commande.produits', 'user']);
        return view('factures.show', compact('facture'));
    }

    public function generatePDF(Facture $facture)
    {
        $facture->load(['commande.produits', 'user']);
        
        $pdf = Pdf::loadView('factures.pdf', [
            'facture' => $facture,
            'company' => [
                'name' => config('app.name'),
                'address' => config('app.address'),
                'phone' => config('app.phone')
            ]
        ]);
    
        return $pdf->download('facture-' . $facture->id . '.pdf');
    }
}
