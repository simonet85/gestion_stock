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
        DB::table('produits')->insert([
            ['nom' => 'Télévision', 'description' => 'Smart TV 55 pouces', 'quantité_Stock' => 20, 'category_id' => 1],
            ['nom' => 'Canapé', 'description' => 'Canapé en cuir 3 places', 'quantité_Stock' => 10, 'category_id' => 2],
            ['nom' => 'Tondeuse', 'description' => 'Tondeuse électrique pour pelouse', 'quantité_Stock' => 15, 'category_id' => 3],
        ]);
    }
}
