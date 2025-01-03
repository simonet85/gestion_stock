<?php

namespace App\Models;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'user_id',
        'montant',
        'statut_paiement'
    ];

    public static function generateFromOrder($commande)
    {
        return self::create([
            'commande_id' => $commande->id,
            'user_id' => $commande->user_id,
            'montant' => $commande->calculateTotal(),
            'statut_paiement' => 'en_attente'
        ]);
    }

    public function markAsPaid()
    {
        $this->update(['statut_paiement' => 'payé']);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
