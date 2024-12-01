<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            ['type' => 'Achat', 'quantité' => 2, 'date_transaction' => '2024-11-15', 'user_id' => 2, 'produit_id' => 1],
        ]);
    }
}
