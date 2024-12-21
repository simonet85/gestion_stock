<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
                $table->renameColumn('quantité_stock', 'quantite_stock'); // rename existing column
                $table->integer('seuil_reapprovisionnement')->nullable(); // New column
                $table->foreignId('fournisseur_id')->constrained()->onDelete('cascade'); // Add foreign key
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['fournisseur_id']); // Drop foreign key
            $table->dropColumn(['seuil_reapprovisionnement']); // Drop new column
            $table->renameColumn('quantite_stock', 'quantité_stock'); // Revert changes if needed
        });
    }
};
