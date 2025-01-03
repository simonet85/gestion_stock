<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produit;
class Commande extends Model
{
    use HasFactory;

    protected $casts = [
        'date_commande' => 'date:d-m-Y',
    ];
    
    protected $fillable = ['date_commande', 'statut', 'quantité_totale', 'montant_total', 'user_id'];

    /**
     * Retourne les produits associés à la commande.
     *
     * Cette fonction utilise la relation many-to-many entre la commande et les produits. 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire'); // Include pivot fields
    }
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    public function calculateTotal()
    {
        return $this->produits->sum(function ($produit) {
            return $produit->pivot->quantite * $produit->pivot->prix_unitaire;
        });
    }

}
