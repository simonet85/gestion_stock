<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'quantité',
        'date_transaction',
        'user_id',
        'produit_id'
    ];

    protected $casts = [
        'date_transaction' => 'datetime',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class)
            ->withPivot('prix_unitaire', 'quantite');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function recordSale($commande)
    {
        DB::transaction(function () use ($commande) {
            foreach ($commande->produits as $produit) {
                self::create([
                    'type' => 'vente',
                    'quantité' => $produit->pivot->quantite,
                    'date_transaction' => now(),
                    'user_id' => $commande->user_id,
                    'produit_id' => $produit->id
                ]);

                // Update stock
                $produit->updateStock('decrement', $produit->pivot->quantite);
            }
        });
    }

    public static function recordPurchase($approvisionnement)
    {
        DB::transaction(function () use ($approvisionnement) {
            self::create([
                'type' => 'achat',
                'quantité' => $approvisionnement->quantité_fournie,
                'date_transaction' => $approvisionnement->date_livraison,
                'user_id' => auth()->id(),
                'produit_id' => $approvisionnement->produit_id
            ]);

            // Update stock
            $approvisionnement->produit->updateStock('increment', $approvisionnement->quantité_fournie);
        });
    }
}
