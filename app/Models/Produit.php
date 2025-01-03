<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approvisionnement;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Categorie;
use App\Models\User;
use App\Notifications\ProduitAlerte;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'quantite_stock',
        'category_id',
        'seuil_reapprovisionnement',
        'fournisseur_id',
    ];

    /**
     * Retourne le fournisseur auquel le produit appartient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Retourne la catégorie à laquelle le produit appartient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Retourne les approvisionnements rattachés au produit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
        public function approvisionnements()
    {
        return $this->hasMany(Approvisionnement::class, 'produit_id');
    }

    /**
     * Retourne les commandes qui contiennent ce produit.
     * 
     * La relation est many-to-many et est stockée dans la table pivot
     * "commande_produit". Les champs supplémentaires stockés dans la table
     * pivot sont "quantite" et "prix_unitaire".
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function updateStock($quantity, $type = 'increment')
    {
        try {
             // Cast quantity to integer
            $quantity = (int) $quantity;
            if ($type === 'decrement') {
                if ($this->quantite_stock < $quantity) {
                    throw new \Exception("Stock insuffisant pour {$this->nom}");
                }
                $this->decrement('quantite_stock', $quantity);
                
                // Check threshold after decrement
                if ($this->quantite_stock <= $this->seuil_reapprovisionnement) {
                    $this->triggerLowStockAlert($this);
                }
            } else {
                $this->increment('quantite_stock', $quantity);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du stock: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getLatestPrice()
    {
        return $this->approvisionnements()
            ->orderBy('date_livraison', 'desc')
            ->value('prix_unitaire') ?? 0;
    }
    

    private function triggerLowStockAlert($produit)
    {
        $alerte = [
            'produit_id' => $produit->id,
            'quantite_stock' => $produit->quantite_stock,
            'seuil_reapprovisionnement' => $produit->seuil_reapprovisionnement,
        ];

        if ($produit->fournisseur) {
            $produit->fournisseur->notify(new ProduitAlerte($alerte));
        }

        User::role('Administrateur')->each(function ($admin) use ($alerte) {
            $admin->notify(new ProduitAlerte($alerte));
        });
    }

}
