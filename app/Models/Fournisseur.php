<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'adresse',
        'email',
        'telephone',
    ];

    
    /**
     * Retourne les produits associs à ce fournisseur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    /**
     * Retourne les approvisionnements rattachés à ce fournisseur.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvisionnements()
    {
        return $this->hasMany(Approvisionnement::class, 'fournisseur_id');
    }


}
