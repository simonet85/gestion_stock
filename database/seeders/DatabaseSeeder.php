<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        $this->call([
            CategorieSeeder::class,
            ProduitSeeder::class,
            FournisseurSeeder::class,
            ApprovisionnementSeeder::class,
            // UtilisateurSeeder::class,
            CommandeSeeder::class,
            TransactionSeeder::class,
            FactureSeeder::class,
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
