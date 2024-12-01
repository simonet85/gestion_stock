<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fournisseurs')->insert([
            ['nom' => 'Fournisseur A', 'adresse' => '123 Rue Principale', 'téléphone' => '123456789', 'email' => 'contact@fournisseura.com'],
            ['nom' => 'Fournisseur B', 'adresse' => '456 Avenue Centrale', 'téléphone' => '987654321', 'email' => 'contact@fournisseurb.com'],
        ]);
    }
}
