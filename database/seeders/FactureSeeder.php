<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('factures')->insert([
            ['commande_id' => 2, 'montant' => 2500.00, 'statut_paiement' => 'Payé'],
        ]);
    }
}
