<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Sample data for produits table
            $produits = [
                [
                    'nom' => 'Produit A',
                    'description' => 'Description for Produit A',
                    'quantite_stock' => 100,
                    'category_id' => 1,
                    'seuil_reapprovisionnement' => 10,
                    'fournisseur_id' => 1, // Ensure this ID exists in fournisseurs table
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nom' => 'Produit B',
                    'description' => 'Description for Produit B',
                    'quantite_stock' => 50,
                    'category_id' => 2,
                    'seuil_reapprovisionnement' => 5,
                    'fournisseur_id' => 2, // Ensure this ID exists in fournisseurs table
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nom' => 'Produit C',
                    'description' => 'Description for Produit C',
                    'quantite_stock' => 200,
                    'category_id' => 3,
                    'seuil_reapprovisionnement' => 20,
                    'fournisseur_id' => 2, // Ensure this ID exists in fournisseurs table
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
    
            // Insert data into produits table
            DB::table('produits')->insert($produits);
        }
    }

