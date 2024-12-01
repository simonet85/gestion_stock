<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'nom_catégorie' => 'Électronique', 'description' => 'Appareils électroniques divers'],
            ['id' => 2, 'nom_catégorie' => 'Maison', 'description' => 'Articles pour la maison'],
            ['id' => 3, 'nom_catégorie' => 'Jardinage', 'description' => 'Outils et équipements pour le jardin'],
        ]);
    }
}
