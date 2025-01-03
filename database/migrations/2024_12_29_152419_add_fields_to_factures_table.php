<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('commande_id');
            $table->string('statut_paiement')
                  ->default('en_attente')
                  ->change();
    
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            // Add check constraint
            DB::statement("ALTER TABLE factures ADD CONSTRAINT check_statut_paiement CHECK (statut_paiement IN ('payé', 'en_attente', 'annulé'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop foreign key for user_id
            $table->dropColumn('user_id'); // Drop user_id field
            $table->string('statut_paiement', 50)->nullable()->change(); // Revert statut_paiement to its original state
        });
    }
};
