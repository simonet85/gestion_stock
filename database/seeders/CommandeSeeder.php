<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('commandes')->insert([
            ['date_commande' => '2024-11-10', 'statut' => 'En cours', 'quantité_totale' => 5, 'montant_total' => 2500.00, 'user_id' => 2],
        ]);
    }
}
