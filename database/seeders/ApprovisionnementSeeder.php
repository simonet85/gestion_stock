<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApprovisionnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('approvisionnements')->insert([
            ['produit_id' => 1, 'fournisseur_id' => 1, 'date_livraison' => '2024-11-01', 'quantité_fournie' => 50, 'prix_unitaire' => 500.00],
            ['produit_id' => 2, 'fournisseur_id' => 2, 'date_livraison' => '2024-11-02', 'quantité_fournie' => 30, 'prix_Unitaire' => 300.00],
        ]);
    }
}
