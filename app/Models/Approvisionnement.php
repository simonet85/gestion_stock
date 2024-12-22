<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;

    protected $fillable = ['produit_id', 'quantité_fournie', 'prix_unitaire', 'date_livraison', 'fournisseur_id'];

/**
 * Retourne le produit associé à l'approvisionnement.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

/**
 * Retourne le fournisseur associé à l'approvisionnement.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
